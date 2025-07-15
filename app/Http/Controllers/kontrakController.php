<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use Illuminate\Http\Request;
use Illuminate\View\View;

class kontrakController extends Controller
{
    public function index(): View
    {
        $kontrakData = Kontrak::orderBy('created_at', 'desc')->get()->map(function($kontrak) {
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
            $file_kontrak = [];
            if (is_array($kontrak->dokumen_kontrak)) {
                foreach ($kontrak->dokumen_kontrak as $file) {
                    $f = $normalizeFile($file);
                    if ($f) $file_kontrak[] = $f;
                }
            } elseif (is_string($kontrak->dokumen_kontrak)) {
                // Coba decode JSON untuk dokumen_kontrak
                $decoded = json_decode($kontrak->dokumen_kontrak, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $file) {
                        $f = $normalizeFile($file);
                        if ($f) $file_kontrak[] = $f;
                    }
                } else {
                    $f = $normalizeFile($kontrak->dokumen_kontrak);
                    if ($f) $file_kontrak[] = $f;
                }
            }
            return [
                'no_kontrak' => $kontrak->nomor_kontrak,
                'tanggal' => $kontrak->tanggal,
                'batas_akhir' => $kontrak->batas_akhir_kontrak,
                'uraian' => $kontrak->uraian,
                'nilai_harga_total' => (int) $kontrak->harga_total,
                'file_kontrak' => $file_kontrak,
            ];
        })->toArray();
        return view('kontrak', compact('kontrakData'));
    }
}
