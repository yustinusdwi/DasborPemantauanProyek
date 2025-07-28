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
        if (request()->ajax()) {
            // Pastikan berkas_bapp sudah didecode ke array
            $bapps = $bapps->map(function($bapp) {
                $bappArr = $bapp->toArray();
                if (is_string($bappArr['berkas_bapp'])) {
                    $bappArr['berkas_bapp'] = json_decode($bappArr['berkas_bapp'], true);
                }
                return $bappArr;
            });
            return response()->json(['bapps' => $bapps]);
        }
        return view('bapp-table', compact('bapps'));
    }
    // Tabel admin BAPP INTERNAL
    public function indexInternal()
    {
        $bapps = Bapp::where('tipe', 'internal')->orderBy('created_at', 'desc')->get();
        return view('bapp-table', ['bapps' => $bapps, 'tipe' => 'internal']);
    }
    // Tabel admin BAPP EKSTERNAL
    public function indexEksternal()
    {
        $bapps = Bapp::where('tipe', 'eksternal')->orderBy('created_at', 'desc')->get();
        return view('bapp-table', ['bapps' => $bapps, 'tipe' => 'eksternal']);
    }
    // Tabel user
    public function index()
    {
        $bapps = Bapp::orderBy('created_at', 'desc')->get()->map(function($bapp) {
            return [
                'nomor_bapp' => $bapp->nomor_bapp ?? '',
                'no_po' => $bapp->no_po ?? '',
                'tanggal_po' => $bapp->tanggal_po ?? '',
                'tanggal_terima' => $bapp->tanggal_terima ?? '',
                'nama_proyek' => $bapp->nama_proyek ?? '',
                'harga_total' => $bapp->harga_total ?? '',
                'berkas_bapp' => $bapp->berkas_bapp ?? '',
                'tipe' => $bapp->tipe ?? '',
                'id' => $bapp->id ?? '',
            ];
        });
        return view('bapp', compact('bapps'));
    }
    // Tabel user BAPP INTERNAL
    public function indexInternalUser(Request $request)
    {
        $query = Bapp::where('tipe', 'internal')->orderBy('created_at', 'desc');
        if ($request->ajax() && $request->has('nama_proyek')) {
            $bapps = $query->get()->map(function($bapp) {
                $berkas = $bapp->berkas_bapp;
                if (is_string($berkas)) {
                    $berkas = json_decode($berkas, true);
                }
                return [
                    'nomor_bapp' => $bapp->nomor_bapp ?? '',
                    'no_po' => $bapp->no_po ?? '',
                    'tanggal_po' => $bapp->tanggal_po ?? '',
                    'tanggal_terima' => $bapp->tanggal_terima ?? '',
                    'nama_proyek' => $bapp->nama_proyek ?? '',
                    'harga_total' => $bapp->harga_total ?? '',
                    'berkas_bapp' => $berkas ?? [],
                    'tipe' => $bapp->tipe ?? '',
                    'id' => $bapp->id ?? '',
                ];
            });
            return response()->json(['bapps' => $bapps]);
        }
        $bapps = $query->get()->map(function($bapp) {
            $berkas = $bapp->berkas_bapp;
            if (is_string($berkas)) {
                $berkas = json_decode($berkas, true);
            }
            return [
                'nomor_bapp' => $bapp->nomor_bapp ?? '',
                'no_po' => $bapp->no_po ?? '',
                'tanggal_po' => $bapp->tanggal_po ?? '',
                'tanggal_terima' => $bapp->tanggal_terima ?? '',
                'nama_proyek' => $bapp->nama_proyek ?? '',
                'harga_total' => $bapp->harga_total ?? '',
                'berkas_bapp' => $berkas ?? [],
                'tipe' => $bapp->tipe ?? '',
                'id' => $bapp->id ?? '',
            ];
        });
        return view('bapp', ['bapps' => $bapps, 'tipe' => 'internal']);
    }
    // Tabel user BAPP EKSTERNAL
    public function indexEksternalUser(Request $request)
    {
        if ($request->ajax() && $request->has('nama_proyek')) {
            $bapps = Bapp::where('tipe', 'eksternal')
                ->where('nama_proyek', $request->get('nama_proyek'))
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($bapp) {
                    $berkas = $bapp->berkas_bapp;
                    if (is_string($berkas)) {
                        $berkas = json_decode($berkas, true);
                    }
                    return [
                        'nomor_bapp' => $bapp->nomor_bapp ?? '',
                        'no_po' => $bapp->no_po ?? '',
                        'tanggal_po' => $bapp->tanggal_po ?? '',
                        'tanggal_terima' => $bapp->tanggal_terima ?? '',
                        'nama_proyek' => $bapp->nama_proyek ?? '',
                        'harga_total' => $bapp->harga_total ?? '',
                        'berkas_bapp' => $berkas ?? [],
                        'tipe' => $bapp->tipe ?? '',
                        'id' => $bapp->id ?? '',
                    ];
                });
            return response()->json(['bapps' => $bapps]);
        }
        // Jika tidak ada parameter, kembalikan array kosong
        if ($request->ajax()) {
            return response()->json(['bapps' => []]);
        }
        $bapps = Bapp::where('tipe', 'eksternal')->orderBy('created_at', 'desc')->get()->map(function($bapp) {
            $berkas = $bapp->berkas_bapp;
            if (is_string($berkas)) {
                $berkas = json_decode($berkas, true);
            }
            return [
                'nomor_bapp' => $bapp->nomor_bapp ?? '',
                'no_po' => $bapp->no_po ?? '',
                'tanggal_po' => $bapp->tanggal_po ?? '',
                'tanggal_terima' => $bapp->tanggal_terima ?? '',
                'nama_proyek' => $bapp->nama_proyek ?? '',
                'harga_total' => $bapp->harga_total ?? '',
                'berkas_bapp' => $berkas ?? [],
                'tipe' => $bapp->tipe ?? '',
                'id' => $bapp->id ?? '',
            ];
        });
        return view('bapp', ['bapps' => $bapps, 'tipe' => 'eksternal']);
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
                'harga_total' => 'required|string',
                'berkas_bapp' => 'nullable', // allow null/array
                'berkas_bapp.*' => 'nullable|file|mimes:pdf|max:20480',
                'tipe' => 'required|in:internal,eksternal',
            ]);
            $berkasArr = [];
            if ($request->hasFile('berkas_bapp')) {
                foreach ($request->file('berkas_bapp') as $file) {
                    $path = $file->store('dokumen_bapp', 'public');
                    $berkasArr[] = [
                        'path' => $path,
                        'name' => $file->getClientOriginalName(),
                    ];
                }
            }
            \App\Models\Bapp::create([
                'nomor_bapp' => $data['nomor_bapp'],
                'no_po' => $data['no_po'],
                'tanggal_po' => $data['tanggal_po'],
                'tanggal_terima' => $data['tanggal_terima'],
                'nama_proyek' => $data['nama_proyek'],
                'harga_total' => $data['harga_total'],
                'berkas_bapp' => !empty($berkasArr) ? json_encode($berkasArr) : json_encode([]),
                'tipe' => $data['tipe'],
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
            'harga_total' => 'required|string',
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
    // Update BAPP (internal/eksternal)
    public function updateInternal(Request $request, $id)
    {
        $bapp = Bapp::findOrFail($id);
        $data = $request->validate([
            'nomor_bapp' => 'required|string',
            'no_po' => 'required|string',
            'tanggal_po' => 'required|date',
            'tanggal_terima' => 'required|date',
            'nama_proyek' => 'required|string',
            'harga_total' => 'required|string',
            'berkas_bapp' => 'nullable|file|mimes:pdf|max:20480',
            'tipe' => 'required|in:internal,eksternal',
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
    // Update BAPP (internal/eksternal)
    public function updateEksternal(Request $request, $id)
    {
        $bapp = Bapp::findOrFail($id);
        $data = $request->validate([
            'nomor_bapp' => 'required|string',
            'no_po' => 'required|string',
            'tanggal_po' => 'required|date',
            'tanggal_terima' => 'required|date',
            'nama_proyek' => 'required|string',
            'harga_total' => 'required|string',
            'berkas_bapp' => 'nullable|file|mimes:pdf|max:20480',
            'tipe' => 'required|in:internal,eksternal',
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
    // Destroy BAPP (internal/eksternal)
    public function destroyInternal($id)
    {
        $bapp = Bapp::findOrFail($id);
        $bapp->delete();
        return response()->json(['success' => true]);
    }
    // Destroy BAPP (internal/eksternal)
    public function destroyEksternal($id)
    {
        $bapp = Bapp::findOrFail($id);
        $bapp->delete();
        return response()->json(['success' => true]);
    }
} 