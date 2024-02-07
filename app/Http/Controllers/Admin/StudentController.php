<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    //
    public function index(Request $request) {
        $query = User::query();
        $query->select('users.*');
        $query->where('role', 'student');
        $query->orderBy('nama_lengkap');

        if(!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        $student = $query->paginate(10);

        return view('admin.student.index', compact('student'));
    }

    public function store(Request $request) {
        $idStudent = $request->id;
        $username = $request->username;
        $password = Hash::make('12345678');
        $namaLengkap = $request->nama_lengkap;
        $instansi = $request->instansi;
        $startInternship = $request->start_internship;
        $endInternship = $request->end_internship;

        if($request->hasFile('avatar')) {
            $avatar = $idStudent . "." . $request->file('avatar')->getClientOriginalExtension();
        } else {
            $avatar = null;
        }

        try {
            $data = [
                'id' => $idStudent,
                'username' => $username,
                'password' => $password,
                'nama_lengkap' => $namaLengkap,
                'instansi' => $instansi,
                'start_internship' => $startInternship,
                'end_internship' => $endInternship,
                'avatar' => $avatar,
            ];

            $save = DB::table('users')->insert($data);

            if($save) {
                if($request->hasFile('avatar')) {
                    $folderPath = 'public/uploads/student/';
                    $request->file('avatar')->storeAs($folderPath, $avatar);
                }

                return redirect()->back()->with('success', 'Data Peserta berhasil ditambahkan');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Peserta gagal ditambahkan');
        }

    }

    public function edit(Request $request) {
        $idStudent = $request->id;

        $student = DB::table('users')
        ->where('id', $idStudent)
        ->first();

        return view('admin.student.edit', compact('student'));
    }

    public function update($idStudent, Request $request) {
        $idStudent = $request->id;
        $username = $request->username;
        $password = Hash::make('12345678');
        $namaLengkap = $request->nama_lengkap;
        $instansi = $request->instansi;
        $startInternship = $request->start_internship;
        $endInternship = $request->end_internship;
        $avatar = $request->avatar;
        $oldAvatar = $request->old_avatar;

        if($request->hasFile('avatar')) {
            $avatar = $idStudent . "." . $request->file('avatar')->getClientOriginalExtension();
        } else {
            $avatar = $oldAvatar;
        }

        try {
            $data = [
                'username' => $username,
                'password' => $password,
                'nama_lengkap' => $namaLengkap,
                'instansi' => $instansi,
                'start_internship' => $startInternship,
                'end_internship' => $endInternship,
                'avatar' => $avatar,
            ];

            $update = DB::table('users')
            ->where('id', $idStudent)
            ->update($data);

            if($update) {
                if($request->hasFile('avatar')) {
                    $folderPath = 'public/uploads/student/';
                    $folderPathOld = 'public/uploads/student/' . $oldAvatar;
                    Storage::delete($folderPathOld);
                    $request->file('avatar')->storeAs($folderPath, $avatar);
                }

                return redirect()->back()->with('success', 'Data peserta berhasil diperbarui');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data peserta gagal diperbarui');
        }
    }

    public function destroy($idStudent) {
        $delete = DB::table('users')
        ->where('id', $idStudent)
        ->delete();

        if($delete) {
            return redirect()->back()->with('success', 'Data peserta berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data peserta gagal dihapus');
        }
    }
}
