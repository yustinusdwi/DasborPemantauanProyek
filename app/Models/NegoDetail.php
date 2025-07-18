<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NegoDetail extends Model
{
    protected $table = 'nego_details';
    protected $fillable = [
        'nego_id',
        'tipe',
        'nomor_nego',
        'subkontraktor',
        'tanggal',
        'harga_total',
        'dokumen_nego',
    ];
    protected $casts = [
        'dokumen_nego' => 'array',
    ];
    public function nego()
    {
        return $this->belongsTo(Nego::class, 'nego_id');
    }
} 