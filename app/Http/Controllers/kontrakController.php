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
                    $decoded = json_decode($file, true);
                    if (is_array($decoded) && isset($decoded['path']) && isset($decoded['name'])) {
                        return $decoded;
                    }
                    return [
                        'path' => $file,
                        'name' => basename($file),
                    ];
                }
                return null;
            };
            $file_kontrak = null;
            if (is_array($kontrak->dokumen_kontrak) && isset($kontrak->dokumen_kontrak[0])) {
                $file_kontrak = $normalizeFile($kontrak->dokumen_kontrak[0]);
            } elseif (is_string($kontrak->dokumen_kontrak)) {
                $decoded = json_decode($kontrak->dokumen_kontrak, true);
                if (is_array($decoded) && isset($decoded[0])) {
                    $file_kontrak = $normalizeFile($decoded[0]);
                } elseif (!empty($kontrak->dokumen_kontrak)) {
                    $file_kontrak = $normalizeFile($kontrak->dokumen_kontrak);
                } else {
                    $file_kontrak = null;
                }
            }
            return [
                'no_kontrak' => $kontrak->nomor_kontrak,
                'subkontraktor' => $kontrak->subkontraktor,
                'tanggal' => $kontrak->tanggal,
                'batas_akhir' => $kontrak->batas_akhir_kontrak,
                'nama_proyek' => $kontrak->nama_proyek,
                'uraian' => $kontrak->uraian,
                'nilai_harga_total' => (int) $kontrak->harga_total,
                'file_kontrak' => $file_kontrak,
            ];
        })->toArray();
        return view('kontrak', compact('kontrakData'));
    }
}
