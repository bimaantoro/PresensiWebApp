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
        $latitudeKantor = 0.5560944233072398; 
        $longitudeKantor = 123.13342749923635;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $distance = $this->distance($latitudeKantor, $longitudeKantor, $latitude, $longitude);
        $radius = round($distance["meters"]);

        $checkIsPresence = DB::table('presences')
        ->where('presence_at', $presenceAt)
        ->where('employee_id', $idEmployee)
        ->count();

        if($distance >= 20) {
            echo 'error|Anda berada diluar radius kantor';
        } else {
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
                    echo 'success|Berhasil melakukan absensi pulang';
                    Storage::put($file, $decodeImage);
                } else {
                    echo 'error|gagal melakukan absensi pulang, Silahkan hubungi admin';
                }
            } else  {
                $dataCheckIn = [
                    'check_in' => $presenceHour,
                    'photo_in' => $fileName,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'presence_at' => $presenceAt,
                    'employee_id' => $idEmployee,
                ];
        
                $save = DB::table('presences')->insert($dataCheckIn);
        
                if($save) {
                    echo 'success|Berhasil melakukan absensi masuk';
                    Storage::put($file, $decodeImage);
                } else {
                    echo 'error|Gagal melakukan absensi masuk, Silahkan hubungi admin';
                }
            }
        }
    }

    // Menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
