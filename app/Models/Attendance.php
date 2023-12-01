<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_in',
        'check_out',
        'photo_in',
        'photo_out',
        'location_in',
        'location_out',
        'date_attend',
        'employee_id',
    ];

    public function employee() {
        return $this->belongsTo(User::class);
    }
}

