<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index() {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request) {
        $request->authenticate();

        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
        // $credentials = $request->validate([
        //     'username' => 'required',
        //     'password' => 'required',
        // ]);

        // if(Auth::guard('employee')->attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return redirect()->intended('dashboard');
        // }

        // return back()->with('loginError', 'Username / Kata sandi salah. Silakan cek kembali');
    }

    public function logout(Request $request) {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
