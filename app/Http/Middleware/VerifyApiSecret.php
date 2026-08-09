<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Requires `Authorization: Bearer <WEBSITE_API_SECRET>` on machine-to-machine
 * endpoints (the automated news pipeline). Laravel's `hash_equals` keeps the
 * comparison constant-time. Requests without a configured secret fail closed.
 */
class VerifyApiSecret
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('services.website.api_secret');

        if ($expected === '' || ! $request->hasHeader('Authorization')) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => 'Missing or misconfigured API secret.',
            ], 401);
        }

        $provided = trim(str_ireplace('Bearer ', '', $request->header('Authorization')));

        if (! hash_equals($expected, $provided)) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => 'Invalid API secret.',
            ], 401);
        }

        return $next($request);
    }
}
