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

        $student = DB::table('users')
        ->where('id', $idStudent)
        ->first();

        return view('profile.edit', compact('student'));
    }

    public function update(Request $request) {
        $idStudent = Auth::user()->id;
        $namaLengkap = $request->nama_lengkap;
        $password = Hash::make($request->password);

        $student = DB::table('users')
        ->where('id', $idStudent)
        ->first();

        if($request->hasFile('avatar')) {
            $avatar = $idStudent . "." . $request->file('avatar')->getClientOriginalExtension();
        } else {
            $avatar = $student->avatar;
        }
        
        if(empty($request->password)) {
            $data = [
                'nama_lengkap' => $namaLengkap,
                'avatar'=> $avatar
            ];
        } else {
            $data = [
                'nama_lengkap' => $namaLengkap,
                'password' => $password,
                'avatar' => $avatar
            ];
        }

        $update = DB::table('users')
        ->where('id', $idStudent)
        ->update($data);

        if($update) {
            if($request->hasFile('avatar')) {
                $folderPath = 'public/uploads/employee/';
                $request->file('avatar')->storeAs($folderPath, $avatar);
            }

            return redirect()->back()->with('success', 'Data berhasil di perbarui');
        } else {
            return redirect()->back()->with('error', 'Data gagal di perbarui');
        }
    }
}
