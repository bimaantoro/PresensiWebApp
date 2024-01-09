<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index() {
        $idEmployee = auth()->user()->id_employee;

        $today = date('Y-m-d');
        $thisMonth = date('m') * 1;
        $thisYear = date('Y');
        
        $todayPresence = DB::table('presences')
        ->where('employee_id', $idEmployee)
        ->where('presence_at', $today)->first();
        
        $presenceHistoryOfMonth = DB::table('presences')
        ->where('employee_id', $idEmployee)
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
        ->selectRaw('COUNT(employee_id) as jmlh_hadir, SUM(IF(check_in > "07:00", 1, 0)) as jmlh_terlambat')
        ->where('employee_id', $idEmployee)
        ->whereRaw('MONTH(presence_at)="' . $thisMonth . '"')
        ->whereRaw('YEAR(presence_at)="'  . $thisYear . '"')
        ->first();

        $leaderboardPresence = DB::table('presences')
        ->join('employees', 'presences.employee_id', '=', 'employees.id_employee')
        ->where('presence_at', $today)
        ->orderBy('check_in')
        ->get();

        $dataIzin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i", 1, 0)) as jmlh_izin, SUM(IF(status="s", 1, 0)) as jmlh_sakit')
        ->where('employee_id', $idEmployee)
        ->whereRaw('MONTH(from_date_at)="' . $thisMonth . '"')
        ->whereRaw('YEAR(from_date_at)="' . $thisYear . '"')
        ->where('status_approved', 1)
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
