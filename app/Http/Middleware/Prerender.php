<?php

namespace App\Http\Middleware;

use Cache;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

class Prerender
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldPrerender($request)) {
            $urlKey = base64_encode($request->fullUrl());

            if (!Cache::tags(['prerender'])->has($urlKey)) {
                $response = $this->requestRenderedPage($request->fullUrl());

                Cache::tags(['prerender'])->forever($urlKey, $response->getBody()->getContents());
                Cache::tags(['prerender'])->forever($urlKey.':code', $response->getStatusCode());
            }

            return response(
                Cache::tags(['prerender'])->get($urlKey),
                Cache::tags(['prerender'])->get($urlKey.':code', 200)
            );
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function shouldPrerender(Request $request): bool
    {
        return app()->environment('production')
                && $this->comesFromCrawler($request)
                && $request->isMethod('GET')
                && !$request->header('X-Inertia');
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function comesFromCrawler(Request $request): bool
    {
        return !empty($request->userAgent())
            && Str::contains(
                strtolower($request->userAgent()),
                config('web.crawlers')
            );
    }

    /**
     * @param string $url
     * @return ResponseInterface
     */
    private function requestRenderedPage(string $url): ResponseInterface
    {
        $client = new Client([
            'allow_redirects' => false,
        ]);

        return $client->get('https://service.prerender.cloud/'.$url);
    }
}
