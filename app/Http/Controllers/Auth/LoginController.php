<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
    
    /**
     * Get the post login redirect path based on user role.
     *
     * @return string
     */
    protected function redirectTo()
{
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return '/admin';
        } elseif (Auth::user()->role === 'employee') {
            return '/employee';
        } elseif (Auth::user()->role === 'bank_officer') {
            return '/bank-verification';
        } elseif (Auth::user()->role === 'customer') {
            return '/customer';
        }
    }
    
    return RouteServiceProvider::HOME; // Gunakan konstanta dari RouteServiceProvider
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}