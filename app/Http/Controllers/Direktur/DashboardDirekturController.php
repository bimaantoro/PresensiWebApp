<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardDirekturController extends Controller
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

        return view('direktur.dashboard.report-presence', compact('employees', 'months'));
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
        ->select('presences.*', 'keterangan_izin', 'working_hours.*')
        ->leftJoin('working_hours', 'presences.working_hour_id', '=', 'working_hours.id')
        ->leftJoin('pengajuan_izin', 'presences.pengajuan_izin_id', '=', 'pengajuan_izin.id')
        ->where('presences.employee_id', $idEmployee)
        ->whereRaw('MONTH(presence_at)="' . $month . '"')
        ->whereRaw('YEAR(presence_at)="' . $year . '"')
        ->orderBy('presence_at')
        ->get();

        if(isset($_POST['export-excel'])) {
            $time = date('d-M-Y H:i:s');
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap Presensi Peserta $time.xls");

            return view('direktur.dashboard.print-excel-presence', compact('months', 'month', 'year', 'employee', 'presence'));
        }

        return view('direktur.dashboard.print-presence', compact('months', 'month', 'year', 'employee', 'presence'));
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
                IFNULL(working_hours.name, 'NA'), '|',
                IFNULL(working_hours.jam_in, 'NA'), '|',
                IFNULL(working_hours.jam_out, 'NA'), '|',
                IFNULL(presences.pengajuan_izin_id, 'NA'), '|',
                IFNULL('keterangan_izin', 'NA'), '|'
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
        $query->selectRaw("$fieldDate employees.id_employee, fullname, position");
        $query->leftJoin(
            DB::raw("(
                SELECT
                $selectDate
                presences.employee_id
                FROM presences
                LEFT JOIN working_hours ON presences.working_hour_id = working_hours.id
                LEFT JOIN pengajuan_izin ON presences.pengajuan_izin_id = pengajuan_izin.id
                WHERE presence_at BETWEEN '$rangeDate[0]' AND '$endDate'
                GROUP BY presences.employee_id
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

        return view('direktur.dashboard.print-recap-presence', compact('month', 'year', 'months', 'recapPresence', 'rangeDate', 'totalDays'));
    }
}
