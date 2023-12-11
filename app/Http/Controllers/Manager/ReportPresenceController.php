<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportPresenceController extends Controller
{
    //
    public function reportPresence() {
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

        $employees = DB::table('employees')
        ->where('role', 'user')
        ->orderBy('fullname')
        ->get();

        return view('manager.report.laporan-presence', compact('months', 'employees'));
    }

    public function printReportPresence(Request $request) {
        $idEmployee = $request->id_employee;
        $month = $request->month;
        $year = $request->year;

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

        $employee = DB::table('employees')
        ->where('id_employee', $idEmployee)
        ->first();

        $presence = DB::table('presences')
        ->where('employee_id', $idEmployee)
        ->whereRaw('MONTH(presence_at)="' . $month . '"')
        ->whereRaw('YEAR(presence_at)="' . $year . '"')
        ->orderBy('presence_at')
        ->get();

        return view('manager.presence.cetak-laporan', compact('month', 'year', 'months', 'employee', 'presence'));
    }

    public function recapPresence() {
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

        return view('manager.report.recap-presence', compact('months'));
    }

    public function printRecapPresence(Request $request) {
        $month = $request->month;
        $year = $request->year;

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

        $recapPresence = DB::table('presences')
        ->selectRaw('presences.employee_id, fullname,
        MAX(IF(DAY(presence_at)= 1,CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_1,')
        ->join('employees', 'presences.employee_id', '=', 'employees.id_employee')
        ->whereRaw('MONTH(presence_at)="' . $month . '"')
        ->whereRaw('YEAR(presence_at)= "' . $year . '"')
        ->groupByRaw('presences.employee_id, fullname')
        ->get();

        dd($recapPresence);

        return view('manager.presence.cetak-rekap-presence', compact('month', 'year', 'months', 'recapPresence'));
    }
}
