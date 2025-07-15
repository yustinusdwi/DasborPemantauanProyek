<?php

namespace App\Http\Controllers;

use App\Models\Spph;
use Illuminate\Http\Request;
use Illuminate\View\View;

class spphController extends Controller
{
    public function index(): View
    {
        $spphData = Spph::orderBy('created_at', 'desc')->get()->map(function($spph) {
            // Helper untuk normalisasi file
            $normalizeFile = function($file) {
                if (is_array($file) && isset($file['path']) && isset($file['name'])) {
                    return $file;
                } elseif (is_string($file)) {
                    // Coba decode JSON jika string
                    $decoded = json_decode($file, true);
                    if (is_array($decoded) && isset($decoded['path']) && isset($decoded['name'])) {
                        return $decoded;
                    }
                    // Jika bukan JSON, anggap sebagai path file
                    return [
                        'path' => $file,
                        'name' => basename($file),
                    ];
                }
                return null;
            };
            
            $dokumen_lain = [];
            if (is_array($spph->dokumen_lain)) {
                foreach ($spph->dokumen_lain as $file) {
                    $f = $normalizeFile($file);
                    if ($f) $dokumen_lain[] = $f;
                }
            } elseif (is_string($spph->dokumen_lain)) {
                // Coba decode JSON untuk dokumen_lain
                $decoded = json_decode($spph->dokumen_lain, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $file) {
                        $f = $normalizeFile($file);
                        if ($f) $dokumen_lain[] = $f;
                    }
                }
            }
            
            return [
                'no_spph' => $spph->nomor_spph,
                'tanggal' => $spph->tanggal,
                'batas_akhir' => $spph->batas_akhir_sph,
                'nama_pekerjaan' => $spph->uraian,
                'file_spph' => $normalizeFile($spph->dokumen_spph),
                'file_sow' => $normalizeFile($spph->dokumen_sow),
                'file_lain' => $dokumen_lain,
            ];
        })->toArray();
        
        return view('spph', compact('spphData'));
    }
}
