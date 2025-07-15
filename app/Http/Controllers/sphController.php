<?php

namespace App\Http\Controllers;

use App\Models\Sph;
use Illuminate\Http\Request;
use Illuminate\View\View;

class sphController extends Controller
{
    public function index(): View
    {
        $sphData = Sph::orderBy('created_at', 'desc')->get()->map(function($sph) {
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
                'tanggal' => $sph->tanggal,
                'nama_pekerjaan' => $sph->uraian,
                'harga_total' => $sph->harga_total,
                'file_sph' => $normalizeFile($sph->dokumen_sph),
            ];
        })->toArray();
        
        return view('sph', compact('sphData'));
    }
}
