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
        $idStudent = $request->idStudent;

        $employee = DB::table('users')
        ->where('id', $idStudent)
        ->first();

        return view('admin.employee.edit', compact('employee'));
    }

    public function update(Request $request, $idEmployee) {
        $idEmployee = $request->id_employee;
        $username = $request->username;
        $password = Hash::make('12345678');
        $fullname = $request->fullname;
        $position = $request->position;
        $oldPhoto = $request->old_photo;

        if($request->hasFile('photo')) {
            $photo = $idEmployee . "." . $request->file('photo')->getClientOriginalExtension();
        } else {
            $photo = $oldPhoto;
        }

        try {
            $data = [
                'username' => $username,
                'password' => $password,
                'fullname' => $fullname,
                'position' => $position,
                // 'gender' => $gender,
                'photo' => $photo,
            ];

            $update = DB::table('employees')
            ->where('id_employee', $idEmployee)
            ->update($data);

            if($update) {
                if($request->hasFile('photo')) {
                    $folderPath = 'public/uploads/employee/';
                    $folderPathOld = 'public/uploads/employee/';
                    Storage::delete($folderPathOld);
                    $request->file('photo')->storeAs($folderPath, $photo);
                }

                return redirect()->back()->with('success', 'Data karyawan berhasil diperbarui');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data karyawan gagal diperbarui');
        }
    }

    public function destroy($idEmployee) {
        $delete = DB::table('employees')
        ->where('id_employee', $idEmployee)
        ->delete();

        if($delete) {
            return redirect()->back()->with('success', 'Data karyawan berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data karyawan gagal dihapus');
        }
    }
}
