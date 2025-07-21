<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Notification;

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

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kontrak' => 'required|string',
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
            'tanggal' => 'required|date',
            'batas_akhir_kontrak' => 'required|date',
            'uraian' => 'required|string',
            'harga_total' => 'required|string',
            'dokumen_kontrak' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // Simpan file jika di-upload
        $dokumenKontrak = null;
        if ($request->hasFile('dokumen_kontrak')) {
            $file = $request->file('dokumen_kontrak');
            $path = $file->store('dokumen/kontrak', 'public');
            $dokumenKontrak = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
        }

        // Simpan ke database
        $kontrak = Kontrak::create([
            'nomor_kontrak' => $request->nomor_kontrak,
            'subkontraktor' => $request->subkontraktor ?? '',
            'nama_proyek' => $request->nama_proyek ?? '',
            'tanggal' => $request->tanggal,
            'batas_akhir_kontrak' => $request->batas_akhir_kontrak,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
            'dokumen_kontrak' => $dokumenKontrak ? json_encode($dokumenKontrak) : json_encode([]),
        ]);

        // Buat notifikasi jika batas akhir kontrak dalam 7,3,2,1,0 hari ke depan
        $now = now();
        $batasAkhir = \Carbon\Carbon::parse($kontrak->batas_akhir_kontrak);
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

        return back()->with('success', 'Data Kontrak berhasil disimpan.');
    }
}
