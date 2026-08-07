<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

function probe(string $label, ?string $key, string $base, string $model): void
{
    if (!$key) {
        echo $label . ': NO KEY (env var empty)' . PHP_EOL;
        return;
    }
    try {
        $r = Illuminate\Support\Facades\Http::withToken($key)
            ->timeout(30)
            ->post($base . '/chat/completions', [
                'model' => $model,
                'messages' => [['role' => 'user', 'content' => 'hi']],
                'max_tokens' => 100,
            ]);
        echo $label . ': ' . $r->status() . ' | ' . substr($r->body(), 0, 300) . PHP_EOL;
    } catch (\Throwable $e) {
        echo $label . ': EXCEPTION ' . get_class($e) . ' | ' . $e->getMessage() . PHP_EOL;
    }
}

probe('INFERX_KEY_1 deepseek-v4-flash-0731', env('INFERX_KEY_1'), 'https://model.inferx.net/endpoints/v1', 'deepseek-v4-flash-0731');
probe('INFERX_KEY_6 deepseek-v4-flash', env('INFERX_KEY_6'), 'https://model.inferx.net/endpoints/v1', 'deepseek-v4-flash');
probe('OPENROUTER ling-3.0-flash', env('OPENROUTER_KEY'), 'https://openrouter.ai/api/v1', 'inclusionai/ling-3.0-flash:free');
probe('OPENROUTER nemotron-550b', env('OPENROUTER_KEY'), 'https://openrouter.ai/api/v1', 'nvidia/nemotron-3-ultra-550b-a55b:free');
