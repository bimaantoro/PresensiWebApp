<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanIzinController extends Controller
{
    //
    public function index(Request $request) {
        $idEmployee = Auth::user()->id_employee;
        $dataIzinQuery = DB::table('pengajuan_izin')
        ->where('employee_id', $idEmployee);
        
        if(!empty($request->month) && !empty($request->year)) {
            $dataIzinQuery->whereMonth('start_date', $request->month)
            ->whereYear('start_date', $request->year);
        } else {
            $dataIzinQuery->orderByDesc('start_date')
            ->limit(5);
        }

        $dataIzin = $dataIzinQuery->orderBy('start_date', 'desc')
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

        return view('pengajuan-izin.index', compact('dataIzin', 'months'));
    }

    public function createAbsen() {
        return view('pengajuan-izin.absen.create');
    }

    public function storeAbsen(Request $request) {
        $idEmployee = Auth::guard('employee')->user()->id_employee;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = "I";
        $keterangan = $request->keterangan_izin;

        $month = date('m', strtotime($startDate));
        $year = date('Y', strtotime($startDate));
        $formatYear = substr($year, 2, 2);

        $latestIzin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(start_date)="' . $month . '"')
        ->whereRaw('YEAR(start_date)="' . $year . '"')
        ->orderByDesc('id')
        ->first();

        $latestKodeIzin = $latestIzin != null ? $latestIzin->id : "";
        $formatKey = "IZ" . $month . $formatYear;
        $kodeIzin = kodeIzin($latestKodeIzin, $formatKey, 3);

        $data = [
            'id' => $kodeIzin,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'keterangan_izin' => $keterangan,
            'employee_id' => $idEmployee,
        ];

        // cek sudah presensi / belum
        $checkIsPresence = DB::table('presences')
        ->whereBetween('presence_at', [$startDate, $endDate])
        ->where('employee_id', $idEmployee);

        // cek pengajuan izin
        $checkPengajuanIzin = DB::table('pengajuan_izin')
        ->where('employee_id', $idEmployee)
        ->whereRaw('"' . $startDate . '" BETWEEN start_date AND end_date');


        $dataPresence = $checkIsPresence->get();

        if ($checkIsPresence->count() > 0) {
            $blacklistDate = "";
            foreach($dataPresence as $dp) {
                $blacklistDate .= date('d-m-Y', strtotime($dp->presence_at)) . "," ;
            }
            return redirect()->route('pengajuan-izin')->with(['error' => 'Tidak bisa melakukan pengajuan pada tanggal ' . $blacklistDate . ' karena tanggal sudah melakukan presensi, Silahkan ganti periode tanggal pengajuan.']);
        } else if($checkPengajuanIzin->count() > 0) {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Anda sudah melakukan pengajuan izin pada tanggal tersebut']);
        }  else {
            $save = DB::table('pengajuan_izin')->insert($data);

            if($save) {
                return redirect()->route('pengajuan-izin')->with(['success' => 'Data berhasil disimpan']);
            } else {
                return redirect()->route('pengajuan-izin')->with(['error' => 'Data gagal disimpan']);
            }
        }
    }

    public function createSakit() {
        return view('pengajuan-izin.sakit.create');
    }

    public function storeSakit(Request $request) {
        $idEmployee = Auth::guard('employee')->user()->id_employee;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = "S";
        $keterangan = $request->keterangan_izin;

        $month = date('m', strtotime($startDate));
        $year = date('Y', strtotime($startDate));
        $formatYear = substr($year, 2, 2);

        $latestIzin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(start_date)="' . $month . '"')
        ->whereRaw('YEAR(start_date)="' . $year . '"')
        ->orderByDesc('id')
        ->first();

        $latestKodeIzin = $latestIzin != null ? $latestIzin->id : "";
        $formatKey = "IZ" . $month . $formatYear;
        $kodeIzin = kodeIzin($latestKodeIzin, $formatKey, 3);

        if($request->hasFile('file_surat_dokter')) {
            $fileSuratDokter = $kodeIzin . '.' . $request->file('file_surat_dokter')->getClientOriginalExtension();
        } else {
            $fileSuratDokter = null;
        }

        $data = [
            'id' => $kodeIzin,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'keterangan_izin' => $keterangan,
            'file_surat_dokter' => $fileSuratDokter,
            'employee_id' => $idEmployee,
        ];

        // cek sudah presensi / belum
        $checkIsPresence = DB::table('presences')
        ->whereBetween('presence_at', [$startDate, $endDate])
        ->where('employee_id', $idEmployee);

        // cek pengajuan izin
        $checkPengajuanIzin = DB::table('pengajuan_izin')
        ->where('employee_id', $idEmployee)
        ->whereRaw('"' . $startDate . '" BETWEEN start_date AND end_date');

        $dataPresence = $checkIsPresence->get();

        if($checkIsPresence->count() > 0) {
            $blacklistDate = "";
            foreach($dataPresence as $dp) {
                $blacklistDate .= date('d-m-Y', strtotime($dp->presence_at)) . "," ;
            }
            return redirect()->route('pengajuan-izin')->with(['error' => 'Tidak bisa melakukan pengajuan pada tanggal ' . $blacklistDate . 'karena tanggal sudah melakukan presensi, Silahkan ganti periode tanggal pengajuan.']);
        } elseif($checkPengajuanIzin->count() > 0) {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Anda sudah melakukan pengajuan izin pada tanggal tersebut']);
        } else {
            $save = DB::table('pengajuan_izin')->insert($data);

            if($save) {
                if($request->hasFile('file_surat_dokter')) {
                    $fileSuratDokter = $kodeIzin . '.' . $request->file('file_surat_dokter')->getClientOriginalExtension();
                    $folderPath = 'public/uploads/suratDokter';
                    $request->file('file_surat_dokter')->storeAs($folderPath, $fileSuratDokter);
                }
    
                return redirect()->route('pengajuan-izin')->with(['success' => 'Data berhasil disimpan']);
            } else {
                return redirect()->route('pengajuan-izin')->with(['error' => 'Data gagal disimpan']);
            }
        }
    }

    public function cekPengajuanIzin(Request $request) {
        $izinAt = $request->izinAt;
        $idEmployee = Auth::guard('employee')->user()->id_employee;

        $cek = DB::table('pengajuan_izin')
        ->where('employee_id', $idEmployee)
        ->where('from_date_at', $izinAt)
        ->count();

        return $cek;
    }
}
