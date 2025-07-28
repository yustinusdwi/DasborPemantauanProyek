<?php

namespace App\Http\Controllers;
use App\Models\Spph;
use App\Models\Sph;
use App\Models\Nego;
use App\Models\Kontrak;
use App\Models\Loi;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Tampilkan halaman dashboard
    public function index()
    {
        $bapps = \App\Models\Bapp::orderBy('created_at', 'desc')->get();
        return view('admin', compact('bapps'));
    }

    // Simpan data SPPH
    public function storeSPPH(Request $request)
    {
        $request->validate([
            'nomor_spph' => 'required|string',
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
            'tanggal' => 'required|date',
            'batas_akhir_spph' => 'required|date',
            'uraian' => 'required|string',
            'dokumen_spph' => 'required|file|mimes:pdf|max:20480',
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
            'batas_akhir_sph' => $request->batas_akhir_spph,
            'uraian' => $request->uraian,
            'dokumen_spph' => $dokumenSpph ? json_encode($dokumenSpph) : json_encode([]),
            'dokumen_sow' => $dokumenSow ? json_encode($dokumenSow) : json_encode([]),
            'dokumen_lain' => !empty($dokumenLainArr) ? json_encode($dokumenLainArr) : json_encode([]),
        ]);
        // Tambahkan: generate notifikasi langsung
        app(\App\Http\Controllers\dashboardController::class)->generateNotifikasiSpph();
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
            'is_published' => false,
        ]);

        return back()->with('success', 'Data SPH berhasil disimpan.');
    }

    public function publishSph($id)
    {
        $sph = Sph::findOrFail($id);
        $sph->is_published = true;
        $sph->save();
        return response()->json(['success' => true]);
    }

    public function unpublishSph($id)
    {
        $sph = Sph::findOrFail($id);
        $sph->is_published = false;
        $sph->save();
        return response()->json(['success' => true]);
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
            'loi_id' => 'nullable|exists:lois,id',
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
            'loi_id' => $request->loi_id,
            'dokumen_kontrak' => $dokumenKontrak ? json_encode($dokumenKontrak) : json_encode([]),
        ]);
        // Tambahkan: generate notifikasi langsung
        app(\App\Http\Controllers\dashboardController::class)->generateNotifikasiKontrak();
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

    // Endpoint AJAX: daftar nama proyek dan uraian dari SPPH
    public function getSpphProjects()
    {
        $projects = \App\Models\Spph::select('nama_proyek', 'uraian', 'subkontraktor')
            ->whereNotNull('nama_proyek')
            ->where('nama_proyek', '!=', '')
            ->groupBy('nama_proyek', 'uraian', 'subkontraktor')
            ->orderBy('nama_proyek')
            ->get();
        return response()->json($projects);
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
        $kontraks = Kontrak::with('loi')->orderBy('created_at', 'desc')->get();
        return view('kontrak-table', compact('kontraks'));
    }

    public function kontrakEdit($id)
    {
        $kontrak = Kontrak::with('loi')->findOrFail($id);
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
            'loi_id' => 'nullable|exists:lois,id',
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
            'loi_id' => $request->loi_id,
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

    public function bappIndex()
    {
        $bapps = \App\Models\Bapp::orderBy('created_at', 'desc')->get();
        return view('bapp-table', compact('bapps'));
    }

    public function loiIndex()
    {
        $lois = \App\Models\Loi::with('kontrak')->orderBy('created_at', 'desc')->get();
        return view('loi-table', compact('lois'));
    }

    // ===== LOI CRUD =====
    public function storeLoi(Request $request)
    {
        $request->validate([
            'nomor_loi' => 'required|string',
            'tanggal' => 'required|date',
            'batas_akhir_loi' => 'required|date',
            'no_po' => 'nullable|string',
            'kontrak_id' => 'required|exists:kontraks,id',
            'nama_proyek' => 'required|string',
            'harga_total' => 'required|string',
            'berkas_loi' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // Simpan file jika di-upload
        $berkasLoi = null;
        if ($request->hasFile('berkas_loi')) {
            $file = $request->file('berkas_loi');
            $path = $file->store('dokumen/loi', 'public');
            $berkasLoi = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
        }

        // Simpan ke database
        Loi::create([
            'nomor_loi' => $request->nomor_loi,
            'tanggal' => $request->tanggal,
            'batas_akhir_loi' => $request->batas_akhir_loi,
            'no_po' => $request->no_po,
            'kontrak_id' => $request->kontrak_id,
            'nama_proyek' => $request->nama_proyek,
            'harga_total' => $request->harga_total,
            'berkas_loi' => $berkasLoi ? json_encode($berkasLoi) : null,
        ]);

        return back()->with('success', 'Data LoI berhasil disimpan.');
    }

    public function getKontrakData()
    {
        $kontraks = Kontrak::select('id', 'nomor_kontrak', 'nama_proyek', 'harga_total')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($kontraks);
    }

    public function getLoiData()
    {
        $lois = Loi::select('id', 'nomor_loi', 'nama_proyek')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($lois);
    }

    public function loiEdit($id)
    {
        $loi = Loi::with('kontrak')->findOrFail($id);
        return response()->json($loi);
    }

    public function loiUpdate(Request $request, $id)
    {
        $request->validate([
            'nomor_loi' => 'required|string',
            'tanggal' => 'required|date',
            'batas_akhir_loi' => 'required|date',
            'no_po' => 'nullable|string',
            'kontrak_id' => 'required|exists:kontraks,id',
            'nama_proyek' => 'required|string',
            'harga_total' => 'required|string',
            'berkas_loi' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $loi = Loi::findOrFail($id);
        
        // Update data dasar
        $loi->update([
            'nomor_loi' => $request->nomor_loi,
            'tanggal' => $request->tanggal,
            'batas_akhir_loi' => $request->batas_akhir_loi,
            'no_po' => $request->no_po,
            'kontrak_id' => $request->kontrak_id,
            'nama_proyek' => $request->nama_proyek,
            'harga_total' => $request->harga_total,
        ]);

        // Update file jika di-upload
        if ($request->hasFile('berkas_loi')) {
            $file = $request->file('berkas_loi');
            $path = $file->store('dokumen/loi', 'public');
            $berkasLoi = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ];
            $loi->berkas_loi = json_encode($berkasLoi);
            $loi->save();
        }

        return back()->with('success', 'Data LoI berhasil diperbarui.');
    }

    public function loiDestroy($id)
    {
        $loi = Loi::findOrFail($id);
        $loi->delete();
        
        return response()->json(['success' => true]);
    }
}
