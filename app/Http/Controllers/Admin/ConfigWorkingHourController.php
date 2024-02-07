<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigWorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigWorkingHourController extends Controller
{
    //
    public function index() {
        $workHours = DB::table('working_hours')
        ->orderBy('id')
        ->get();
        return view('admin.config.work-hour.index', compact('workHours'));
    }

    public function store(Request $request) {
        $idJamKerja = $request->id;
        $name = $request->name;
        $startCheckIn = $request->start_check_in;
        $checkIn = $request->check_in;
        $endCheckIn = $request->end_check_in;
        $checkOut = $request->check_out;

        $data = [
            'id' => $idJamKerja,
            'name' => $name,
            'start_check_in' => $startCheckIn,
            'check_in' => $checkIn,
            'end_check_in' => $endCheckIn,
            'check_out' => $checkOut,
        ];

        try {
            DB::table('working_hours')->insert($data);
            return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
        }catch(\Exception $e) {
            return redirect()->back()->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function edit(Request $request) {
        $idJamKerja = $request->id;

        $workHours = DB::table('working_hours')
        ->where('id', $idJamKerja)
        ->first();

        return view('admin.config.work-hour.edit', compact('workHours'));
    }

    public function update($id, Request $request) {
        $idJamKerja = $request->id;
        $namaJamKerja = $request->name;
        $startCheckIn = $request->start_check_in;
        $checkIn = $request->check_in;
        $endCheckIn = $request->end_check_in;
        $checkOut = $request->check_out;

        $data = [
            'name' => $namaJamKerja,
            'start_check_in' => $startCheckIn,
            'check_in' => $checkIn,
            'end_check_in' => $endCheckIn,
            'check_out' => $checkOut,
        ];

        try {
            DB::table('working_hours')
            ->where('id', $idJamKerja)
            ->update($data);
            return redirect()->back()->with(['success' => 'Data berhasil diperbarui']);
        }catch(\Exception $e) {
            return redirect()->back()->with(['error' => 'Data gagal diperbarui']);
        }
    }

    public function destroy($id) {
        $delete = DB::table('working_hours')
        ->where('id', $id)
        ->delete();

        if($delete) {
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }

    public function setWorkHourStudent($id) {

        $student = DB::table('users')
        ->where('id', $id)
        ->first();

        $workHours = DB::table('working_hours')
        ->orderBy('name')
        ->get();

        $checkWorkHour = DB::table('config_working_hours')
        ->where('user_id', $id)
        ->count();

        if($checkWorkHour > 0) {
            $setWorkingHour = DB::table('config_working_hours')
            ->where('user_id', $id)
            ->get();

            return view('admin.config.work-hour.edit-set-work-hour', compact('student', 'workHours', 'setWorkingHour'));
        }

        return view('admin.config.work-hour.set-work-hour', compact('student', 'workHours'));
    }

    public function storeWorkHourStudent(Request $request) {
        $idStudent = $request->id;
        $day = $request->day;
        $idJamKerja = $request->working_hour_id;
        
        for ($i = 0; $i < count($day); $i++) { 
            $data[] = [
                'user_id' => $idStudent,
                'day' => $day[$i],
                'working_hour_id' => $idJamKerja[$i],
            ];
        }

        try {
            ConfigWorkingHour::insert($data);

            return redirect('admin/students')->with(['success' => 'Jam Kerja Peserta berhasil disetting']);
        } catch(\Exception $e) {

            dd($e);
            return redirect('admin/students')->with(['error' => 'Jam Kerja Peserta gagal disetting']);
        }
    }

    public function updateWorkHourStudent(Request $request) {
        $idStudent = $request->id;
        $day = $request->day;
        $idJamKerja = $request->working_hour_id;
        
        for ($i = 0; $i < count($day); $i++) { 
            $data[] = [
                'user_id' => $idStudent,
                'day' => $day[$i],
                'working_hour_id' => $idJamKerja[$i],
            ];
        }

        DB::beginTransaction();

        try {
            DB::table('config_working_hours')
            ->where('user_id', $idStudent)
            ->delete();

            ConfigWorkingHour::insert($data);
            
            DB::commit();

            return redirect('admin/students')->with(['success' => 'Jam Kerja Peserta berhasil disetting']);
        } catch(\Exception $e) {
            DB::rollBack();
            
            return redirect('admin/students')->with(['error' => 'Jam Kerja Peserta gagal disetting']);
        }
    }
}
