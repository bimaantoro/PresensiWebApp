<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigWorkingHourController extends Controller
{
    //
    public function index() {
        $workHours = DB::table('working_hours')
        ->orderBy('id')
        ->get();
        return view('admin.config.work-hour.index', compact('workHours'));
    }

    public function store(Request $request) {
        $idJamKerja = $request->id;
        $name = $request->name;
        $startCheckIn = $request->start_check_in;
        $checkIn = $request->jam_in;
        $endCheckIn = $request->end_check_in;
        $checkOut = $request->jam_out;

        $data = [
            'id' => $idJamKerja,
            'name' => $name,
            'start_check_in' => $startCheckIn,
            'jam_in' => $checkIn,
            'end_check_in' => $endCheckIn,
            'jam_out' => $checkOut,
        ];

        try {
            DB::table('working_hours')->insert($data);
            return redirect()->back()->with(['success' => 'Data berhasil disimpan']);
        }catch(\Exception $e) {
            return redirect()->back()->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function edit(Request $request) {
        $idJamKerja = $request->id;

        $workHours = DB::table('working_hours')
        ->where('id', $idJamKerja)
        ->first();

        return view('admin.config.work-hour.edit', compact('workHours'));
    }

    public function update($id, Request $request) {
        $idJamKerja = $request->id;
        $namaJamKerja = $request->name;
        $startCheckIn = $request->start_check_in;
        $checkIn = $request->jam_in;
        $endCheckIn = $request->end_check_in;
        $checkOut = $request->jam_out;

        $data = [
            'name' => $namaJamKerja,
            'start_check_in' => $startCheckIn,
            'jam_in' => $checkIn,
            'end_check_in' => $endCheckIn,
            'jam_out' => $checkOut,
        ];

        try {
            DB::table('working_hours')
            ->where('id', $idJamKerja)
            ->update($data);
            return redirect()->back()->with(['success' => 'Data berhasil diperbarui']);
        }catch(\Exception $e) {
            return redirect()->back()->with(['error' => 'Data gagal diperbarui']);
        }
    }

    public function destroy($id) {
        $delete = DB::table('working_hours')
        ->where('id', $id)
        ->delete();

        if($delete) {
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data gagal dihapus');
        }
    }
}
