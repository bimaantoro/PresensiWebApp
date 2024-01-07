<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectAuthenticatedUsersController extends Controller
{
    //
    public function home() {
        if(Auth::guard('employee')->user()->role == 'manager') {
            echo "ini manager";
            return redirect('manager/presence-employee/report');
        } else if(Auth::guard('employee')->user()->role == 'admin') {
            echo "ini admin";
            return redirect('admin/dashboard');
        } else if(Auth::guard('employee')->user()->role == 'user') {
            echo "ini user";
            return redirect('/dashboard');
        } else {
            return auth()->logout();
        }
    }
}
