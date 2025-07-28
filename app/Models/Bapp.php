<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bapp extends Model
{
    protected $table = 'bapps';
    protected $fillable = [
        'nomor_bapp',
        'no_po',
        'tanggal_po',
        'tanggal_terima',
        'nama_proyek',
        'harga_total',
        'berkas_bapp',
        'tipe',
    ];
    protected $casts = [
        'berkas_bapp' => 'array',
    ];
} 