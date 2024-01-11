<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanIzinSakitController extends Controller
{
    //
    public function create() {
        return view('pengajuan-izin.sakit.create');
    }

    public function store(Request $request) {
        $idStudent = Auth::user()->id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = "s";
        $keterangan = $request->keterangan;

        $month = date('m', strtotime($startDate));
        $year = date('Y', strtotime($startDate));
        $formatYear = substr($year, 2, 2);

        $latestIzin = DB::table('pengajuan_izin_siswa')
        ->whereRaw('MONTH(start_date)="' . $month . '"')
        ->whereRaw('YEAR(start_date)="' . $year . '"')
        ->orderBy('kode_izin', 'desc')
        ->first();

        $latestKodeIzin = $latestIzin != null ? $latestIzin->kode_izin : "";
        $formatKey = "IZ" . $month . $formatYear;
        $kodeIzin = kodeIzin($latestKodeIzin, $formatKey, 3);

        if($request->hasFile('file_surat_dokter')) {
            $fileSuratDokter = $kodeIzin . '.' . $request->file('file_surat_dokter')->getClientOriginalExtension();
        } else {
            $fileSuratDokter = null;
        }

        $data = [
            'kode_izin' => $kodeIzin,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'keterangan' => $keterangan,
            'file_surat_dokter' => $fileSuratDokter,
            'user_id' => $idStudent,
        ];

        $save = DB::table('pengajuan_izin_siswa')->insert($data);

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

    public function edit($kodeIzin) {
        $dataIzin =  DB::table('pengajuan_izin_siswa')
        ->where('kode_izin', $kodeIzin)
        ->first();

        return view('pengajuan-izin.sakit.edit', compact('dataIzin'));
    }

    public function update($kodeIzin, Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $keterangan = $request->keterangan;

        if($request->hasFile('file_surat_dokter')) {
            $fileSuratDokter = $kodeIzin . '.' . $request->file('file_surat_dokter')->getClientOriginalExtension();
        } else {
            $fileSuratDokter = null;
        }

        $data = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'keterangan' => $keterangan,
            'file_surat_dokter' => $fileSuratDokter,
        ];       

        try {
            DB::table('pengajuan_izin_siswa')
            ->where('kode_izin', $kodeIzin)
            ->update($data);

            if($request->hasFile('file_surat_dokter')) {
                $fileSuratDokter = $kodeIzin . '.' . $request->file('file_surat_dokter')->getClientOriginalExtension();
                $folderPath = 'public/uploads/suratDokter';
                $request->file('file_surat_dokter')->storeAs($folderPath, $fileSuratDokter);
            }

            return redirect()->route('pengajuan-izin')->with(['success' => 'Data barhasil diperbarui']);

        }catch(\Exception $e) {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Data gagal diperbarui']);
        }
    }

}
