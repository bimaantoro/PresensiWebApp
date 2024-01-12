<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectAuthenticatedUsersController extends Controller
{
    //
    public function home() {
        if(Auth::user()->role == 'manager') {
            return redirect('manager/dashboard');
        } else if(Auth::user()->role == 'admin') {
            return redirect('admin/dashboard');
        } else if(Auth::user()->role == 'student') {
            return redirect('dashboard');
        } else {
            return auth()->logout();
        }
    }
}
