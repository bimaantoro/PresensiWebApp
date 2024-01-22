<?php

namespace App\Http\Controllers\Presence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresenceController extends Controller
{
    //
    public function create() {
        $idEmployee = Auth::guard('employee')->user()->id_employee;
        $checkIsPresence = DB::table('presences')
        ->where('presence_at', date('Y-m-d'))
        ->where('employee_id', $idEmployee)
        ->count();

        return view('presence.create', compact('checkIsPresence'));
    }

    public function store(Request $request) {

        $idEmployee = Auth::guard('employee')->user()->id_employee;

        $presenceAt = date('Y-m-d');
        $presenceHour = date('H:i:s');

        $image = $request->image;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $checkIsPresence = DB::table('presences')
        ->where('presence_at', $presenceAt)
        ->where('employee_id', $idEmployee)
        ->count();

        if($checkIsPresence > 0) {
            $note = 'out'; 
        } else {
            $note = 'in';
        }

        $folderPath = 'public/uploads/presence/';
        $imageParts = explode(';base64', $image);
        $decodeImage = base64_decode($imageParts[1]);

        $formatName = $idEmployee . "-" . $presenceAt . '-' . $note;
        $fileName = $formatName . '.png';
        $file = $folderPath . $fileName;

        if($checkIsPresence > 0) {
            $dataCheckOut = [
                'check_out' => $presenceHour,
                'photo_out' => $fileName,
                'latitude' => $latitude,
                'longitude' => $longitude
            ];
            $update = DB::table('presences')
            ->where('presence_at', $presenceAt)
            ->where('employee_id', $idEmployee)
            ->update($dataCheckOut);

            if ($update) {
                echo 'success|Berhasil melakukan presensi pulang';
                Storage::put($file, $decodeImage);
            } else {
                echo 'error|gagal melakukan presensi pulang, Silahkan hubungi admin';
            }
        } else  {
            $dataCheckIn = [
                'check_in' => $presenceHour,
                'photo_in' => $fileName,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'presence_at' => $presenceAt,
                'employee_id' => $idEmployee,
                'presence_status' => 'H' 
            ];
    
            $save = DB::table('presences')->insert($dataCheckIn);
    
            if($save) {
                echo 'success|Berhasil melakukan presensi masuk';
                Storage::put($file, $decodeImage);
            } else {
                echo 'error|Gagal melakukan presensi masuk, Silahkan hubungi admin';
            }
        }
    }
}
