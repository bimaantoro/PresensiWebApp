<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public function edit() {
        $idStudent = Auth::user()->id;

        $employee = DB::table('users')
        ->where('id', $idStudent)
        ->first();

        return view('profile.edit', compact('employee'));
    }

    public function update(Request $request) {
        $idStudent = Auth::user()->id_employee;
        $fullname = $request->fullname;
        $password = Hash::make($request->password);

        $employee = DB::table('users')
        ->where('id', $idStudent)
        ->first();

        if($request->hasFile('photo')) {
            $photo = $idStudent . "." . $request->file('photo')->getClientOriginalExtension();
        } else {
            $photo = $employee->photo;
        }
        
        if(empty($request->password)) {
            $data = [
                'nama_lengkap' => $fullname,
                'avatar'=> $photo
            ];
        } else {
            $data = [
                'fullname' => $fullname,
                'password' => $password,
                'photo' => $photo
            ];
        }

        $update = DB::table('employees')
        ->where('id_employee', $idStudent)
        ->update($data);

        if($update) {
            if($request->hasFile('photo')) {
                $folderPath = 'public/uploads/employee/';
                $request->file('photo')->storeAs($folderPath, $photo);
            }

            return redirect()->back()->with('success', 'Data berhasil di perbarui');
        } else {
            return redirect()->back()->with('error', 'Data gagal di perbarui');
        }
    }
}
