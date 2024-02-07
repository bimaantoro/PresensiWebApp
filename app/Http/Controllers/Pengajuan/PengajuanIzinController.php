<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanIzinController extends Controller
{
    //
    public function index(Request $request) {
        $idStudent = Auth::user()->id;
        
        if(!empty($request->month) && !empty($request->year)) {
            $dataIzin = DB::table('pengajuan_izin')
            ->orderBy('start_date', 'desc')
            ->where('user_id', $idStudent)
            ->whereRaw('MONTH(start_date)="' . $request->month . '"')
            ->whereRaw('YEAR(start_date)="' . $request->year . '"')
            ->get();
        } else {
            $dataIzin = DB::table('pengajuan_izin')
            ->where('user_id', $idStudent)
            ->limit(5)
            ->orderBy('start_date', 'desc')
            ->get();
        }

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

    public function showAct($kodeIzin) {
        $dataIzin = DB::table('pengajuan_izin')
        ->where('kode_izin', $kodeIzin)
        ->first();

        return view('pengajuan-izin.show-act', compact('dataIzin'));
    }

    public function destroy($kodeIzin) {

        $checkDataIzin = DB::table('pengajuan_izin')
        ->where('kode_izin', $kodeIzin)
        ->first();

        $fileSuratDokter = $checkDataIzin->file_surat_dokter;

        try {
            DB::table('pengajuan_izin')
            ->where('kode_izin', $kodeIzin)
            ->delete();

            if($fileSuratDokter != null) {
                Storage::delete('/public/uploads/suratDokter/' . $fileSuratDokter);
            }
            
            return redirect()->route('pengajuan-izin')->with(['success' => 'Data berhasil dihapus']);

        }catch(\Exception $e) {
            return redirect()->route('pengajuan-izin')->with(['erorr' => 'Data gagal dihapus']);
        }
    }
}
