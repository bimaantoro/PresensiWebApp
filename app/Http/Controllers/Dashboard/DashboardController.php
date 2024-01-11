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
        ->where('user_id', $idStudent)
        ->whereRaw('MONTH(presence_at)="'. $thisMonth. '"')
        ->whereRaw('YEAR(presence_at)="' . $thisYear . '"')
        ->orderBy('presence_at')->get();

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

        $dataPresence = DB::table('presences')
        ->selectRaw('COUNT(id) as jmlh_hadir, SUM(IF(check_in > "07:00", 1, 0)) as jmlh_terlambat')
        ->where('id', $idStudent)
        ->whereRaw('MONTH(presence_at)="' . $thisMonth . '"')
        ->whereRaw('YEAR(presence_at)="'  . $thisYear . '"')
        ->first();

        $leaderboardPresence = DB::table('presences')
        ->join('users', 'presences.user_id', '=', 'users.id')
        ->where('presence_at', $today)
        ->orderBy('check_in')
        ->get();

        $dataIzin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i", 1, 0)) as jmlh_izin, SUM(IF(status="s", 1, 0)) as jmlh_sakit')
        ->where('kode_izin', $idStudent)
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
