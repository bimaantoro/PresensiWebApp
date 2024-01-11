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
        $idStudent = Auth::user()->id;
        $checkIsPresence = DB::table('presences')
        ->where('presence_at', date('Y-m-d'))
        ->where('user_id', $idStudent)
        ->count();

        return view('presence.create', compact('checkIsPresence'));
    }

    public function store(Request $request) {

        $idStudent = Auth::user()->id;

        $presenceAt = date('Y-m-d');
        $presenceHour = date('H:i:s');

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $latitudeKantor = 1.4876672; 
        $longitudeKantor = 124.8526336;
        $distance = $this->distance($latitudeKantor, $longitudeKantor, $latitude, $longitude);
        $radius = round($distance["meters"]);

        $checkIsPresence = DB::table('presences')
        ->where('presence_at', $presenceAt)
        ->where('user_id', $idStudent)
        ->count();

        if($checkIsPresence > 0) {
            $note = 'out'; 
        } else {
            $note = 'in';
        }

        $image = $request->image;
        $folderPath = 'public/uploads/presence/';
        $imageParts = explode(';base64', $image);
        $decodeImage = base64_decode($imageParts[1]);
        $formatName = $idStudent . "-" . $presenceAt . '-' . $note;
        $fileName = $formatName . '.png';
        $file = $folderPath . $fileName;

        if($radius >= 20) {
            echo 'error|Anda berada diluar radius kantor, Jarak Anda ' . $radius . ' meter dari kantor';
        } else {
            if($checkIsPresence > 0) {
                $dataCheckOut = [
                    'check_out' => $presenceHour,
                    'photo_out' => $fileName,
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ];
                $update = DB::table('presences')
                ->where('presence_at', $presenceAt)
                ->where('user_id', $idStudent)
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
                    'user_id' => $idStudent,
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
