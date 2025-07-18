<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nego extends Model
{
    protected $table = 'negos';
    protected $fillable = [
        'subkontraktor',
        'nama_proyek',
        'uraian',
    ];
    public function details()
    {
        return $this->hasMany(NegoDetail::class, 'nego_id');
    }
} 