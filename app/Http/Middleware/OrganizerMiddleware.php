<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Asumsi idrole 2 adalah untuk Organizer
        if (auth()->check() && auth()->user()->role === 'organizer') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Anda bukan organizer.');
    }
}
