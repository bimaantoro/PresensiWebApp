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

    public function getDay() {
        $day = date('D');

        switch($day) {
            case 'Sun':
                $today = 'Minggu';
                break;
            case 'Mon': 
                $today = 'Senin';
                break;
            case 'Tue':
                $today = 'Selasa';
                break;
            case 'Wed':
                $today = 'Rabu';
                break;
            case 'Thu':
                $today = 'Kamis';
                break;
            case 'Fri':
                $today = 'Jumat';
                break;
            case 'Sat':
                $today = 'Sabtu';
                break;
            default:
                $today = 'Tidak diketahui';
                break;
        }

        return $today;
    }

    public function create() {
        $idStudent = Auth::user()->id;

        $days = $this->getDay();

        $checkIsPresence = DB::table('presences')
        ->where('presence_at', date('Y-m-d'))
        ->where('user_id', $idStudent)
        ->count();

        $workingHour = DB::table('config_working_hours')
        ->join('working_hours', 'config_working_hours.working_hour_id', '=','working_hours.id')
        ->where('user_id', $idStudent)
        ->where('day', $days)
        ->first();

        return view('presence.create', compact('checkIsPresence', 'workingHour'));
    }

    public function store(Request $request) {

        $idStudent = Auth::user()->id;

        $today = date('Y-m-d');
        $currentHour = date('H:i:s');

        $latitudeKantor = 0.5592349; 
        $longitudeKantor = 123.1351417;

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $distance = $this->distance($latitudeKantor, $longitudeKantor, $latitude, $longitude);
        $radius = round($distance["meters"]);

        $days = $this->getDay();

        $workingHour = DB::table('config_working_hours')
        ->join('working_hours', 'config_working_hours.kode_jam_kerja', '=','working_hours.kode_jam_kerja')
        ->where('user_id', $idStudent)
        ->where('day', $days)
        ->first();

        $checkIsPresence = DB::table('presences')
        ->where('presence_at', $today)
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
        $formatName = $idStudent . "-" . $today . '-' . $note;
        $fileName = $formatName . '.png';
        $file = $folderPath . $fileName;

        if($radius >= 40) {
            echo 'error|Anda berada diluar radius kantor, Jarak Anda ' . $radius . ' meter dari kantor';
        } else {
            if($checkIsPresence > 0) {
                if($currentHour < $workingHour->check_out) {
                    echo 'error|Maaf, belum waktunya melakukan presensi pulang';
                } else {
                    $dataCheckOut = [
                        'check_out' => $currentHour,
                        'photo_out' => $fileName,
                        'latitude' => $latitude,
                        'longitude' => $longitude
                    ];
                    $update = DB::table('presences')
                    ->where('presence_at', $today)
                    ->where('user_id', $idStudent)
                    ->update($dataCheckOut);
        
                    if ($update) {
                        echo 'success|Berhasil melakukan presensi pulang';
                        Storage::put($file, $decodeImage);
                    } else {
                        echo 'error|gagal melakukan presensi pulang, Silahkan hubungi admin';
                    }
                }
            } else {
                if($currentHour < $workingHour->start_check_in) {
                    echo 'error|Maaf, belum waktunya melakukan presensi';
                } else if($currentHour > $workingHour->end_check_in) {
                    echo 'error|Maaf, Batas waktu melakukan presensi sudah selesai';
                } else {
                    $dataCheckIn = [
                        'check_in' => $currentHour,
                        'photo_in' => $fileName,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'presence_at' => $today,
                        'user_id' => $idStudent,
                        'presence_status' => 'H',
                        'kode_jam_kerja' => ''

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
