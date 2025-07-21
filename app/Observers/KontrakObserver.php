<?php

namespace App\Observers;

use App\Models\Kontrak;
use App\Models\Notification;
use Carbon\Carbon;

class KontrakObserver
{
    public function created(Kontrak $kontrak)
    {
        $now = now();
        $batasAkhir = Carbon::parse($kontrak->batas_akhir_kontrak);
        $daysDiff = $now->diffInDays($batasAkhir, false);
        $reminderDays = [7,3,2,1,0];
        if (in_array($daysDiff, $reminderDays)) {
            $msg = $daysDiff === 0 ? 'Hari ini adalah batas akhir proyek "'.$kontrak->nama_proyek.'"!' : 'Batas akhir proyek "'.$kontrak->nama_proyek.'" tinggal '.$daysDiff.' hari lagi!';
            $exists = Notification::where('kontrak_id', $kontrak->id)
                ->where('batas_akhir', $batasAkhir)
                ->where('message', $msg)
                ->exists();
            if (!$exists) {
                Notification::create([
                    'kontrak_id' => $kontrak->id,
                    'nama_proyek' => $kontrak->nama_proyek,
                    'batas_akhir' => $batasAkhir,
                    'message' => $msg,
                    'is_read' => false,
                ]);
            }
        }
    }
} 