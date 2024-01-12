<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_izin';
    
    protected $fillable = [
        'izin_at',
        'status',
        'keterangan',
        'status_approved',
        'employee_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
