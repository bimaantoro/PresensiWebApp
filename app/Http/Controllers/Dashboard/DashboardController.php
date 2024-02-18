<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index() {
        $idEmployee = Auth::guard('employee')->user()->id_employee;

        $today = date('Y-m-d');
        $currentMonth = date('m') * 1;
        $currentYear = date('Y');
        
        $todayPresence = DB::table('presences')
        ->where('employee_id', $idEmployee)
        ->where('presence_at', $today)->first();
        
        $presenceHistoryOfMonth = DB::table('presences')
        ->select('presences.*', 'working_hours.*', 'keterangan_izin', 'file_surat_dokter')
        ->leftJoin('working_hours', 'presences.working_hour_id', '=', 'working_hours.id')
        ->leftJoin('pengajuan_izin', 'presences.pengajuan_izin_id', '=', 'pengajuan_izin.id')
        ->where('presences.employee_id', $idEmployee)
        ->whereRaw('MONTH(presence_at)="'. $currentMonth. '"')
        ->whereRaw('YEAR(presence_at)="' . $currentYear . '"')
        ->orderByDesc('presence_at')
        ->get();

        $months = [
            "",
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];

        // Query Rekap Presensi
        $dataPresence = DB::table('presences')
        ->selectRaw('SUM(IF(presence_status="H", 1, 0)) as jmlh_hadir,
        SUM(IF(presence_status="I", 1, 0)) as jmlh_izin,
        SUM(IF(presence_status="S", 1, 0)) as jmlh_sakit,
        SUM(IF(presences.check_in > working_hours.jam_in, 1, 0)) as jmlh_terlambat')
        ->leftJoin('working_hours', 'presences.working_hour_id', '=', 'working_hours.id')
        ->where('presences.employee_id', $idEmployee)
        ->whereRaw('MONTH(presence_at)="' . $currentMonth . '"')
        ->whereRaw('YEAR(presence_at)="'  . $currentYear . '"')
        ->first();

        $leaderboardPresence = DB::table('presences')
        ->join('users', 'presences.employee_id', '=', 'users.id')
        ->where('presence_at', $today)
        ->orderBy('check_in')
        ->get();

        return view('dashboard.index',
        compact(
            'todayPresence',
            'presenceHistoryOfMonth',
            'months',
            'currentMonth',
            'currentYear',
            'dataPresence',
            'leaderboardPresence',
            )
        );
    }
}
