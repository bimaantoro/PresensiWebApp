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
        $status = "S";
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

        $checkIsPresence = DB::table('presences')
        ->whereBetween('presence_at', [$startDate, $endDate]);

        // cek pengajuan izin
        $checkPengajuanIzin = DB::table('pengajuan_izin')
        ->whereRaw('"' . $startDate . '" BETWEEN start_date AND end_date');

        $dataPresence = $checkIsPresence->get();

        if($checkIsPresence->count() > 0) {
            $blacklistDate = "";
            foreach($dataPresence as $dp) {
                $blacklistDate .= date('d-m-Y', strtotime($dp->presence_at)) . "," ;
            }
            return redirect()->route('pengajuan-izin')->with(['error' => 'Tidak bisa melakukan pengajuan pada tanggal ' . $blacklistDate . 'karena tanggal sudah melakukan presensi, Silahkan ganti periode tanggal pengajuan.']);
        } elseif($checkPengajuanIzin->count() > 0) {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Anda sudah melakukan pengajuan izin Sakit pada tanggal tersebut']);
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

    public function edit($kodeIzin) {
        $dataIzin =  DB::table('pengajuan_izin')
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
            DB::table('pengajuan_izin')
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

    public function check(Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $idStudent = Auth::user()->id;

        $check = DB::table('pengajuan_izin')
        ->where('user_id', $idStudent)
        ->where('start_date', $startDate)
        ->where('end_date', $endDate)
        ->count();

        return $check;
    }

}
