<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    //
    public function index() {
        $today = date('Y-m-d');

        $dataPresence = DB::table('presences')
        ->selectRaw('COUNT(user_id) as jmlh_hadir, SUM(IF(check_in > "07:00", 1, 0)) as jmlh_terlambat')
        ->where('presence_at', $today)
        ->first();

        $dataIzin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i", 1, 0)) as jmlh_izin, SUM(IF(status="s", 1, 0)) as jmlh_sakit')
        ->where('start_date', $today)
        ->where('status_code', 1)
        ->first();


        return view('admin.dashboard.index', compact('dataPresence', 'dataIzin'));
    }

    public function getPresence(Request $request) {
        $date = $request->date;

        $presence = DB::table('presences')
        ->select('presences.*', 'nama_lengkap')
        ->join('users', 'presences.user_id', '=', 'users.id')
        ->where('presence_at', $date)
        ->get();

        return view('admin.presence.get-presence', compact('presence'));
    }

    public function showMap(Request $request) {
        $id = $request->id;
        
        $presence = DB::table('presences')
        ->join('users', 'presences.user_id', '=', 'users.id')
        ->where('id', $id)
        ->first();

        return view('admin.presence.show-map', compact('presence'));
    }
}
