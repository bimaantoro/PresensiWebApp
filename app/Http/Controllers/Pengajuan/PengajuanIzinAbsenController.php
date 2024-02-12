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
        $jumlahIzin = $request->jumlah_izin;
        $status = "I";
        $keterangan = $request->keterangan_izin;

        $month = date('m', strtotime($startDate));
        $year = date('Y', strtotime($startDate));
        $formatYear = substr($year, 2, 2);

        $latestIzin = DB::table('pengajuan_izin')
        ->whereMonth('start_date', $month)
        ->whereYear('start_date', $year)
        ->orderByDesc('id')
        ->first();

        $latestIdIzin = $latestIzin ? $latestIzin->id : "";
        $formatKey = "IZ" . $month . $formatYear;
        $idIzin = kodeIzin($latestIdIzin, $formatKey, 3);

        $data = [
            'id' => $idIzin,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
            'keterangan_izin' => $keterangan,
            'jumlah_izin' => $jumlahIzin,
            'user_id' => $idStudent,
        ];

        // check presence
        $checkIsPresence = DB::table('presences')
        ->whereBetween('presence_at', [$startDate, $endDate])
        ->count();

        if($checkIsPresence > 0) {
            $blacklistDate = DB::table('presences')
            ->whereBetween('presence_at', [$startDate, $endDate])
            ->pluck('presence_at')
            ->map(function ($date) {
                return date('d-m-Y', strtotime($date));
            })
            ->implode(', ');

            return redirect()->route('pengajuan-izin')->with(['error' => 'Tidak bisa melakukan pengajuan izin pada tanggal ' . $blacklistDate . ', karena Anda sudah melakukan presensi pada tanggal tersebut.']);
        }

        // check previous leave request
        $checkPengajuanIzin = DB::table('pengajuan_izin')
        ->whereBetween('start_date', [$startDate, $endDate])
        ->orWhereBetween('end_date', [$startDate, $endDate])
        ->count();

        if($checkPengajuanIzin > 0) {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Anda sudah melakukan pengajuan izin pada tanggal tersebut']);
        }

        // calculate remaining leave days
        $jumlahMaxAbsen = 3;
        $absenDigunakan = DB::table('presences')
        ->whereMonth('presence_at', $month)
        ->where('presence_status', 'I')
        ->where('user_id', $idStudent)
        ->count();
        $sisaIzinAbsen = $jumlahMaxAbsen - $absenDigunakan;

        // check if leave days exceed remaining leave balance
        if($jumlahIzin > $sisaIzinAbsen) {
            return  redirect()->route('pengajuan-izin')->with(['error' => 'Jumlah Izin Absen melebihi batas maksimal yang ditentukan oleh Admin yaitu, ' . $sisaIzinAbsen . ' Hari']);
        }

        // save leave request
        $save = DB::table('pengajuan_izin')->insert($data);

        if($save) {
            return redirect()->route('pengajuan-izin')->with(['success' => 'Data berhasil disimpan']);
        } else {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function edit($id) {
        $dataIzin =  DB::table('pengajuan_izin')
        ->where('id', $id)
        ->first();

        return view('pengajuan-izin.absen.edit', compact('dataIzin'));
    }

    public function update($id, Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $keterangan = $request->keterangan_izin;
        $jumlahIzin = $request->jumlah_izin;

        try {
            $data = [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'jumlah_izin' => $jumlahIzin,
                'keterangan_izin' => $keterangan
            ];

            DB::table('pengajuan_izin')
            ->where('id', $id)
            ->update($data);

            return redirect()->route('pengajuan-izin')->with(['success' => 'Data berhasil diperbarui']);

        } catch(\Exception $e) {
            dd($e);
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

    /* public function store(Request $request) {
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

        $latestKodeIzin = $latestIzin != null ? $latestIzin->id : "";
        $formatKey = "IZ" . $month . $formatYear;
        $idIzin = kodeIzin($latestKodeIzin, $formatKey, 3);

        $data = [
            'id' => $idIzin,
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
    } */
}
