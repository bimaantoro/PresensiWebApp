<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    //
    public function index() {
        $today = date('Y-m-d');

          // Query Rekap Presensi
          $dataPresence = DB::table('presences')
          ->selectRaw('SUM(IF(presence_status="H", 1, 0)) as jmlh_hadir,
          SUM(IF(presence_status="I", 1, 0)) as jmlh_izin,
          SUM(IF(presence_status="S", 1, 0)) as jmlh_sakit,
          SUM(IF(presences.check_in > working_hours.jam_in, 1, 0)) as jmlh_terlambat')
          ->leftJoin('working_hours', 'presences.working_hour_id', '=', 'working_hours.id')
          ->where('presence_at', $today)
          ->first();

        return view('admin.dashboard.index', compact('dataPresence'));
    }

    public function getPresence(Request $request) {
      $date = $request->date;

      $presence = DB::table('presences')
      ->select('presences.*', 'fullname', 'position', 'keterangan_izin', 'working_hours.jam_in', 'working_hours.name', 'working_hours.jam_out')
      ->leftJoin('working_hours', 'presences.working_hour_id', '=', 'working_hours.id')
      ->leftJoin('pengajuan_izin', 'presences.pengajuan_izin_id', '=', 'pengajuan_izin.id')
      ->join('employees', 'presences.employee_id', '=', 'employees.id_employee')
      ->where('presence_at', $date)
      ->get();

      return view('admin.dashboard.get-presence', compact('presence'));
  }

  public function showMap(Request $request) {
      $id = $request->id;
      
      $presence = DB::table('presences')
      ->join('employees', 'presences.employee_id', '=', 'employees.id_employee')
      ->where('presences.id', $id)
      ->first();

      return view('admin.dashboard.show-map', compact('presence'));
  }
}
