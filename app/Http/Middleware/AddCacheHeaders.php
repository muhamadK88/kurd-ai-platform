<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cache-Control headers for the hand-rolled SPA pages.
 *
 * Every static asset is cache-busted with a ?v= query string, so the browser
 * can hold them forever (immutable). The public HTML pages are allowed a short
 * browser window so the SPA's page pre-warm fetches are served from cache
 * instead of re-hitting the server on every navigation. Auth/admin flows and
 * anything that already sets its own Cache-Control are never touched.
 */
class AddCacheHeaders
{
    private const IMMUTABLE_PREFIXES = [
        '/css/', '/js/', '/img/', '/images/', '/fonts/', '/assets/', '/data/', '/favicon.',
    ];

    private const PUBLIC_PAGES = [
        '/',
        '/ferga',
        '/courses',
        '/ai-tools',
        '/academic-guide',
        '/news',
        '/universities',
        '/about',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$request->isMethod('GET') && !$request->isMethod('HEAD')) {
            return $response;
        }

        // Respect an explicit Cache-Control, but not the framework default
        // (Symfony always stamps "no-cache, private" on HTML responses).
        $existing = $response->headers->get('Cache-Control', '');
        if ($existing !== '' && $existing !== 'no-cache, private') {
            return $response;
        }

        $path = rawurldecode($request->getPathInfo());

        foreach (self::IMMUTABLE_PREFIXES as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
                return $response;
            }
        }

        if (in_array($path, self::PUBLIC_PAGES, true)) {
            $response->headers->set('Cache-Control', 'public, max-age=30, must-revalidate');
        }

        return $response;
    }
}
