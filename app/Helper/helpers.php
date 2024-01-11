<?php
function kodeIzin($lastNumber, $key, $characterCount) {
    $initalNumber = intval(substr($lastNumber, strlen($key))) + 1;
    $newNumber = str_pad($initalNumber, $characterCount, "0", STR_PAD_LEFT);
    $result = $key .  $newNumber;
    return $result;
}