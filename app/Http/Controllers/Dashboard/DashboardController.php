<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index() {
        $idStudent = auth()->user()->id;

        $today = date('Y-m-d');
        $thisMonth = date('m') * 1;
        $thisYear = date('Y');
        
        $todayPresence = DB::table('presences')
        ->where('user_id', $idStudent)
        ->where('presence_at', $today)->first();
        
        $presenceHistoryOfMonth = DB::table('presences')
        ->select('presences.*', 'keterangan_izin', 'file_surat_dokter')
        ->leftJoin('pengajuan_izin', 'presences.pengajuan_izin_id', '=', 'pengajuan_izin.id')
        ->where('presences.user_id', $idStudent)
        ->whereRaw('MONTH(presence_at)="'. $thisMonth. '"')
        ->whereRaw('YEAR(presence_at)="' . $thisYear . '"')
        ->orderBy('presence_at')
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
        SUM(IF(check_in > "07:00", 1, 0)) as jmlh_terlambat')
        ->where('user_id', $idStudent)
        ->whereRaw('MONTH(presence_at)="' . $thisMonth . '"')
        ->whereRaw('YEAR(presence_at)="'  . $thisYear . '"')
        ->first();

        $leaderboardPresence = DB::table('presences')
        ->join('users', 'presences.user_id', '=', 'users.id')
        ->where('presence_at', $today)
        ->orderBy('check_in')
        ->get();

        $dataIzin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="I", 1, 0)) as jmlh_izin, SUM(IF(status="S", 1, 0)) as jmlh_sakit')
        ->where('id', $idStudent)
        ->whereRaw('MONTH(start_date)="' . $thisMonth . '"')
        ->whereRaw('YEAR(start_date)="' . $thisYear . '"')
        ->where('status_code', 1)
        ->first();

        return view('dashboard.index',
        compact(
            'todayPresence',
            'presenceHistoryOfMonth',
            'months',
            'thisMonth',
            'thisYear',
            'dataPresence',
            'leaderboardPresence',
            'dataIzin',
            )
        );
    }
}
