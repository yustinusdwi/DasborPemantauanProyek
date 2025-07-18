<?php

namespace App\Http\Controllers;

use App\Models\Nego;
use App\Models\NegoDetail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class negoController extends Controller
{
    // Tampilkan tabel utama
    public function index(): View
    {
        $negoData = Nego::orderBy('created_at', 'desc')->get()->map(function($nego) {
            return [
                'id' => $nego->id,
                'subkontraktor' => $nego->subkontraktor,
                'nama_proyek' => $nego->nama_proyek,
                'uraian' => $nego->uraian,
            ];
        })->toArray();
        return view('nego', compact('negoData'));
    }

    // Ambil detail berdasarkan proyek
    public function getByProject(Request $request)
    {
        $negoId = $request->query('nego_id');
        $namaProyek = $request->query('nama_proyek');
        $nego = null;
        if ($negoId) {
            $nego = Nego::find($negoId);
        } elseif ($namaProyek) {
            $nego = Nego::where('nama_proyek', $namaProyek)->first();
        }
        $data = [];
        if ($nego) {
            $data = $nego->details()->orderBy('created_at', 'desc')->get()->map(function($detail) {
                $arr = $detail->toArray();
                // Pastikan dokumen_nego array
                if (is_string($arr['dokumen_nego'])) {
                    $arr['dokumen_nego'] = json_decode($arr['dokumen_nego'], true);
                }
                return $arr;
            });
        }
        return response()->json(['data' => $data]);
    }

    // Ambil detail berdasarkan id detail
    public function getById(Request $request)
    {
        $id = $request->query('id');
        $data = NegoDetail::where('id', $id)->get();
        return response()->json(['data' => $data]);
    }

    // Simpan data utama
    public function storeMain(Request $request)
    {
        $data = $request->validate([
            'subkontraktor' => 'required|string',
            'nama_proyek' => 'required|string',
            'uraian' => 'required|string',
        ]);
        $nego = Nego::create($data);
        return back()->with('success', 'Data Negosiasi berhasil disimpan.');
    }

    // Simpan detail (masuk/keluar/hasil)
    public function storeDetail(Request $request)
    {
        try {
            $data = $request->validate([
                'nego_id' => 'required|exists:negos,id',
                'tipe' => 'required|in:masuk,keluar,hasil',
                'nomor_nego' => 'required|string',
                'subkontraktor' => 'required|string',
                'tanggal' => 'required|date',
                'harga_total' => 'required|string',
                'dokumen_nego' => 'nullable|file|mimes:pdf|max:20480',
            ]);
            $dokumen = null;
            if ($request->hasFile('dokumen_nego')) {
                $file = $request->file('dokumen_nego');
                $path = $file->store('dokumen_nego', 'public');
                $dokumen = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                ];
            }
            $detail = NegoDetail::create([
                'nego_id' => $request->nego_id,
                'tipe' => $request->tipe,
                'nomor_nego' => $request->nomor_nego,
                'subkontraktor' => $request->subkontraktor,
                'tanggal' => $request->tanggal,
                'harga_total' => $request->harga_total,
                'dokumen_nego' => $dokumen ? json_encode($dokumen) : null,
            ]);
            return response()->json(['success' => true, 'data' => $detail]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    // Update detail
    public function updateDetail(Request $request, $id)
    {
        $detail = NegoDetail::findOrFail($id);
        $data = $request->validate([
            'tipe' => 'required|in:masuk,keluar,hasil',
            'nomor_nego' => 'required|string',
            'subkontraktor' => 'required|string',
            'tanggal' => 'required|date',
            'harga_total' => 'required|string',
            'dokumen_nego' => 'nullable|file|mimes:pdf|max:20480',
        ]);
        if ($request->hasFile('dokumen_nego')) {
            $file = $request->file('dokumen_nego');
            $path = $file->store('dokumen_nego', 'public');
            $data['dokumen_nego'] = json_encode([
                'path' => $path,
                'name' => $file->getClientOriginalName(),
            ]);
        }
        $detail->update($data);
        return response()->json(['success' => true, 'data' => $detail]);
    }

    // Hapus detail
    public function destroyDetail($id)
    {
        $detail = NegoDetail::findOrFail($id);
        $detail->delete();
        return response()->json(['success' => true]);
    }
}
