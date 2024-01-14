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
        $query->select('id', 'start_date', 'user_id', 'nama_lengkap', 'instansi', 'status', 'keterangan', 'status_code');
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
        $id = $request->id_pengajuan_izin_form;

        $update = DB::table('pengajuan_izin')
        ->where('kode_izin', $id)
        ->update([
            'status_code' => $statusCode
        ]);

        if($update) {
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }

    public function decline($id) {
        $update = DB::table('pengajuan_izin')
        ->where('kode_izin', $id)
        ->update([
            'status_code' => 0
        ]);

        if($update) {
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }
}
