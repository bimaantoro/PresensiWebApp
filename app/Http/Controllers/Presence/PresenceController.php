<?php

namespace App\Http\Controllers\Presence;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresenceController extends Controller
{
    //
    public function getDay() {
        $day = (new DateTime())->format('N');

        switch($day) {
            case 1:
                $today = 'Senin';
                break;
            case 2: 
                $today = 'Selasa';
                break;
            case 3:
                $today = 'Rabu';
                break;
            case 4:
                $today = 'Kamis';
                break;               
            case 5:
                $today = 'Jumat';
                break;
            case 6:
                $today = 'Sabtu';
                break;
            case 7:
                $today = 'Minggu';
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

        if($workingHour == null) {
            return view('presence.error-presence');
        } else  {
            return view('presence.create', compact('checkIsPresence', 'workingHour'));
        }
    }

    public function store(Request $request) {
        $idStudent = Auth::user()->id;
        $today = date('Y-m-d');
        $currentHour = date('H:i:s');
        $latitudeKantor = 1.4778368; 
        $longitudeKantor = 124.8493568;
        $image = $request->image;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $distance = $this->distance($latitudeKantor, $longitudeKantor, $latitude, $longitude);
        $radius = round($distance["meters"]);

        if($radius >= 500) {
            return response()->json(['error' => 'Anda berada diluar radius kantor, Jarak Anda ' . $radius . ' meter dari kantor']);
        }

        $days = $this->getDay();
        $workingHour = DB::table('config_working_hours')
        ->join('working_hours', 'config_working_hours.working_hour_id', '=','working_hours.id')
        ->where('user_id', $idStudent)
        ->where('day', $days)
        ->first();

        // check presence status
        $presence = DB::table('presences')
        ->where('presence_at', $today)
        ->where('user_id', $idStudent);

        $checkIsPresence = $presence->count();
        $dataPresence = $presence->first();

        $note = ($checkIsPresence > 0) ? 'out' : 'in'; 

        $folderPath = 'public/uploads/presence/';
        $imageParts = explode(';base64', $image);
        $decodeImage = base64_decode($imageParts[1]);
        $formatName = $idStudent . "-" . $today . '-' . $note;
        $fileName = $formatName . '.png';
        $file = $folderPath . $fileName;

        // check if it's time to check out or check in
        if($checkIsPresence > 0) {
            if($currentHour < $workingHour->jam_out) {
                return response()->json(['error' => 'Maaf, belum waktunya melakukan presensi pulang']);
            }else if(!empty($dataPresence->check_out)) {
                return response()->json(['error' => 'Anda sudah melakukan presensi pulang']);
            }
            $dataCheckOut = [
                'check_out' => $currentHour,
                'photo_out' => $fileName,
                'latitude' => $latitude,
                'longitude' => $longitude
            ];
            $message = 'Berhasil melakukan presensi pulang';
        } else {
            if($currentHour < $workingHour->start_check_in) {
                return response()->json(['error' => 'Maaf, belum waktunya melakukan presensi']);
            } else if($currentHour > $workingHour->end_check_in) {
                return response()->json(['error' => 'Maaf, Batas waktu melakukan presensi sudah selesai']);
            }
            $dataCheckIn = [
                'check_in' => $currentHour,
                'photo_in' => $fileName,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'presence_at' => $today,
                'user_id' => $idStudent,
                'presence_status' => 'H',
                'working_hour_id' => $workingHour->working_hour_id,
            ];
            $message = 'Berhasil melakukan presensi masuk';
        }

        $saveOrUpdate = ($checkIsPresence > 0) ?
        DB::table('presences')
        ->where('presence_at', $today)
        ->where('user_id', $idStudent)
        ->update($dataCheckOut) : DB::table('presences')->insert($dataCheckIn);

        if($saveOrUpdate) {
            Storage::put($file, $decodeImage);
            return response()->json(['message' => $message]);
        } else {
            return response()->json(['error' => 'Gagal melakukan presensi, Silahkan hubungi admin']);
        }
    }

    // Menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2) {
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

    /* public function getDay() {
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
    } */

    /* public function store(Request $request) {

        $idStudent = Auth::user()->id;

        $today = date('Y-m-d');
        $currentHour = date('H:i:s');

        $latitudeKantor = 0.5591529; 
        $longitudeKantor = 123.062273;

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $distance = $this->distance($latitudeKantor, $longitudeKantor, $latitude, $longitude);
        $radius = round($distance["meters"]);

        $days = $this->getDay();

        $workingHour = DB::table('config_working_hours')
        ->join('working_hours', 'config_working_hours.working_hour_id', '=','working_hours.id')
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
                if($currentHour < $workingHour->jam_out) {
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
                        'working_hour_id' => $workingHour->working_hour_id,
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
    } */
}
