<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class WhatsAppService
{
    public function send(string $phoneNumber, string $code): void
    {
        $to = preg_replace('/[^0-9]/', '', $phoneNumber);
        $token = config('services.whatsapp.token');
        $phoneNumberId = config('services.whatsapp.phone_number_id');

        if (config('services.whatsapp.test_mode', false)) {
            Log::info("WhatsApp OTP ({$to}): {$code}");
            return;
        }

        if (!$token || !$phoneNumberId) {
            throw new RuntimeException('وەتسئەپ ڕێکنەخراوە. تکایە بە بەڕێوەبەری سایتهوه پەیوەندی بکە. (WHATSAPP_API_TOKEN / WHATSAPP_PHONE_NUMBER_ID)');
        }

        $response = Http::withToken($token)
            ->acceptJson()
            ->timeout(15)
            ->post("https://graph.facebook.com/v22.0/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $to,
                'type' => 'template',
                'template' => [
                    'name' => config('services.whatsapp.template_name', 'otp_code'),
                    'language' => ['code' => config('services.whatsapp.template_language', 'ar')],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [
                                ['type' => 'text', 'text' => $code],
                            ],
                        ],
                    ],
                ],
            ]);

        if ($response->successful()) {
            return;
        }

        $fallback = Http::withToken($token)
            ->acceptJson()
            ->timeout(15)
            ->post("https://graph.facebook.com/v22.0/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $to,
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => 'کورد ئەی ئای: کۆدی چوونەژوورەوەت ' . $code . ' ـە. ئەم کۆدە دوای 10 خولەک بەسەردەچێت.',
                ],
            ]);

        if ($fallback->successful()) {
            return;
        }

        Log::error('WhatsApp OTP failed', [
            'template' => $response->json(),
            'text' => $fallback->json(),
            'to' => $to,
        ]);

        throw new RuntimeException('ناردنی کۆدەکە لە ڕێگەی وەتسئەپەوە سەرنەکەوت. تکایە دوای چەند خولەکێک دووبارە هەوڵ بدەرەوە.');
    }
}
