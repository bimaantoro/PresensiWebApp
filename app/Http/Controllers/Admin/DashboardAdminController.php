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

        $dataPresence = DB::table('presences')
        ->selectRaw('COUNT(employee_id) as jmlh_hadir, SUM(IF(check_in > "07:00", 1, 0)) as jmlh_terlambat')
        ->where('presence_at', $today)
        ->first();

        $dataIzin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i", 1, 0)) as jmlh_izin, SUM(IF(status="s", 1, 0)) as jmlh_sakit')
        ->where('start_date', $today)
        ->where('status_code', 1)
        ->first();

        return view('admin.dashboard.index', compact('dataPresence', 'dataIzin'));
    }
}
