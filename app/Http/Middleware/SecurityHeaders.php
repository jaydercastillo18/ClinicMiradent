<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security Headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // Prevents Clickjacking
        $response->headers->set('X-XSS-Protection', '1; mode=block'); // XSS Protection
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // MIME sniffing protection
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin'); // Referrer info protection
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains'); // HSTS (For HTTPS)
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; img-src 'self' data: https:; font-src 'self' https://fonts.gstatic.com; connect-src 'self' https://unpkg.com https://cdn.jsdelivr.net; frame-src 'self' https://www.google.com; object-src 'none'; base-uri 'self';");

        return $response;
    }
}
