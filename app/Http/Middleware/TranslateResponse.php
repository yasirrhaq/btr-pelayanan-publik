<?php

namespace App\Http\Middleware;

use App\Services\TranslationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslateResponse
{
    /**
     * Handle an incoming request.
     *
     * Only translates public (non-admin) GET responses that are HTML pages
     * when the active locale is 'en'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        // Only translate when locale is English
        if (app()->getLocale() !== 'en') {
            return $response;
        }

        // Never translate admin/dashboard pages
        if ($request->is('dashboard', 'dashboard/*')) {
            return $response;
        }

        // Only translate GET HTML responses
        if ($request->method() !== 'GET') {
            return $response;
        }

        $contentType = $response->headers->get('Content-Type', '');
        if (!str_contains($contentType, 'text/html')) {
            return $response;
        }

        $content = $response->getContent();
        if (empty($content)) {
            return $response;
        }

        $translated = TranslationService::pageHtml($content);
        if (! is_string($translated) || trim(strip_tags($translated)) === '') {
            return $response;
        }

        $response->setContent($translated);

        return $response;
    }
}
