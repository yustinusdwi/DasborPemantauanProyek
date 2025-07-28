<?php

namespace App\Http\Controllers;

use App\Models\Sph;
use Illuminate\Http\Request;
use Illuminate\View\View;

class sphController extends Controller
{
    public function index(): View
    {
        $sphData = Sph::where('is_published', true)
            ->orderBy('created_at', 'desc')->get()->map(function($sph) {
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
            
            return [
                'no_sph' => $sph->nomor_sph,
                'subkontraktor' => $sph->subkontraktor,
                'tanggal' => $sph->tanggal,
                'nama_proyek' => $sph->nama_proyek,
                'uraian' => $sph->uraian,
                'harga_total' => $sph->harga_total,
                'file_sph' => $normalizeFile($sph->dokumen_sph),
            ];
        })->toArray();
        
        return view('sph', compact('sphData'));
    }
}
