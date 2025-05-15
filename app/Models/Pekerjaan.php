<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pekerjaan extends Model
{
    //
    use HasFactory;

    protected $table = 'pekerjaan';

    protected $fillable = [
        'nama',
        'kode_pekerjaan',
        'deskripsi',
        'no_kontrak',
        'kategori',
        'client_id',
        'status',
        'total',
        'deadline',
        'tanggal_tagihan',
        'ditangani'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'deadline' => 'date',
        'tanggal_tagihan' => 'date'
    ];

    public function ditanganiUser()
    {
        return $this->belongsTo(User::class, 'ditangani');
    }

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatusPekerjaan::class, 'job_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'job_id');
    }

}
