<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_in',
        'check_out',
        'photo_in',
        'photo_out',
        'latitude',
        'longitude',
        'presence_at',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
