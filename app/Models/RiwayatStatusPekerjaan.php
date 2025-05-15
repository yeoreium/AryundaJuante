<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatStatusPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status_pekerjaan';

    protected $fillable = [
        'job_id',
        'status',
        'updated_by'
    ];

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'job_id');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
