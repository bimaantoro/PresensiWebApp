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
        $dataIzinQuery = DB::table('pengajuan_izin')
        ->where('user_id', $idStudent);
        
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

    public function showAct($id) {
        $dataIzin = DB::table('pengajuan_izin')
        ->where('id', $id)
        ->first();

        return view('pengajuan-izin.show-act', compact('dataIzin'));
    }

    public function destroy($id) {

        $checkDataIzin = DB::table('pengajuan_izin')
        ->where('id', $id)
        ->first();

        $fileSuratDokter = $checkDataIzin->file_surat_dokter;

        try {
            DB::table('pengajuan_izin')
            ->where('id', $id)
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
