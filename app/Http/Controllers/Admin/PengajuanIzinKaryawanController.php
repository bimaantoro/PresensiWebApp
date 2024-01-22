<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanIzinKaryawanController extends Controller
{
    //
    public function index(Request $request) {

        $query = PengajuanIzin::query();
        $query->select('kode_izin', 'start_date', 'end_date', 'employee_id', 'fullname', 'position', 'status', 'keterangan_izin', 'status_code');
        $query->join('employees', 'pengajuan_izin.employee_id', '=', 'employees.id_employee');
        $query->orderBy('start_date', 'desc');

        if(!empty($request->start_date) && !empty($request->end_date)) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        if(!empty($request->employee_id)) {
            $query->where('employee_id', $request->employee_id);
        }

        if(!empty($request->fullname)) {
            $query->where('fullname', 'LIKE', '%' . $request->fullname . '%');
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
        $kodeIzin = $request->kode_izin_form;
        $tolakPengajuan = $request->keterangan_penolakan;

        $dataIzin = DB::table('pengajuan_izin')
        ->where('kode_izin', $kodeIzin)
        ->first();

        $idEmployee = $dataIzin->employee_id;
        $startDate = $dataIzin->start_date;
        $endDate = $dataIzin->end_date;
        $status = $dataIzin->status;

        DB::beginTransaction();
        try {
            if($statusCode == 1) {
                while(strtotime($startDate) <= strtotime($endDate)) {
                    DB::table('presences')
                    ->insert([
                        'employee_id' => $idEmployee,
                        'presence_at' => $startDate,
                        'presence_status' => $status,
                        'kode_izin' => $kodeIzin,
                    ]);
                    $startDate = date('Y-m-d', strtotime('+1 days', strtotime($startDate)));
                }
            }

            DB::table('pengajuan_izin')
            ->where('kode_izin', $kodeIzin)
            ->update([
                'status_code' => $statusCode,
                'keterangan_penolakan' => $tolakPengajuan,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        }catch(\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }

    public function decline($kodeIzin) {
        try {
            DB::table('pengajuan_izin')
            ->where('kode_izin', $kodeIzin)
            ->update([
                'status_code' => 0
            ]);

            DB::table('presences')
            ->where('kode_izin', $kodeIzin)
            ->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil dibatalkan');

        }catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }
}
