<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BankOfficer
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
            Log::warning('Unauthorized access attempt to bank officer area - User not authenticated', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
            return redirect()->route('login')
                ->with('error', 'Anda harus login terlebih dahulu untuk mengakses halaman ini.');
        }
        
        if (!Auth::user()->isBankOfficer()) {
            Log::warning('Unauthorized access attempt to bank officer area - Not a bank officer', [
                'user_id' => Auth::id(),
                'user_email' => Auth::user()->email,
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk halaman ini. Hanya petugas bank yang dapat mengakses area ini.');
        }

        return $next($request);
    }
}