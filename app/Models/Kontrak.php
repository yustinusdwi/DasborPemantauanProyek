<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    protected $table = 'kontraks';
    
    protected $fillable = [
        'nomor_kontrak',
        'subkontraktor',
        'nama_proyek',
        'tanggal',
        'batas_akhir_kontrak',
        'uraian',
        'harga_total',
        'dokumen_kontrak',
    ];

    protected $casts = [
        'dokumen_kontrak' => 'array',
    ];
} 