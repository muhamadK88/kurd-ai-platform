<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Brotli/gzip compression for HTML and JSON responses.
 *
 * The public pages ship a lot of inline JavaScript (ferga is ~375KB), so
 * compressing the final HTML saves several hundred KB per request. Responses
 * below the threshold, non-GET requests and anything already encoded or
 * streamed (downloads, chunked streams) are left untouched.
 */
class CompressResponse
{
    /** Responses smaller than this are not worth compressing. */
    private const MIN_BYTES = 256;

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!in_array($request->getMethod(), ['GET', 'HEAD'], true)) {
            return $response;
        }

        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return $response;
        }

        if ($response->headers->has('Content-Encoding')) {
            return $response;
        }

        $content = $response->getContent();
        if (!is_string($content) || $content === '' || strlen($content) < self::MIN_BYTES) {
            return $response;
        }

        $contentType = (string) $response->headers->get('Content-Type', '');
        if (!preg_match('#(text/|application/(json|javascript|xml|svg\+xml|x-www-form-urlencoded|manifest\+json))#i', $contentType)) {
            return $response;
        }

        $accepts = strtolower((string) $request->headers->get('Accept-Encoding', ''));
        if ($accepts === '') {
            return $response;
        }

        $response->headers->remove('Content-Length');
        $vary = $response->headers->get('Vary', '');
        $response->headers->set('Vary', $vary === '' ? 'Accept-Encoding' : $vary . ', Accept-Encoding');

        if (str_contains($accepts, 'br') && function_exists('brotli_compress')) {
            $encoded = brotli_compress($content, 5);
            if (is_string($encoded)) {
                $response->setContent($encoded);
                $response->headers->set('Content-Encoding', 'br');
                return $response;
            }
        }

        if (str_contains($accepts, 'gzip') && function_exists('gzencode')) {
            $encoded = gzencode($content, 6);
            if (is_string($encoded)) {
                $response->setContent($encoded);
                $response->headers->set('Content-Encoding', 'gzip');
            }
        }

        return $response;
    }
}
