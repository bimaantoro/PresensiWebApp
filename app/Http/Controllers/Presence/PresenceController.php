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
        $idEmployee = Auth::guard('employee')->user()->id;

        $days = $this->getDay();

        $checkIsPresence = DB::table('presences')
        ->where('presence_at', date('Y-m-d'))
        ->where('employee_id', $idEmployee)
        ->count();

        $workingHour = DB::table('config_working_hours')
        ->join('working_hours', 'config_working_hours.working_hour_id', '=','working_hours.id')
        ->where('employee_id', $idEmployee)
        ->where('day', $days)
        ->first();

        if($workingHour == null) {
            return view('presence.error-presence');
        } else  {
            return view('presence.create', compact('checkIsPresence', 'workingHour'));
        }
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
