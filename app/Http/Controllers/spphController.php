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
            // Pastikan dokumen_spph dan dokumen_sow selalu array
            $dokumen_spph = $spph->dokumen_spph;
            if (is_string($dokumen_spph)) {
                $dokumen_spph = json_decode($dokumen_spph, true);
            }
            $dokumen_sow = $spph->dokumen_sow;
            if (is_string($dokumen_sow)) {
                $dokumen_sow = json_decode($dokumen_sow, true);
            }
            $dokumen_lain = [];
            if (is_array($spph->dokumen_lain)) {
                foreach ($spph->dokumen_lain as $file) {
                    $f = $normalizeFile($file);
                    if ($f) $dokumen_lain[] = $f;
                }
            } elseif (is_string($spph->dokumen_lain)) {
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
                'subkontraktor' => $spph->subkontraktor ?? '',
                'tanggal' => $spph->tanggal,
                'batas_akhir' => $spph->batas_akhir_sph,
                'nama_proyek' => $spph->nama_proyek ?? '',
                'uraian' => $spph->uraian,
                'file_spph' => $normalizeFile($dokumen_spph),
                'file_sow' => $normalizeFile($dokumen_sow),
                'file_lain' => $dokumen_lain,
            ];
        })->toArray();
        
        return view('spph', compact('spphData'));
    }
}
