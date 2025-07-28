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
        'loi_id',
        'dokumen_kontrak',
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'batas_akhir_kontrak' => 'date',
        'dokumen_kontrak' => 'array',
    ];

    public function lois()
    {
        return $this->hasMany(Loi::class);
    }

    public function loi()
    {
        return $this->belongsTo(Loi::class);
    }
} 