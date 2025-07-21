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

    protected static function boot()
    {
        parent::boot();
        static::created(function ($kontrak) {
            $now = now();
            $batasAkhir = \Carbon\Carbon::parse($kontrak->batas_akhir_kontrak);
            $daysDiff = $now->diffInDays($batasAkhir, false);
            $reminderDays = [7,3,2,1,0];
            if (in_array($daysDiff, $reminderDays)) {
                $msg = $daysDiff === 0 ? 'Hari ini adalah batas akhir proyek "'.$kontrak->nama_proyek.'"!' : 'Batas akhir proyek "'.$kontrak->nama_proyek.'" tinggal '.$daysDiff.' hari lagi!';
                $exists = \App\Models\Notification::where('kontrak_id', $kontrak->id)
                    ->where('batas_akhir', $batasAkhir)
                    ->where('message', $msg)
                    ->exists();
                if (!$exists) {
                    \App\Models\Notification::create([
                        'kontrak_id' => $kontrak->id,
                        'nama_proyek' => $kontrak->nama_proyek,
                        'batas_akhir' => $batasAkhir,
                        'message' => $msg,
                        'is_read' => false,
                    ]);
                }
            }
        });
    }
} 