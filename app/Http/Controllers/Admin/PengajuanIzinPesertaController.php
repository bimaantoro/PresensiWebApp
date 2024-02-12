<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanIzinPesertaController extends Controller
{
    //
    public function index(Request $request) {
        $query = PengajuanIzin::query();
        $query->select('pengajuan_izin.id', 'start_date', 'end_date', 'pengajuan_izin.user_id', 'file_surat_dokter', 'nama_lengkap', 'instansi', 'status', 'keterangan_izin', 'status_code');
        $query->join('users', 'pengajuan_izin.user_id', '=', 'users.id');
        $query->orderBy('start_date', 'desc');

        


        if(!empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        if(!empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        if(!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'LIKE', '%' . $request->nama_lengkap . '%');
        } 

        if($request->status_code != '') {
            $query->where('status_code', $request->status_code);
        } 

        $dataIzin = $query->paginate(10);
        $dataIzin->appends($request->all());

        return view('admin.pengajuan-izin.index', compact('dataIzin'));
    }

    public function update(Request $request) {
        $statusCode = $request->status_code;
        $idIzin = $request->id_izin_form;
        $tolakPengajuan = $request->keterangan_penolakan;

        $dataIzin = DB::table('pengajuan_izin')
        ->where('id', $idIzin)
        ->first();

        $idStudent = $dataIzin->user_id;
        $startDate = $dataIzin->start_date;
        $endDate = $dataIzin->end_date;
        $status = $dataIzin->status;

        DB::beginTransaction();
        try {
            if($statusCode == 1) {
                while(strtotime($startDate) <= strtotime($endDate)) {
                    DB::table('presences')
                    ->insert([
                        'user_id' => $idStudent,
                        'presence_at' => $startDate,
                        'presence_status' => $status,
                        'pengajuan_izin_id' => $idIzin,
                    ]);
                    $startDate = date('Y-m-d', strtotime('+1 days', strtotime($startDate)));
                }
            }

            DB::table('pengajuan_izin')
            ->where('id', $idIzin)
            ->update([
                'status_code' => $statusCode,
                'keterangan_penolakan' => $tolakPengajuan,
            ]);

            DB::commit();

            return redirect()->back()->with(['success' => 'Data berhasil diproses']);
        }catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Data gagal diproses']);
        }
    }

    public function decline($id) {
        try {
            DB::table('pengajuan_izin')
            ->where('id', $id)
            ->update([
                'status_code' => 0
            ]);

            DB::table('presences')
            ->where('pengajuan_izin_id', $id)
            ->delete();

            DB::commit();

            return redirect()->back()->with(['success' => 'Data berhasil dibatalkan']);

        }catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Data gagal diperbarui']);
        }
    }
}
