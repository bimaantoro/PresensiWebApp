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
        $query->select('id', 'from_date_at', 'pengajuan_izin.employee_id', 'fullname', 'position', 'status', 'keterangan', 'status_approved');
        $query->join('employees', 'pengajuan_izin.employee_id', '=', 'employees.id_employee');
        $query->orderBy('from_date_at', 'desc');


        if(!empty($request->from) && !empty($request->to)) {
            $query->whereBetween('from_date_at', [$request->from, $request->to]);
        }

        if(!empty($request->employee_id)) {
            $query->where('pengajuan_izin.employee_id', $request->employee_id);
        }

        if(!empty($request->fullname)) {
            $query->where('fullname', 'LIKE', '%' . $request->fullname . '%');
        } 

        if($request->status_approved != '') {
            $query->where('status_approved', $request->status_approved);
        } 

        $dataIzin = $query->paginate(10);
        $dataIzin->appends($request->all());

        return view('admin.pengajuan-izin.index', compact('dataIzin'));
    }

    public function update(Request $request) {
        $statusApproved = $request->status_approved;
        $id = $request->id;

        $update = DB::table('pengajuan_izin')
        ->where('id', $id)
        ->update([
            'status_approved' => $statusApproved
        ]);

        if($update) {
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }

    public function updateStatusApproved($id) {
        $update = DB::table('pengajuan_izin')
        ->where('id', $id)
        ->update([
            'status_approved' => 0
        ]);

        if($update) {
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }
}
