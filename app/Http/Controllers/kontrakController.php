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
        $kontrakData = Kontrak::with('loi')->orderBy('created_at', 'desc')->get()->map(function($kontrak) {
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
            
            // Debug: Log raw dokumen_kontrak
            \Log::info('Raw dokumen_kontrak for kontrak ' . $kontrak->id . ':', [
                'dokumen_kontrak' => $kontrak->dokumen_kontrak,
                'type' => gettype($kontrak->dokumen_kontrak)
            ]);
            
            $file_kontrak = $normalizeFile($kontrak->dokumen_kontrak);
            
            // Debug: Log normalized file
            \Log::info('Normalized file_kontrak for kontrak ' . $kontrak->id . ':', [
                'file_kontrak' => $file_kontrak
            ]);
            
            // Info LoI
            $loi_info = null;
            if ($kontrak->loi) {
                $loi_info = [
                    'nomor_loi' => $kontrak->loi->nomor_loi,
                    'nama_proyek' => $kontrak->loi->nama_proyek,
                ];
            }
            
            $result = [
                'no_kontrak' => $kontrak->nomor_kontrak,
                'subkontraktor' => $kontrak->subkontraktor,
                'tanggal' => $kontrak->tanggal,
                'batas_akhir' => $kontrak->batas_akhir_kontrak,
                'nama_proyek' => $kontrak->nama_proyek,
                'uraian' => $kontrak->uraian,
                'nilai_harga_total' => (int) $kontrak->harga_total,
                'file_kontrak' => $file_kontrak,
                'loi_info' => $loi_info,
            ];
            
            // Debug: Log final result
            \Log::info('Final result for kontrak ' . $kontrak->id . ':', [
                'file_kontrak' => $result['file_kontrak'],
                'asset_url' => $file_kontrak ? asset('storage/' . $file_kontrak['path']) : null
            ]);
            
            return $result;
        })->toArray();
        
        // Debug: Log all kontrak data
        \Log::info('All kontrak data:', [
            'count' => count($kontrakData),
            'data' => $kontrakData
        ]);
        
        return view('kontrak', compact('kontrakData'));
    }

    public function testPdfAccess()
    {
        $kontrak = Kontrak::first();
        if (!$kontrak) {
            return response()->json(['error' => 'No kontrak found']);
        }
        
        $dokumen_kontrak = $kontrak->dokumen_kontrak;
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
        
        $file_kontrak = $normalizeFile($dokumen_kontrak);
        $asset_url = $file_kontrak ? asset('storage/' . $file_kontrak['path']) : null;
        $file_exists = $file_kontrak ? file_exists(storage_path('app/public/' . $file_kontrak['path'])) : false;
        
        return response()->json([
            'kontrak_id' => $kontrak->id,
            'raw_dokumen_kontrak' => $dokumen_kontrak,
            'normalized_file_kontrak' => $file_kontrak,
            'asset_url' => $asset_url,
            'file_exists' => $file_exists,
            'storage_path' => $file_kontrak ? storage_path('app/public/' . $file_kontrak['path']) : null
        ]);
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
