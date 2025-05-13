<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthed extends RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards ): Response
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('a.dashboard');
        } elseif (Auth::guard('guru')->check()) {
            return redirect()->route('g.dashboard');
        } elseif (Auth::guard('siswa')->check()) {
            return redirect()->route('s.dashboard');
        }
        return $next($request);
    }
}
