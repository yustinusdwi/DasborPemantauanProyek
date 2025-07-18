<?php

namespace App\Http\Controllers;

use App\Models\Bapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BappController extends Controller
{
    // Tabel admin
    public function indexAdmin()
    {
        $bapps = Bapp::orderBy('created_at', 'desc')->get();
        return view('bapp-table', compact('bapps'));
    }
    // Tabel user
    public function index()
    {
        $bapps = Bapp::orderBy('created_at', 'desc')->get();
        return view('bapp', compact('bapps'));
    }
    // Store
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nomor_bapp' => 'required|string',
                'no_po' => 'required|string',
                'tanggal_po' => 'required|date',
                'tanggal_terima' => 'required|date',
                'nama_proyek' => 'required|string',
                'berkas_bapp' => 'nullable|file|mimes:pdf|max:20480',
            ]);
            $berkas = null;
            if ($request->hasFile('berkas_bapp')) {
                $file = $request->file('berkas_bapp');
                $path = $file->store('dokumen_bapp', 'public');
                $berkas = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                ];
            }
            Bapp::create([
                'nomor_bapp' => $data['nomor_bapp'],
                'no_po' => $data['no_po'],
                'tanggal_po' => $data['tanggal_po'],
                'tanggal_terima' => $data['tanggal_terima'],
                'nama_proyek' => $data['nama_proyek'],
                'berkas_bapp' => $berkas ? json_encode($berkas) : null,
            ]);
            return redirect()->back()->with('success', 'Data BAPP berhasil disimpan.')->withFragment('bapp');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Gagal menyimpan data BAPP: ' . $e->getMessage()])->withInput()->withFragment('bapp');
        }
    }
    // Update
    public function update(Request $request, $id)
    {
        $bapp = Bapp::findOrFail($id);
        $data = $request->validate([
            'nomor_bapp' => 'required|string',
            'no_po' => 'required|string',
            'tanggal_po' => 'required|date',
            'tanggal_terima' => 'required|date',
            'nama_proyek' => 'required|string',
            'berkas_bapp' => 'nullable|file|mimes:pdf|max:20480',
        ]);
        if ($request->hasFile('berkas_bapp')) {
            $file = $request->file('berkas_bapp');
            $path = $file->store('dokumen_bapp', 'public');
            $data['berkas_bapp'] = json_encode([
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ]);
        }
        $bapp->update($data);
        return response()->json(['success' => true, 'data' => $bapp]);
    }
    // Destroy
    public function destroy($id)
    {
        $bapp = Bapp::findOrFail($id);
        $bapp->delete();
        return response()->json(['success' => true]);
    }
} 