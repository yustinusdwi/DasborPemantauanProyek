<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loi extends Model
{
    protected $table = 'lois';
    protected $fillable = [
        'nomor_loi',
        'tanggal',
        'batas_akhir_loi',
        'no_po',
        'kontrak_id',
        'nama_proyek',
        'harga_total',
        'berkas_loi',
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'batas_akhir_loi' => 'date',
        'berkas_loi' => 'array',
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class);
    }

    public function kontraks()
    {
        return $this->hasMany(Kontrak::class);
    }
}
