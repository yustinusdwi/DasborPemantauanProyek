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
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
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
            'subkontraktor' => $request->subkontraktor ?? '',
            'nama_proyek' => $request->nama_proyek ?? '',
            'tanggal' => $request->tanggal,
            'batas_akhir_sph' => $request->batas_akhir_sph,
            'uraian' => $request->uraian,
            'dokumen_spph' => $dokumenSpph ? json_encode($dokumenSpph) : json_encode([]),
            'dokumen_sow' => $dokumenSow ? json_encode($dokumenSow) : json_encode([]),
            'dokumen_lain' => !empty($dokumenLainArr) ? json_encode($dokumenLainArr) : json_encode([]),
        ]);

        return back()->with('success', 'Data SPPH berhasil disimpan.');
    }

    // Simpan data SPH
    public function storeSPH(Request $request)
    {
        \Log::info('SPH Request Data:', $request->all());
        $request->validate([
            'nomor_sph' => 'required|string',
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
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
            'subkontraktor' => $request->subkontraktor ?? '',
            'nama_proyek' => $request->nama_proyek ?? '',
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
            'dokumen_sph' => $dokumenSph ? json_encode($dokumenSph) : json_encode([]),
        ]);

        return back()->with('success', 'Data SPH berhasil disimpan.');
    }

    // Simpan data NEGOSIASI
    public function storeNego(Request $request)
    {
        $request->validate([
            'nomor_nego' => 'required|string',
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
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
            'subkontraktor' => $request->subkontraktor ?? '',
            'nama_proyek' => $request->nama_proyek ?? '',
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
            'dokumen_nego' => $dokumenNego ? json_encode($dokumenNego) : json_encode([]),
        ]);

        return back()->with('success', 'Data Negosiasi berhasil disimpan.');
    }

    // Simpan data KONTRAK
    public function storeKontrak(Request $request)
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
        Kontrak::create([
            'nomor_kontrak' => $request->nomor_kontrak,
            'subkontraktor' => $request->subkontraktor ?? '',
            'nama_proyek' => $request->nama_proyek ?? '',
            'tanggal' => $request->tanggal,
            'batas_akhir_kontrak' => $request->batas_akhir_kontrak,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
            'dokumen_kontrak' => $dokumenKontrak ? json_encode($dokumenKontrak) : json_encode([]),
        ]);

        return back()->with('success', 'Data Kontrak berhasil disimpan.');
    }

    // ===== SPPH CRUD =====
    public function spphIndex()
    {
        $spphs = Spph::orderBy('created_at', 'desc')->get();
        return view('spph-table', compact('spphs'));
    }

    public function spphEdit($id)
    {
        $spph = Spph::findOrFail($id);
        return response()->json($spph);
    }

    public function spphUpdate(Request $request, $id)
    {
        $request->validate([
            'nomor_spph' => 'required|string',
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
            'tanggal' => 'required|date',
            'batas_akhir_sph' => 'required|date',
            'uraian' => 'required|string',
            'dokumen_spph' => 'nullable|file|mimes:pdf|max:2480',
            'dokumen_sow' => 'nullable|file|mimes:pdf|max:2480',
            'dokumen_lain.*' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $spph = Spph::findOrFail($id);
        
        // Update data dasar
        $spph->update([
            'nomor_spph' => $request->nomor_spph,
            'subkontraktor' => $request->subkontraktor,
            'nama_proyek' => $request->nama_proyek,
            'tanggal' => $request->tanggal,
            'batas_akhir_sph' => $request->batas_akhir_sph,
            'uraian' => $request->uraian,
        ]);

        // Update file jika di-upload
        if ($request->hasFile('dokumen_spph')) {
            $file = $request->file('dokumen_spph');
            $path = $file->store('dokumen/spph', 'public');
            $dokumenSpph = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
            $spph->dokumen_spph = json_encode($dokumenSpph);
        }

        if ($request->hasFile('dokumen_sow')) {
            $file = $request->file('dokumen_sow');
            $path = $file->store('dokumen/sow', 'public');
            $dokumenSow = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
            $spph->dokumen_sow = json_encode($dokumenSow);
        }

        if ($request->hasFile('dokumen_lain')) {
            $dokumenLainArr = [];
            foreach ($request->file('dokumen_lain') as $file) {
                $path = $file->store('dokumen/lain', 'public');
                $dokumenLainArr[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                ];
            }
            $spph->dokumen_lain = json_encode($dokumenLainArr);
        }

        $spph->save();

        return back()->with('success', 'Data SPPH berhasil diperbarui.');
    }

    public function spphDestroy($id)
    {
        $spph = Spph::findOrFail($id);
        $spph->delete();
        
        return response()->json(['success' => true]);
    }

    // ===== SPH CRUD =====
    public function sphIndex()
    {
        $sphs = Sph::orderBy('created_at', 'desc')->get();
        return view('sph-table', compact('sphs'));
    }

    public function sphEdit($id)
    {
        $sph = Sph::findOrFail($id);
        return response()->json($sph);
    }

    public function sphUpdate(Request $request, $id)
    {
        $request->validate([
            'nomor_sph' => 'required|string',
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'harga_total' => 'required|string',
            'dokumen_sph' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $sph = Sph::findOrFail($id);
        
        // Update data dasar
        $sph->update([
            'nomor_sph' => $request->nomor_sph,
            'subkontraktor' => $request->subkontraktor,
            'nama_proyek' => $request->nama_proyek,
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
        ]);

        // Update file jika di-upload
        if ($request->hasFile('dokumen_sph')) {
            $file = $request->file('dokumen_sph');
            $path = $file->store('dokumen/sph', 'public');
            $dokumenSph = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
            $sph->dokumen_sph = json_encode($dokumenSph);
            $sph->save();
        }

        return back()->with('success', 'Data SPH berhasil diperbarui.');
    }

    public function sphDestroy($id)
    {
        $sph = Sph::findOrFail($id);
        $sph->delete();
        
        return response()->json(['success' => true]);
    }

    // ===== NEGOSIASI CRUD =====
    public function negoIndex()
    {
        $negos = Nego::orderBy('created_at', 'desc')->get();
        return view('nego-table', compact('negos'));
    }

    public function negoEdit($id)
    {
        $nego = Nego::findOrFail($id);
        return response()->json($nego);
    }

    public function negoUpdate(Request $request, $id)
    {
        $request->validate([
            'nomor_nego' => 'required|string',
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'harga_total' => 'required|string',
            'dokumen_nego' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $nego = Nego::findOrFail($id);
        
        // Update data dasar
        $nego->update([
            'nomor_nego' => $request->nomor_nego,
            'subkontraktor' => $request->subkontraktor,
            'nama_proyek' => $request->nama_proyek,
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
        ]);

        // Update file jika di-upload
        if ($request->hasFile('dokumen_nego')) {
            $file = $request->file('dokumen_nego');
            $path = $file->store('dokumen/nego', 'public');
            $dokumenNego = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
            $nego->dokumen_nego = json_encode($dokumenNego);
            $nego->save();
        }

        return back()->with('success', 'Data Negosiasi berhasil diperbarui.');
    }

    public function negoDestroy($id)
    {
        $nego = Nego::findOrFail($id);
        $nego->delete();
        
        return response()->json(['success' => true]);
    }

    // ===== KONTRAK CRUD =====
    public function kontrakIndex()
    {
        $kontraks = Kontrak::orderBy('created_at', 'desc')->get();
        return view('kontrak-table', compact('kontraks'));
    }

    public function kontrakEdit($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        return response()->json($kontrak);
    }

    public function kontrakUpdate(Request $request, $id)
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

        $kontrak = Kontrak::findOrFail($id);
        
        // Update data dasar
        $kontrak->update([
            'nomor_kontrak' => $request->nomor_kontrak,
            'subkontraktor' => $request->subkontraktor,
            'nama_proyek' => $request->nama_proyek,
            'tanggal' => $request->tanggal,
            'batas_akhir_kontrak' => $request->batas_akhir_kontrak,
            'uraian' => $request->uraian,
            'harga_total' => $request->harga_total,
        ]);

        // Update file jika di-upload
        if ($request->hasFile('dokumen_kontrak')) {
            $file = $request->file('dokumen_kontrak');
            $path = $file->store('dokumen/kontrak', 'public');
            $dokumenKontrak = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
            $kontrak->dokumen_kontrak = json_encode($dokumenKontrak);
            $kontrak->save();
        }

        return back()->with('success', 'Data Kontrak berhasil diperbarui.');
    }

    public function kontrakDestroy($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        $kontrak->delete();
        
        return response()->json(['success' => true]);
    }
}
