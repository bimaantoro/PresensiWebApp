<?php
function kodeIzin($lastNumber, $key, $characterCount) {
    $initalNumber = intval(substr($lastNumber, strlen($key))) + 1;
    $newNumber = str_pad($initalNumber, $characterCount, "0", STR_PAD_LEFT);
    $result = $key .  $newNumber;
    return $result;
}

function calculateDay($startDate, $endDate) {
    $date1 = date_create($startDate);
    $date2 = date_create($endDate);
    $diff = date_diff($date1, $date2);
    return $diff->days + 1;
}

function dateToIndo($date) {
    $convertMonth = array(
        'Januari', 'Februari', 'Maret',
        'April', 'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November', 'Desember',
    );

    $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substr
    $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substr
    $tanggal = substr($date, 8, 2);

    $result = $tanggal . " " . $convertMonth[(int)$bulan - 1] . " " . $tahun;
    return ($result);
}

function calculateLateofCheckIn($checkIn, $presenceAt) {
    $j1 = strtotime($checkIn);
    $j2 = strtotime($presenceAt);

    $diffTerlambat = $j2 - $j1;

    $jamTerlambat = floor($diffTerlambat / (60 * 60));
    $menitTerlambat = floor(($diffTerlambat - ($jamTerlambat * (60 * 60))) / 60);

    $jTerlambat = $jamTerlambat <= 9 ? '0' . $jamTerlambat : $jamTerlambat;
    $mTerlambat = $menitTerlambat <= 9 ? '0' . $menitTerlambat : $menitTerlambat;

    $terlambat = $jTerlambat . ":" . $mTerlambat;
    return $terlambat;
}

function calculateLateofCheckInDecimal($checkIn, $presenceAt) {
    $j1 = strtotime($checkIn);
    $j2 = strtotime($presenceAt);

    $diffTerlambat = $j2 - $j1;

    $jamTerlambat = floor($diffTerlambat / (60 * 60));
    $menitTerlambat = floor(($diffTerlambat - ($jamTerlambat * (60 * 60))) / 60);

    $terlambat = ROUND(($menitTerlambat / 60), 2);
    return $terlambat;
}
