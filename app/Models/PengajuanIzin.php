<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_izin';
    protected $primaryKey = 'id';
    public $incrementing = false;
    
    protected $fillable = [
        'start_date',
        'end_date',
        'keterangan',
        'file_surat_dokter',
        'status',
        'status_code',
        'employee_id'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
