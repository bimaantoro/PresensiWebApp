<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresenceEmployeeController extends Controller
{
    //
    public function index() {
        return view('admin.presence.index');
    }

    public function getPresence(Request $request) {
        $date = $request->date;

        $presence = DB::table('presences')
        ->select('presences.*', 'fullname')
        ->join('employees', 'presences.employee_id', '=', 'employees.id_employee')
        ->where('presence_at', $date)
        ->get();

        return view('admin.presence.get-presence', compact('presence'));
    }

    public function showMap(Request $request) {
        $id = $request->id;
        
        $presence = DB::table('presences')
        ->join('employees', 'presences.employee_id', '=', 'employees.id_employee')
        ->where('id', $id)
        ->first();

        return view('admin.presence.show-map', compact('presence'));
    }
}
