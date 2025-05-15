<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kontak'
    ];

    public function pekerjaan()
    {
        return $this->hasMany(Pekerjaan::class);
    }
}
