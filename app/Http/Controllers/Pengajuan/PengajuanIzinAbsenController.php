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
        $jumlahHari = $request->jumlah_hari;
        $status = "I";
        $keterangan = $request->keterangan_izin;

        $month = date('m', strtotime($startDate));
        $year = date('Y', strtotime($startDate));
        $formatYear = substr($year, 2, 2);

        $latestIzin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(start_date)="' . $month . '"')
        ->whereRaw('YEAR(start_date)="' . $year . '"')
        ->orderBy('id', 'desc')
        ->first();

        $latestKodeIzin = $latestIzin != null ? $latestIzin->kode_izin : "";
        $formatKey = "IZ" . $month . $formatYear;
        $kodeIzin = kodeIzin($latestKodeIzin, $formatKey, 3);

        $data = [
            'id' => $kodeIzin,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'keterangan_izin' => $keterangan,
            'jumlah_hari' => $jumlahHari,
            'user_id' => $idStudent,
        ];

        // cek sudah presensi / belum
        $checkIsPresence = DB::table('presences')
        ->whereBetween('presence_at', [$startDate, $endDate]);

        // cek pengajuan izin
        $checkPengajuanIzin = DB::table('pengajuan_izin')
        ->whereRaw('"' . $startDate . '" BETWEEN start_date AND end_date');

        // Hitung jumlah hari yang digunakan
        $jumlahHari = calculateDay($startDate, $endDate);
        $jumlahMaxAbsen = 3;

        $absenDigunakan = DB::table('presences')
        ->whereRaw('MONTH(presence_at)="' . $month . '"')
        ->where('presence_status', 'I')
        ->where('user_id', $idStudent)
        ->count();

        // sisa izin absen
        $sisaIzinAbsen = $jumlahMaxAbsen - $absenDigunakan;

        $dataPresence = $checkIsPresence->get();

        if($jumlahHari > $sisaIzinAbsen) {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Jumlah Izin Absen melebihi batas maksimal yang ditentukan oleh Admin yaitu, ' . $sisaIzinAbsen . ' Hari']);
        } else if($checkIsPresence->count() > 0) {
            $blacklistDate = "";
            foreach($dataPresence as $dp) {
                $blacklistDate .= date('d-m-Y', strtotime($dp->presence_at)) . "," ;
            }
            return redirect()->route('pengajuan-izin')->with(['error' => 'Tidak bisa melakukan pengajuan pada tanggal ' . $blacklistDate . ' karena tanggal tersebut sudah melakukan presensi.']);
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
