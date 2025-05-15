<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'name',
        'file_path',
    ];

    public function job()
    {
        return $this->belongsTo(Pekerjaan::class, 'job_id');
    }
}
