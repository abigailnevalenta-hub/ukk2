<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'nisn',
        'pelapor',
        'kelas',
        'sarana',
        'lokasi',
        'detail',
        'foto',
        'tanggal',
        'status',
        'tanggapan'
    ];

    protected $table = 'pengaduans';
}
