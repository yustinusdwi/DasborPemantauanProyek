<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sph extends Model
{
    protected $table = 'sphs';
    
    protected $fillable = [
        'nomor_sph',
        'subkontraktor',
        'nama_proyek',
        'tanggal',
        'uraian',
        'harga_total',
        'dokumen_sph',
    ];

    protected $casts = [
        'dokumen_sph' => 'array',
    ];
}
