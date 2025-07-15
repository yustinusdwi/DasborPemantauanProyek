<?php

namespace App\Http\Controllers;

use App\Models\Nego;
use Illuminate\Http\Request;
use Illuminate\View\View;

class negoController extends Controller
{
    public function index(): View
    {
        $negoData = Nego::orderBy('created_at', 'desc')->get()->map(function($nego) {
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
                'no_nego' => $nego->nomor_nego,
                'tanggal' => $nego->tanggal,
                'deskripsi_pekerjaan' => $nego->uraian,
                'harga_total' => $nego->harga_total,
                'file_nego' => $normalizeFile($nego->dokumen_nego),
            ];
        })->toArray();
        return view('nego', compact('negoData'));
    }
}
