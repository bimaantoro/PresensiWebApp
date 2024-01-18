<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        ->select('presences.*', 'keterangan')
        ->leftJoin('pengajuan_izin', 'presences.kode_izin', '=', 'pengajuan_izin.kode_izin')
        ->where('presences.user_id', $idStudent)
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
        $startDate  = $year . "-" . $month . "-01";
        $endDate = date('Y-m-t', strtotime($startDate));

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

        $selectDate = "";
        $fieldDate = "";
        $i = 1;

        while(strtotime($startDate) <= strtotime($endDate)) {
            $rangeDate[] = $startDate;

            $selectDate .= "MAX(IF(presence_at = '$startDate',
            CONCAT(
                IFNULL(check_in, 'NA'), '|',
                IFNULL(check_out, 'NA'), '|',
                IFNULL(presence_status, 'NA'), '|',
                IFNULL(presences.kode_izin, 'NA'), '|',
                IFNULL('keterangan', 'NA'), '|'
            ), NULL)) as tgl_" . $i . ","; 

            $fieldDate .= "tgl_" . $i . ",";
            $i++;
            $startDate = date('Y-m-d', strtotime("+1 days", strtotime($startDate)));
        }

        $totalDays = count($rangeDate);
        $lastIndex = $totalDays - 1;
        $endDate = $rangeDate[$lastIndex];

        if($totalDays == 30) {
            array_push($rangeDate, NULL);
        } else if($totalDays == 28) {
            array_push($rangeDate, NULL, NULL, NULL);
        } elseif($totalDays == 29) {
            array_push($rangeDate, NULL, NULL);
        }

        $query = User::query();
        $query->selectRaw("$fieldDate id, nama_lengkap, instansi");

        $query->leftJoin(
            DB::raw("(
                SELECT
                $selectDate
                presences.user_id
                FROM presences
                LEFT JOIN pengajuan_izin ON presences.kode_izin = pengajuan_izin.kode_izin
                WHERE presence_at BETWEEN '$rangeDate[0]' AND '$endDate'
                GROUP BY user_id
            ) presences"),
            function($join) {
                $join->on('users.id', '=', 'presences.user_id');
            }
        );
        
        $query->where('role', 'student');
        $query->orderBy('nama_lengkap');
        $recapPresence = $query->get();

        return view('manager.dashboard.print-recap-presence', compact('month', 'year', 'months', 'recapPresence', 'rangeDate', 'totalDays'));
    }
}
