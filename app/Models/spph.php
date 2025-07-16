<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spph extends Model
{
    protected $table = 'spphs';
    
    protected $fillable = [
        'nomor_spph',
        'subkontraktor',
        'nama_proyek',
        'tanggal',
        'batas_akhir_sph',
        'uraian',
        'dokumen_spph',
        'dokumen_sow',
        'dokumen_lain',
    ];

    protected $casts = [
        'dokumen_spph' => 'array',
        'dokumen_sow' => 'array',
        'dokumen_lain' => 'array',
    ];
}
