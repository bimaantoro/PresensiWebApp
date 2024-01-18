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
            ->orderBy('from_date', 'desc')
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

    public function create() {
        return view('pengajuan-izin.create');
    }
    
    public function store(Request $request) {
        $idStudent = Auth::guard('employee')->user()->id_employee;
        $izinAt = $request->izinAt;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'izin_at' => $izinAt,
            'status' => $status,
            'keterangan' => $keterangan,
            'employee_id' => $idStudent,
        ];

        $save = DB::table('pengajuan_izin')->insert($data);

        if($save) {
            return redirect()->route('pengajuan-izin')->with(['success' => 'Data berhasil disimpan']);
        } else {
            return redirect()->route('pengajuan-izin')->with(['error' => 'Data gagal disimpan']);
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
