<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'kontrak_id',
        'nama_proyek',
        'batas_akhir',
        'message',
        'is_read',
    ];
    protected $casts = [
        'is_read' => 'boolean',
        'batas_akhir' => 'datetime',
    ];
} 