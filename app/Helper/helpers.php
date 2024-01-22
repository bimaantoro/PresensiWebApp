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