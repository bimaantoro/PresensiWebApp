<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigWorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetWorkingHourStudentController extends Controller
{
    //
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

            return view('admin.setting.edit-work-hour', compact('student', 'workHours', 'setWorkingHour'));
        } else  {
            return view('admin.setting.work-hour', compact('student', 'workHours'));
        }
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
