<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectAuthenticatedUsersController extends Controller
{
    //
    public function home() {
        if(Auth::guard('employee')->user()->role == 'admin') {
            return redirect()->route('dashboard-admin');
        } else if(Auth::guard('employee')->user()->role == 'user') {
            return redirect()->route('dashboard');
        } else {
            return auth()->logout();
        }
    }
}
