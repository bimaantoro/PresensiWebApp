<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Employee;
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
        ->where('role', 'karyawan')
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
        ->where('role', 'karyawan')
        ->where('id_employee', $idEmployee)
        ->first();

        $presence = DB::table('presences')
        ->select('presences.*', 'keterangan_izin')
        ->leftJoin('pengajuan_izin', 'presences.kode_izin', '=', 'pengajuan_izin.kode_izin')
        ->where('presences.employee_id', $idEmployee)
        ->whereRaw('MONTH(presence_at)="' . $month . '"')
        ->whereRaw('YEAR(presence_at)="' . $year . '"')
        ->orderBy('presence_at')
        ->get();

        if(isset($_POST['export-excel'])) {
            $time = date('d-M-Y H:i:s');
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap Presensi Karyawan $time.xls");

            return view('manager.report.print-excel-presence', compact('months', 'month', 'year', 'employee', 'presence'));
        }

        return view('manager.report.print-presence', compact('months', 'month', 'year', 'employee', 'presence'));
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

        return view('manager.report.laporan-presence', compact('months'));
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

        $query = Employee::query();
        $query->selectRaw("$fieldDate id_employee, fullname, position");

        $query->leftJoin(
            DB::raw("(
                SELECT
                $selectDate
                presences.employee_id
                FROM presences
                LEFT JOIN pengajuan_izin ON presences.kode_izin = pengajuan_izin.kode_izin
                WHERE presence_at BETWEEN '$rangeDate[0]' AND '$endDate'
                GROUP BY employee_id
            ) presences"),
            function($join) {
                $join->on('employees.id_employee', '=', 'presences.employee_id');
            }
        );
        
        $query->where('role', 'karyawan');
        $query->orderBy('fullname');
        $recapPresence = $query->get();

        if(isset($_POST['export-excel'])) {
            $time = date('d-M-Y H:i:s');
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap Presensi Peserta $time.xls");
        }

        return view('manager.report.print-recap-presence', compact('month', 'year', 'months', 'recapPresence', 'rangeDate', 'totalDays'));
    
    }
}
