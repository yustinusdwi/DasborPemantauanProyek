<?php

namespace App\Http\Controllers;
use App\Models\Spph;
use App\Models\Sph;
use App\Models\Nego;
use App\Models\Kontrak;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Tampilkan halaman dashboard
    public function index()
    {
        return view('admin');
    }

    // Simpan data SPPH
    public function storeSPPH(Request $request)
    {
        $request->validate([
            'nomor_spph' => 'required|string',
            'tanggal' => 'required|date',
            'batas_akhir_sph' => 'required|date',
            'uraian' => 'required|string',
            'dokumen_spph' => 'nullable|file|mimes:pdf|max:20480',
            'dokumen_sow' => 'nullable|file|mimes:pdf|max:20480',
            'dokumen_lain.*' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // Simpan file jika di-upload
        $dokumenSpph = null;
        $dokumenSow = null;
        $dokumenLainArr = [];

        if ($request->hasFile('dokumen_spph')) {
            $file = $request->file('dokumen_spph');
            $path = $file->store('dokumen/spph', 'public');
            $dokumenSpph = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
        }

        if ($request->hasFile('dokumen_sow')) {
            $file = $request->file('dokumen_sow');
            $path = $file->store('dokumen/sow', 'public');
            $dokumenSow = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
        }

        if ($request->hasFile('dokumen_lain')) {
            foreach ($request->file('dokumen_lain') as $file) {
                $path = $file->store('dokumen/lain', 'public');
                $dokumenLainArr[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        // Simpan ke database
        Spph::create([
            'nomor_spph' => $request->nomor_spph,
            'tanggal' => $request->tanggal,
            'batas_akhir_sph' => $request->batas_akhir_sph,
            'uraian' => $request->uraian,
            'dokumen_spph' => $dokumenSpph,
            'dokumen_sow' => $dokumenSow,
            'dokumen_lain' => $dokumenLainArr,
        ]);

        return back()->with('success', 'Data SPPH berhasil disimpan.');
    }

    // Simpan data SPH
    public function storeSPH(Request $request)
    {
        \Log::info('SPH Request Data:', $request->all());
        $request->validate([
            'nomor_sph' => 'required|string',
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'harga_total' => 'required|string',
            'dokumen_sph' => 'nullable|file|mimes:pdf|max:20480',
        ]);
        // Simpan file jika di-upload
        $dokumenSph = null;
        if ($request->hasFile('dokumen_sph')) {
            $file = $request->file('dokumen_sph');
            $path = $file->store('dokumen/sph', 'public');
            $dokumenSph = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
        }

        // Simpan ke database
        Sph::create([
            'nomor_sph' => $request->nomor_sph,
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
            'dokumen_sph' => $dokumenSph,
        ]);

        return back()->with('success', 'Data SPH berhasil disimpan.');
    }

    // Simpan data NEGOSIASI
    public function storeNego(Request $request)
    {
        $request->validate([
            'nomor_nego' => 'required|string',
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'harga_total' => 'required|string',
            'dokumen_nego' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // Simpan file jika di-upload
        $dokumenNego = null;
        if ($request->hasFile('dokumen_nego')) {
            $file = $request->file('dokumen_nego');
            $path = $file->store('dokumen/nego', 'public');
            $dokumenNego = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
        }

        // Simpan ke database
        Nego::create([
            'nomor_nego' => $request->nomor_nego,
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
            'dokumen_nego' => $dokumenNego,
        ]);

        return back()->with('success', 'Data Negosiasi berhasil disimpan.');
    }

    // Simpan data KONTRAK
    public function storeKontrak(Request $request)
    {
        $request->validate([
            'nomor_kontrak' => 'required|string',
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
        Kontrak::create([
            'nomor_kontrak' => $request->nomor_kontrak,
            'tanggal' => $request->tanggal,
            'batas_akhir_kontrak' => $request->batas_akhir_kontrak,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
            'dokumen_kontrak' => $dokumenKontrak,
        ]);

        return back()->with('success', 'Data Kontrak berhasil disimpan.');
    }
}
