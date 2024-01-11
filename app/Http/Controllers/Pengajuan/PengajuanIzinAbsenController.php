<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanIzinAbsenController extends Controller
{
    //
    public function create() {
        return view('pengajuan-izin.absen.create');
    }

    public function store(Request $request) {
        $idStudent = Auth::user()->id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = "i";
        $keterangan = $request->keterangan;

        $month = date('m', strtotime($startDate));
        $year = date('Y', strtotime($startDate));
        $formatYear = substr($year, 2, 2);

        $latestIzin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(start_date)="' . $month . '"')
        ->whereRaw('YEAR(start_date)="' . $year . '"')
        ->orderBy('kode_izin', 'desc')
        ->first();

        $latestKodeIzin = $latestIzin != null ? $latestIzin->kode_izin : "";
        $formatKey = "IZ" . $month . $formatYear;
        $kodeIzin = kodeIzin($latestKodeIzin, $formatKey, 3);

        $data = [
            'kode_izin' => $kodeIzin,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'keterangan' => $keterangan,
            'user_id' => $idStudent,
        ];

        $save = DB::table('pengajuan_izin')->insert($data);

        if($save) {
            return redirect()->route('pengajuan-izin')->with(['success' => 'Data berhasil disimpan']);
        } else {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function edit($kodeIzin) {
        $dataIzin =  DB::table('pengajuan_izin')
        ->where('kode_izin', $kodeIzin)
        ->first();

        return view('pengajuan-izin.absen.edit', compact('dataIzin'));
    }

    public function update($kodeIzin, Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $keterangan = $request->keterangan;

        try {
            $data = [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'keterangan' => $keterangan
            ];

            DB::table('pengajuan_izin')
            ->where('kode_izin', $kodeIzin)
            ->update($data);

            return redirect()->route('pengajuan-izin')->with(['success' => 'Data berhasil diperbarui']);

        } catch(\Exception $e) {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Data gagal diperbarui']);
        }
    }
}
