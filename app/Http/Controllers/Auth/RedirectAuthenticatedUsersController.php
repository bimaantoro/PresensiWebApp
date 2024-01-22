<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectAuthenticatedUsersController extends Controller
{
    //
    public function home() {
        if(Auth::guard('employee')->user()->role == 'direktur') {
            return redirect('direktur/dashboard');
        } else if(Auth::guard('employee')->user()->role == 'admin') {
            return redirect('admin/dashboard');
        } else if(Auth::guard('employee')->user()->role == 'karyawan') {
            return redirect('/dashboard');
        } else {
            return auth()->logout();
        }
    }
}
