<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    //
    public function index(Request $request) {
        $query = Employee::query();
        $query->select('employees.*');
        $query->where('role', 'karyawan');
        $query->orderBy('fullname');

        if(!empty($request->fullname)) {
            $query->where('fullname', 'like', '%' . $request->fullname . '%');
        }

        $employee = $query->paginate(10);

        return view('admin.employee.index', compact('employee'));
    }

    public function store(Request $request) {
        $idEmployee = $request->id_employee;
        $username = $request->username;
        $password = Hash::make('12345678');
        $namaLengkap = $request->fullname;
        $position = $request->position;

        $photo = null;

        if($request->hasFile('photo')) {
            $photo = $idEmployee . "." . $request->file('photo')->getClientOriginalExtension();
        }

        try {
            $data = [
                'id_employee' => $idEmployee,
                'username' => $username,
                'password' => $password,
                'fullname' => $namaLengkap,
                'position' => $position,
                'photo' => $photo,
            ];

            $save = DB::table('employees')->insert($data);

            if ($save && $photo != null) {
                $folderPath = 'public/uploads/employee/';
                $request->file('photo')->storeAs($folderPath, $photo);
            }
            return redirect()->back()->with(['success' => 'Data Karyawan berhasil ditambahkan']);
        } catch (\Exception $e) {
            $message = ($e->getCode() == 23000) ? 'Data dengan ID ' . $idEmployee . " Sudah ada" : 'Hubungi IT';

            return redirect()->back()->with(['error' => 'Data Karyawan gagal ditambahkan, ' . $message]);
        }
    }

    public function edit(Request $request) {
        $idEmployee = $request->id;

        $employee = DB::table('employees')
        ->where('id_employee', $idEmployee)
        ->first();

        return view('admin.employee.edit', compact('employee'));
    }

    public function update($idEmployee, Request $request) {
        $idEmployee = $request->id_employee;
        $username = $request->username;
        $password = Hash::make('12345678');
        $namaLengkap = $request->fullname;
        $position = $request->position;
        $photo = $request->photo;
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
                'fullname' => $namaLengkap,
                'position' => $position,
                'photo' => $photo,
            ];

            $update = DB::table('employees')
            ->where('id_employee', $idEmployee)
            ->update($data);

            if($update) {
                if($request->hasFile('photo')) {
                    $folderPath = 'public/uploads/employee/';
                    $folderPathOld = 'public/uploads/employee/' . $oldPhoto;
                    Storage::delete($folderPathOld);
                    $request->file('photo')->storeAs($folderPath, $photo);
                }

                return redirect()->back()->with(['success' => 'Data Karyawan berhasil diperbarui']);
            }
            
        } catch (\Exception $e) {
            return  redirect()->back()->with(['error' => 'Data Karyawan gagal diperbarui']);
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
