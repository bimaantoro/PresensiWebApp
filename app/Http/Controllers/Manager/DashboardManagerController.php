<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardManagerController extends Controller
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

        $users = DB::table('users')
        ->where('role', 'student')
        ->orderBy('nama_lengkap')
        ->get();

        return view('manager.dashboard.report-presence', compact('users', 'months'));
    }

    public function printReportPresence(Request $request) {
        $idStudent = $request->id;
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

        $student = DB::table('users')
        ->where('role', 'student')
        ->where('id', $idStudent)
        ->first();

        $presence = DB::table('presences')
        ->where('user_id', $idStudent)
        ->whereRaw('MONTH(presence_at)="' . $month . '"')
        ->whereRaw('YEAR(presence_at)="' . $year . '"')
        ->orderBy('presence_at')
        ->get();

        return view('manager.dashboard.print-presence', compact('months', 'month', 'year', 'student', 'presence'));
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

        return view('manager.dashboard.report-presence', compact('months'));
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
        ->selectRaw('presences.user_id, nama_lengkap, instansi,
        MAX(IF(DAY(presence_at) = 1, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_1,
        MAX(IF(DAY(presence_at) = 2, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_2,
        MAX(IF(DAY(presence_at) = 3, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_3,
        MAX(IF(DAY(presence_at) = 4, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_4,
        MAX(IF(DAY(presence_at) = 5, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_5,
        MAX(IF(DAY(presence_at) = 6, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_6,
        MAX(IF(DAY(presence_at) = 7, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_7,
        MAX(IF(DAY(presence_at) = 8, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_8,
        MAX(IF(DAY(presence_at) = 9, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_9,
        MAX(IF(DAY(presence_at) = 10, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_10,
        MAX(IF(DAY(presence_at) = 11, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_11,
        MAX(IF(DAY(presence_at) = 12, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_12,
        MAX(IF(DAY(presence_at) = 13, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_13,
        MAX(IF(DAY(presence_at) = 14, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_14,
        MAX(IF(DAY(presence_at) = 15, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_15,
        MAX(IF(DAY(presence_at) = 16, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_16,
        MAX(IF(DAY(presence_at) = 17, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_17,
        MAX(IF(DAY(presence_at) = 18, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_18,
        MAX(IF(DAY(presence_at) = 19, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_19,
        MAX(IF(DAY(presence_at) = 20, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_20,
        MAX(IF(DAY(presence_at) = 21, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_21,
        MAX(IF(DAY(presence_at) = 22, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_22,
        MAX(IF(DAY(presence_at) = 23, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_23,
        MAX(IF(DAY(presence_at) = 24, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_24,
        MAX(IF(DAY(presence_at) = 25, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_25,
        MAX(IF(DAY(presence_at) = 26, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_26,
        MAX(IF(DAY(presence_at) = 27, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_27,
        MAX(IF(DAY(presence_at) = 28, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_28,
        MAX(IF(DAY(presence_at) = 29, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_29,
        MAX(IF(DAY(presence_at) = 30, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_30,
        MAX(IF(DAY(presence_at) = 31, CONCAT(check_in, "-", IFNULL(check_out, "00:00:00")), "")) as tgl_31'
        )->join('users', 'presences.user_id', '=', 'users.id')
        ->whereRaw('MONTH(presence_at) = "' . $month . '"')
        ->whereRaw('YEAR(presence_at) = "' . $year . '"')
        ->groupByRaw('presences.user_id, nama_lengkap, instansi')
        ->get();

        return view('manager.dashboard.print-recap-presence', compact('month', 'year', 'months', 'recapPresence'));
    }
}