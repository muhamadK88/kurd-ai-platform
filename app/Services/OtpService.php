<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class OtpService
{
    public function __construct(private readonly WhatsAppService $whatsapp)
    {
    }

    public function send(string $channel, string $identifier): string
    {
        $channel = in_array($channel, OtpCode::CHANNELS, true) ? $channel : 'email';
        $identifier = $this->normalize($channel, $identifier);

        $cooldownKey = $this->cooldownKey($channel, $identifier);
        $cooldown = (int) config('services.otp.cooldown_seconds', 60);

        if (Cache::has($cooldownKey)) {
            $remaining = max(0, Cache::get($cooldownKey) - now()->timestamp);
            throw new RuntimeException('تکایە دوای ' . $remaining . ' چرکە دووبارە هەوڵ بدەرەوە.');
        }

        OtpCode::unusedFor($channel, $identifier)->delete();

        $code = (string) random_int(100000, 999999);

        $otp = OtpCode::create([
            'channel' => $channel,
            'identifier' => $identifier,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes((int) config('services.otp.expires_minutes', 10)),
        ]);

        try {
            $this->deliver($channel, $identifier, $code);
        } catch (RuntimeException $e) {
            $otp->delete();
            throw $e;
        }

        Cache::put($cooldownKey, now()->timestamp, $cooldown);

        return $this->mask($channel, $identifier);
    }

    public function verify(string $channel, string $identifier, string $code): bool
    {
        $channel = in_array($channel, OtpCode::CHANNELS, true) ? $channel : 'email';
        $identifier = $this->normalize($channel, $identifier);
        $maxAttempts = (int) config('services.otp.max_attempts', 5);

        $otp = OtpCode::unusedFor($channel, $identifier)->latest('id')->first();

        if (!$otp) {
            throw new RuntimeException('کۆدەکە بەسەرچووە یان بەکارهاتووە. تکایە کۆدێکی نوێ بنێرەوە.');
        }

        if ($otp->attempts >= $maxAttempts) {
            $otp->delete();
            throw new RuntimeException('زۆر هەوڵت داوە. تکایە کۆدێکی نوێ بنێرەوە.');
        }

        if (!Hash::check($code, $otp->code_hash)) {
            $otp->increment('attempts');
            if ($otp->attempts >= $maxAttempts) {
                $otp->delete();
                throw new RuntimeException('زۆر هەوڵت داوە. تکایە کۆدێکی نوێ بنێرەوە.');
            }
            throw new RuntimeException('کۆدەکە هەڵەیە. تکایە دووبارە تاقی بکەرەوە.');
        }

        $otp->forceFill(['used_at' => now()])->save();
        OtpCode::unusedFor($channel, $identifier)->where('id', '!=', $otp->id)->delete();

        return true;
    }

    private function deliver(string $channel, string $identifier, string $code): void
    {
        if ($channel === 'phone') {
            $this->whatsapp->send($identifier, $code);
            return;
        }

        try {
            Mail::to($identifier)->send(new OtpMail($code));
        } catch (\Throwable $e) {
            throw new RuntimeException('ناردنی ئیمێڵەکە سەرنەکەوت. تکایە دوای چەند خولەکێک دووبارە هەوڵ بدەرەوە.');
        }
    }

    public function normalize(string $channel, string $identifier): string
    {
        if ($channel === 'phone') {
            $digits = preg_replace('/[^0-9]/', '', $identifier);
            if (str_starts_with($digits, '00')) {
                $digits = substr($digits, 2);
            }
            if (str_starts_with($digits, '964')) {
                $digits = substr($digits, 3);
            }
            if (str_starts_with($digits, '0')) {
                $digits = substr($digits, 1);
            }
            return '+964' . $digits;
        }

        return strtolower(trim($identifier));
    }

    public function mask(string $channel, string $identifier): string
    {
        if ($channel === 'phone') {
            $last4 = substr(preg_replace('/[^0-9]/', '', $identifier), -4);
            return '+964 •••• ' . $last4;
        }

        $parts = explode('@', $identifier);
        $name = $parts[0] ?? '';
        $domain = $parts[1] ?? '';
        if (mb_strlen($name) <= 1) {
            return $identifier;
        }
        return mb_substr($name, 0, 1) . str_repeat('•', 3) . mb_substr($name, -1) . '@' . $domain;
    }

    private function cooldownKey(string $channel, string $identifier): string
    {
        return 'otp_cooldown:' . $channel . ':' . md5($identifier);
    }
}
