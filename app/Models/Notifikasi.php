<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'job_id',
        'user_id',
        'message'
    ];

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
