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
}
