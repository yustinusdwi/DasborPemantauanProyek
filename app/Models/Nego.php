<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nego extends Model
{
    protected $table = 'negos';
    
    protected $fillable = [
        'nomor_nego',
        'tanggal',
        'uraian',
        'harga_total',
        'dokumen_nego',
    ];

    protected $casts = [
        'dokumen_nego' => 'array',
    ];
} 