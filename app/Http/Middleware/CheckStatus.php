<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Cek apakah user terautentikasi
        if (!$user) {
            return redirect('/login');
        }

        // Cek status user
        if ($user->status === 'active') {
            return $next($request);
        }

        if ($user->status === 'verify') {
            return redirect('/verify');
        }

        // Jika status lainnya, misalnya banned atau tidak valid
        return redirect('/banned');
    }
}
