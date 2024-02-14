<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigWorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetWorkingHourEmployeeController extends Controller
{
    //
    public function setWorkHourEmployee($id) {

        $student = DB::table('employees')
        ->where('id_employee', $id)
        ->first();

        $workHours = DB::table('working_hours')
        ->orderBy('name')
        ->get();

        $checkWorkHour = DB::table('config_working_hours')
        ->where('employee_id', $id)
        ->count();

        if($checkWorkHour > 0) {
            $setWorkingHour = DB::table('config_working_hours')
            ->where('employee_id', $id)
            ->get();

            return view('admin.setting.edit-work-hour', compact('student', 'workHours', 'setWorkingHour'));
        }

        return view('admin.setting.work-hour', compact('student', 'workHours'));
    }

    public function storeWorkHourEmployee(Request $request) {
        $idEmployee = $request->id;
        $day = $request->day;
        $idJamKerja = $request->working_hour_id;
        
        for ($i = 0; $i < count($day); $i++) { 
            $data[] = [
                'employee_id' => $idEmployee,
                'day' => $day[$i],
                'working_hour_id' => $idJamKerja[$i],
            ];
        }

        try {
            ConfigWorkingHour::insert($data);

            return redirect('admin/employees')->with(['success' => 'Jam Kerja Peserta berhasil disetting']);
        } catch(\Exception $e) {

            dd($e);
            return redirect('admin/employees')->with(['error' => 'Jam Kerja Peserta gagal disetting']);
        }
    }

    public function updateWorkHourEmployee(Request $request) {
        $idEmployee = $request->id;
        $day = $request->day;
        $idJamKerja = $request->working_hour_id;
        
        for ($i = 0; $i < count($day); $i++) { 
            $data[] = [
                'employee_id' => $idEmployee,
                'day' => $day[$i],
                'working_hour_id' => $idJamKerja[$i],
            ];
        }

        DB::beginTransaction();

        try {
            DB::table('config_working_hours')
            ->where('employee_id', $idEmployee)
            ->delete();

            ConfigWorkingHour::insert($data);
            
            DB::commit();

            return redirect('admin/employees')->with(['success' => 'Jam Kerja Peserta berhasil disetting']);
        } catch(\Exception $e) {
            DB::rollBack();
            
            return redirect('admin/employees')->with(['error' => 'Jam Kerja Peserta gagal disetting']);
        }
    }
}
