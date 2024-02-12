<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index() {
        $idStudent = auth()->user()->id;

        $today = date('Y-m-d');
        $currentMonth = date('m') * 1;
        $currentYear = date('Y');
        
        $todayPresence = DB::table('presences')
        ->where('user_id', $idStudent)
        ->where('presence_at', $today)->first();
        
        $presenceHistoryOfMonth = DB::table('presences')
        ->select('presences.*', 'working_hours.*', 'keterangan_izin', 'file_surat_dokter')
        ->leftJoin('working_hours', 'presences.working_hour_id', '=', 'working_hours.id')
        ->leftJoin('pengajuan_izin', 'presences.pengajuan_izin_id', '=', 'pengajuan_izin.id')
        ->where('presences.user_id', $idStudent)
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
        ->where('presences.user_id', $idStudent)
        ->whereRaw('MONTH(presence_at)="' . $currentMonth . '"')
        ->whereRaw('YEAR(presence_at)="'  . $currentYear . '"')
        ->first();

        $leaderboardPresence = DB::table('presences')
        ->join('users', 'presences.user_id', '=', 'users.id')
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

    /* public function index() {
        $idStudent = auth()->user()->id;

        $today = new DateTime();
        $currentMonth = $today->format('m');
        $currentYear = $today->format('Y');
        $todayFormatted = $today->format('Y-m-d');
        
        $todayPresence = DB::table('presences')
        ->where('user_id', $idStudent)
        ->where('presence_at', $today)->first();
        
        $presenceHistoryOfMonth = DB::table('presences')
        ->select('presences.*', 'keterangan_izin', 'file_surat_dokter', 'working_hours.name', 'working_hours.jam_in')
        ->leftJoin('pengajuan_izin', 'presences.pengajuan_izin_id', '=', 'pengajuan_izin.id')
        ->leftJoin('working_hours', 'presences.working_hour_id', '=', 'working_hours.id')
        ->where('presences.user_id', $idStudent)
        ->whereYear('presence_at', $currentYear)
        ->whereMonth('presence_at', $currentMonth)
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
            SUM(IF(presences.check_in > working_hours.jam_in, 1, 0)) as jmlh_terlambat'
        )
        ->leftJoin('working_hours', 'presences.working_hour_id', '=', 'working_hours.id')
        ->where('user_id', $idStudent)
        ->whereYear('presence_at', $currentYear)
        ->whereMonth('presence_at', $currentMonth)
        ->first();

        $leaderboardPresence = DB::table('presences')
        ->join('users', 'presences.user_id', '=', 'users.id')
        ->where('presence_at', $todayFormatted)
        ->orderBy('check_in')
        ->get();

        $dataIzin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="I", 1, 0)) as jmlh_izin, SUM(IF(status="S", 1, 0)) as jmlh_sakit')
        ->where('id', $idStudent)
        ->whereYear('start_date', $currentYear)
        ->whereMonth('start_date', $currentMonth)
        ->where('status_code', 1)
        ->first();

        return view('dashboard.index',
        compact(
            'todayPresence',
            'presenceHistoryOfMonth',
            'currentMonth',
            'currentYear',
            'months',
            'dataPresence',
            'leaderboardPresence',
            'dataIzin',
            )
        );
    } */
}
