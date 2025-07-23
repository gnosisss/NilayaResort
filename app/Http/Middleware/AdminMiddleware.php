<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            Log::warning('Unauthorized access attempt to admin area - User not authenticated', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu untuk mengakses halaman ini.');
        }
        
        if (Auth::user()->role !== 'admin') {
            Log::warning('Unauthorized access attempt to admin area - Not an admin', [
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk halaman ini. Hanya admin yang dapat mengakses area ini.');
        }

        return $next($request);
    }
}