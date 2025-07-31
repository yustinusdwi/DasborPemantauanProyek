<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Kontrak;
use App\Models\Spph;
use App\Models\Sph;
use App\Models\Nego;
use App\Models\Notification;
use App\Models\Bapp;

class dashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama
     */
    public function index(): View
    {
        // Data statistik dashboard
        $dashboardStats = $this->getDashboardStats();
        
        // Data proyek untuk tabel
        $projectData = $this->getProjectData();
        
        // Data untuk chart
        $chartData = $this->getChartData();
        
        // Data untuk menu SPPH, SPH, Nego, Kontrak
        $spphData = $this->getSpphData();
        $sphData = $this->getSphData();
        $negoData = $this->getNegoData();
        $kontrakData = $this->getKontrakData();

        // Generate notifikasi SPPH dan Kontrak
        $this->generateNotifikasiSpph();
        $this->generateNotifikasiKontrak();

        // Ambil notifikasi terbaru (semua type)
        $notifications = \App\Models\Notification::orderBy('type')
            ->orderBy('nama_proyek')
            ->orderBy('batas_akhir')
            ->get();
        // Filter: hanya notifikasi 21, 14, 7 hari (dengan pesan minggu) dan BELUM DIBACA
        $filtered = $notifications->filter(function($notif) {
            return preg_match('/(1|2|3) minggu/', $notif->message) && !$notif->is_read;
        })->sortBy(function($notif) {
            // Urutkan: 3 minggu (21 hari) dulu, lalu 2, lalu 1
            if(str_contains($notif->message, '3 minggu')) return 1;
            if(str_contains($notif->message, '2 minggu')) return 2;
            if(str_contains($notif->message, '1 minggu')) return 3;
            return 4;
        });
        $unreadCount = $filtered->count();
        return view('dashboard', compact('dashboardStats', 'projectData', 'chartData', 'spphData', 'sphData', 'negoData', 'kontrakData', 'notifications', 'unreadCount', 'filtered'));
    }

    /**
     * Menampilkan halaman daftar notifikasi per proyek
     */
    public function listNotifications()
    {
        // Ambil semua notifikasi, urutkan per proyek dan waktu
        $publishedSphProjects = \App\Models\Sph::where('is_published', true)->pluck('nama_proyek')->toArray();
        $bappInternalProjects = \App\Models\Bapp::where('tipe', 'internal')->pluck('nama_proyek')->toArray();
        $notifications = \App\Models\Notification::orderBy('nama_proyek')
            ->orderBy('batas_akhir', 'desc')
            ->get()
            ->filter(function($notif) use ($publishedSphProjects, $bappInternalProjects) {
                if ($notif->type === 'spph' && in_array($notif->nama_proyek, $publishedSphProjects)) {
                    return false;
                }
                if ($notif->type === 'kontrak' && in_array($notif->nama_proyek, $bappInternalProjects)) {
                    return false;
                }
                return true;
            })
            ->groupBy('nama_proyek');
        return view('notifications.list', compact('notifications'));
    }

    /**
     * Mendapatkan statistik dashboard
     */
    private function getDashboardStats(): array
    {
        $totalSales = Kontrak::sum('harga_total');
        $totalPenjualan = \App\Models\Bapp::where('tipe', 'eksternal')->sum('harga_total');
        $bappEksternalData = \App\Models\Bapp::where('tipe', 'eksternal')->orderBy('created_at', 'desc')->get(['nomor_bapp','no_po','tanggal_po','tanggal_terima','nama_proyek','harga_total']);
        
        // Hitung jumlah proyek berdasarkan checklist kontrak
        $spphList = Spph::orderBy('created_at', 'desc')->get();
        $kontrakList = Kontrak::orderBy('created_at', 'desc')->get();
        $jumlahProyek = 0;
        
        foreach ($spphList as $spph) {
            $kontrak = $kontrakList->firstWhere('nama_proyek', $spph->nama_proyek);
            if ($kontrak) {
                $jumlahProyek++;
            }
        }
        
        return [
            'target_sales' => 'Rp ' . number_format($totalSales, 0, ',', '.'),
            'penjualan' => 'Rp ' . number_format($totalPenjualan, 0, ',', '.'),
            'total_proyek' => $jumlahProyek,
            'bapp_eksternal_data' => $bappEksternalData
        ];
    }

    /**
     * Mendapatkan data proyek untuk tabel
     */
    private function getProjectData(): array
    {
        $spphList = Spph::orderBy('created_at', 'desc')->get();
        $sphList = \App\Models\Sph::where('is_published', true)->orderBy('created_at', 'desc')->get();
        $negoList = \App\Models\Nego::orderBy('created_at', 'desc')->get();
        $kontrakList = \App\Models\Kontrak::orderBy('created_at', 'desc')->get();
        $bappInternalList = Bapp::where('tipe', 'internal')->orderBy('created_at', 'desc')->get();
        $bappEksternalList = Bapp::where('tipe', 'eksternal')->orderBy('created_at', 'desc')->get();
        $projectData = [];
        
        foreach ($spphList as $spph) {
            $sph = $sphList->firstWhere('nama_proyek', $spph->nama_proyek);
            $nego = $negoList->firstWhere('nama_proyek', $spph->nama_proyek);
            $kontrak = $kontrakList->firstWhere('nama_proyek', $spph->nama_proyek);
            $bappInternal = $bappInternalList->firstWhere('nama_proyek', $spph->nama_proyek);
            $bappEksternal = $bappEksternalList->firstWhere('nama_proyek', $spph->nama_proyek);

            // Checklist BAPP EKSTERNAL
            $bappEksternalBtn = '-';
            if ($bappEksternal) {
                $bappEksternalBtn = '<button class="btn btn-link p-0 m-0 text-success btn-detail-bapp-eksternal" data-nama-proyek="'.htmlspecialchars($spph->nama_proyek, ENT_QUOTES, 'UTF-8').'" style="font-size:1.2em;vertical-align:middle;" title="Lihat BAPP Eksternal">&#10003;</button>';
            }

            // Checklist hasil negosiasi
            $negoChecklist = '-';
            if ($nego) {
                $hasHasil = $nego->details()->where('tipe', 'hasil')->exists();
                if ($hasHasil) {
                    $negoChecklist = '<button class="btn btn-link p-0 m-0 text-success btn-detail-hasil-nego" data-nama-proyek="'.htmlspecialchars($spph->nama_proyek, ENT_QUOTES, 'UTF-8').'" style="font-size:1.2em;vertical-align:middle;" title="Lihat Hasil Negosiasi">&#10003;</button>';
                }
            }

            // Progress akumulasi baru
            $progress = 0;
            $progressClass = 'bg-danger';
            if ($sph) $progress += 25;
            if ($nego) $progress += 25;
            if ($kontrak) $progress += 25;
            if ($bappInternal) $progress += 10;
            if ($bappEksternal) $progress += 15;
            if ($progress == 100) $progressClass = 'bg-success';
            elseif ($progress >= 75) $progressClass = 'bg-orange';
            elseif ($progress >= 50) $progressClass = 'bg-warning';
            elseif ($progress >= 25) $progressClass = 'bg-primary';

            $bappInternalBtn = '-';
            if ($bappInternal) {
                $bappInternalBtn = '<button class="btn btn-link p-0 m-0 text-success btn-detail-bapp-internal" data-nama-proyek="'.htmlspecialchars($spph->nama_proyek, ENT_QUOTES, 'UTF-8').'" style="font-size:1.2em;vertical-align:middle;" title="Lihat BAPP Internal">&#10003;</button>';
            }

            $projectData[] = [
                'nama' => $spph->nama_proyek ?? $spph->uraian,
                'tanggal_spph' => $spph->tanggal ? \Carbon\Carbon::parse($spph->tanggal)->format('Y') : null,
                'spph' => '<a href="#" class="proyek-check" data-tipe="spph" data-info="' . htmlspecialchars(json_encode([
                    'no_spph' => $spph->nomor_spph,
                    'subkontraktor' => $spph->subkontraktor,
                    'tanggal' => $spph->tanggal ? \Carbon\Carbon::parse($spph->tanggal)->format('d/m/Y') : null,
                    'batas_akhir' => $spph->batas_akhir_sph ? \Carbon\Carbon::parse($spph->batas_akhir_sph)->format('d/m/Y') : null,
                    'uraian' => $spph->uraian,
                    'nama_proyek' => $spph->nama_proyek,
                ]), ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($spph->nomor_spph) . '</a>',
                'tanggal_sph' => $sph ? ($sph->tanggal ? \Carbon\Carbon::parse($sph->tanggal)->format('Y') : null) : null,
                'sph' => $sph ? '<a href="#" class="proyek-check" data-tipe="sph" data-info="' . htmlspecialchars(json_encode([
                    'no_sph' => $sph->nomor_sph,
                    'subkontraktor' => $sph->subkontraktor,
                    'tanggal' => $sph->tanggal ? \Carbon\Carbon::parse($sph->tanggal)->format('d/m/Y') : null,
                    'uraian' => $sph->uraian,
                    'harga_total' => $sph->harga_total,
                    'file_sph' => $sph->dokumen_sph,
                    'nama_proyek' => $sph->nama_proyek,
                ]), ENT_QUOTES, 'UTF-8') . '"><span style="color:green;font-size:1.2em;">&#10003;</span></a>' : '-',
                'tanggal_kontrak' => $kontrak ? ($kontrak->tanggal ? \Carbon\Carbon::parse($kontrak->tanggal)->format('Y') : null) : null,
                'nego' => $negoChecklist,
                'kontrak' => $kontrak ? '<a href="#" class="proyek-check" data-tipe="kontrak" data-info="' . htmlspecialchars(json_encode([
                    'no_kontrak' => $kontrak->nomor_kontrak,
                    'subkontraktor' => $kontrak->subkontraktor,
                    'tanggal' => $kontrak->tanggal ? \Carbon\Carbon::parse($kontrak->tanggal)->format('d/m/Y') : null,
                    'batas_akhir' => $kontrak->batas_akhir_kontrak ? \Carbon\Carbon::parse($kontrak->batas_akhir_kontrak)->format('d/m/Y') : null,
                    'uraian' => $kontrak->uraian,
                    'harga_total' => $kontrak->harga_total,
                    'file_kontrak' => $kontrak->dokumen_kontrak,
                    'nama_proyek' => $kontrak->nama_proyek,
                ]), ENT_QUOTES, 'UTF-8') . '"><span style="color:green;font-size:1.2em;">&#10003;</span></a>' : '-',
                'bapp_internal' => $bappInternalBtn,
                'bapp_eksternal' => $bappEksternalBtn,
                'progress' => $progress,
                'progress_class' => $progressClass,
            ];
        }
        
        if (empty($projectData)) {
            return [[
                'nama' => 'Data proyek tidak tersedia',
                'spph' => '-',
                'sph' => '-',
                'nego' => '-',
                'kontrak' => '-',
                'bapp_internal' => '-',
                'bapp_eksternal' => '-',
                'progress' => 0,
                'progress_class' => 'bg-danger',
            ]];
        }
        
        return $projectData;
    }

    /**
     * Mendapatkan data SPPH untuk tabel
     */
    private function getSpphData(): array
    {
        // Data akan diambil dari database
        return [];
    }

    /**
     * Mendapatkan data SPH untuk tabel
     */
    private function getSphData(): array
    {
        // Data akan diambil dari database
        return [];
    }

    /**
     * Mendapatkan data Nego untuk tabel
     */
    private function getNegoData(): array
    {
        // Data akan diambil dari database
        return [];
    }

    /**
     * Mendapatkan data Kontrak untuk tabel
     */
    private function getKontrakData(): array
    {
        return \App\Models\Kontrak::orderBy('created_at', 'desc')->get()->map(function($kontrak) {
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
                'no_kontrak' => $kontrak->nomor_kontrak,
                'subkontraktor' => $kontrak->subkontraktor,
                'tanggal' => $kontrak->tanggal ? \Carbon\Carbon::parse($kontrak->tanggal)->format('d/m/Y') : null,
                'tanggal_year' => $kontrak->tanggal ? \Carbon\Carbon::parse($kontrak->tanggal)->format('Y') : null,
                'batas_akhir' => $kontrak->batas_akhir_kontrak ? \Carbon\Carbon::parse($kontrak->batas_akhir_kontrak)->format('d/m/Y') : null,
                'nama_proyek' => $kontrak->nama_proyek,
                'uraian' => $kontrak->uraian,
                'nilai_harga_total' => (int) $kontrak->harga_total,
                'file_kontrak' => $normalizeFile($kontrak->dokumen_kontrak),
            ];
        })->toArray();
    }

    /**
     * Mendapatkan data untuk chart
     */
    private function getChartData(): array
    {
        // Ambil data subkontraktor dari tabel Kontrak
        $kontrakList = \App\Models\Kontrak::all();
        $subkontraktorCounts = [];
        foreach ($kontrakList as $kontrak) {
            $subkon = strtoupper(trim($kontrak->subkontraktor ?? 'Tidak Diketahui'));
            if (!isset($subkontraktorCounts[$subkon])) {
                $subkontraktorCounts[$subkon] = 0;
            }
            $subkontraktorCounts[$subkon]++;
        }
        // Daftar subkontraktor utama
        $mainSubs = ['INKA', 'IMS', 'IMST', 'IMSC', 'REKA'];
        $mainCounts = array_fill_keys($mainSubs, 0);
        
        // Hanya hitung subkontraktor yang ada dalam daftar utama
        foreach ($subkontraktorCounts as $subkon => $count) {
            if (in_array($subkon, $mainSubs)) {
                $mainCounts[$subkon] += $count;
            }
        }
        
        // Hapus subkontraktor yang tidak memiliki data (count = 0)
        $subkonLabels = [];
        $subkonData = [];
        foreach ($mainCounts as $subkon => $count) {
            if ($count > 0) {
                $subkonLabels[] = $subkon;
                $subkonData[] = $count;
            }
        }
        // Sinkronisasi warna dan struktur dengan status_pie_chart
        $colorPalette = [
            'rgba(255, 99, 132, 0.8)',   // Merah
            'rgba(54, 162, 235, 0.8)',   // Biru
            'rgba(255, 206, 86, 0.8)',   // Kuning
            'rgba(75, 192, 192, 0.8)',   // Cyan
            'rgba(153, 102, 255, 0.8)'   // Ungu
        ];
        
        // Pastikan warna sesuai dengan jumlah label
        $subkontraktorColors = array_slice($colorPalette, 0, count($subkonLabels));
        // Data pie chart status proyek dari semua proyek yang ada di sistem
        $spphList = Spph::orderBy('created_at', 'desc')->get();
        $sphList = \App\Models\Sph::where('is_published', true)->orderBy('created_at', 'desc')->get();
        $negoList = \App\Models\Nego::orderBy('created_at', 'desc')->get();
        $kontrakList = \App\Models\Kontrak::orderBy('created_at', 'desc')->get();
        $bappInternalList = Bapp::where('tipe', 'internal')->orderBy('created_at', 'desc')->get();
        $bappEksternalList = Bapp::where('tipe', 'eksternal')->orderBy('created_at', 'desc')->get();
        
        // Gabungkan semua nama proyek dari semua tabel
        $allProjectNames = collect();
        $allProjectNames = $allProjectNames->merge($spphList->pluck('nama_proyek'));
        $allProjectNames = $allProjectNames->merge($sphList->pluck('nama_proyek'));
        $allProjectNames = $allProjectNames->merge($negoList->pluck('nama_proyek'));
        $allProjectNames = $allProjectNames->merge($kontrakList->pluck('nama_proyek'));
        $allProjectNames = $allProjectNames->merge($bappInternalList->pluck('nama_proyek'));
        $allProjectNames = $allProjectNames->merge($bappEksternalList->pluck('nama_proyek'));
        
        // Hapus duplikat dan nilai null
        $uniqueProjectNames = $allProjectNames->filter()->unique()->values();
        
        $progressMap = [
            0 => '0% (SPPH)',
            25 => '25% (SPH)',
            50 => '50% (Negosiasi)',
            75 => '75% (Kontrak)',
            85 => '85% (BAPP Internal)',
            100 => '100% (BAPP Eksternal)'
        ];
        $progressCounts = [0 => 0, 25 => 0, 50 => 0, 75 => 0, 85 => 0, 100 => 0];
        
        foreach ($uniqueProjectNames as $projectName) {
            // Cek status proyek berdasarkan data yang ada
            $hasSpph = $spphList->where('nama_proyek', $projectName)->count() > 0;
            $hasSph = $sphList->where('nama_proyek', $projectName)->count() > 0;
            $hasNego = $negoList->where('nama_proyek', $projectName)->count() > 0;
            $hasKontrak = $kontrakList->where('nama_proyek', $projectName)->count() > 0;
            $hasBappInternal = $bappInternalList->where('nama_proyek', $projectName)->count() > 0;
            $hasBappEksternal = $bappEksternalList->where('nama_proyek', $projectName)->count() > 0;
            

            
            // Hitung progress berdasarkan status tertinggi
            $progress = 0;
            if ($hasBappEksternal) {
                $progress = 100; // BAPP Eksternal ada (status tertinggi)
            } elseif ($hasBappInternal) {
                $progress = 85; // BAPP Internal ada
            } elseif ($hasKontrak) {
                $progress = 75; // Kontrak ada
            } elseif ($hasNego) {
                $progress = 50; // Negosiasi ada
            } elseif ($hasSph) {
                $progress = 25; // SPH ada
            } elseif ($hasSpph) {
                $progress = 0; // SPPH ada
            }
            
            // Mapping progress ke kategori
            if ($progress === 0) $progressCounts[0]++;
            elseif ($progress === 25) $progressCounts[25]++;
            elseif ($progress === 50) $progressCounts[50]++;
            elseif ($progress === 75) $progressCounts[75]++;
            elseif ($progress === 85) $progressCounts[85]++;
            elseif ($progress === 100) $progressCounts[100]++;
            

        }
        $statusLabels = [];
        $statusCounts = [];
        foreach ($progressCounts as $p => $count) {
            $statusLabels[] = $progressMap[$p];
            $statusCounts[] = $count;
        }
        

        $statusColors = [
            'rgba(108, 117, 125, 0.8)',   // Abu
            'rgba(54, 162, 235, 0.8)',    // Biru
            'rgba(255, 193, 7, 0.8)',     // Kuning
            'rgba(0, 123, 255, 0.8)',     // Biru tua
            'rgba(255, 159, 64, 0.8)',    // Oranye
            'rgba(40, 167, 69, 0.8)'      // Hijau
        ];
        return [
            'customer_pie_chart' => [
                'labels' => $subkonLabels,
                'data' => $subkonData,
                'colors' => $subkontraktorColors
            ],
            'status_pie_chart' => [
                'labels' => $statusLabels,
                'data' => $statusCounts,
                'colors' => array_slice($statusColors, 0, count($statusLabels))
            ]
        ];
    }

    /**
     * API endpoint untuk mendapatkan data proyek (untuk AJAX)
     */
    public function getProjectDataApi()
    {
        return response()->json($this->getProjectData());
    }

    /**
     * API endpoint untuk filter data proyek
     */
    public function filterProjects(Request $request)
    {
        $allProjectData = $this->getProjectData();
        
        $namaProyek = $request->input('nama_proyek', '');
        $spph = $request->input('spph', '');
        $sph = $request->input('sph', '');
        $nego = $request->input('nego', '');
        $kontrak = $request->input('kontrak', '');

        $filteredData = collect($allProjectData)->filter(function ($project) use ($namaProyek, $spph, $sph, $nego, $kontrak) {
            $match = true;

            if ($namaProyek && !str_contains(strtolower($project['nama']), strtolower($namaProyek))) {
                $match = false;
            }
            if ($spph && $project['spph'] !== $spph) {
                $match = false;
            }
            if ($sph && $project['sph'] !== $sph) {
                $match = false;
            }
            if ($nego && $project['nego'] !== $nego) {
                $match = false;
            }
            if ($kontrak && $project['kontrak'] !== $kontrak) {
                $match = false;
            }

            return $match;
        })->values();

        // Format data untuk response
        $formattedData = $filteredData->map(function ($project) {
            return [
                'nama' => $project['nama'],
                'spph' => $project['spph'],
                'sph' => $project['sph'],
                'nego' => $project['nego'],
                'kontrak' => $project['kontrak'],
                'bapp_internal' => $project['bapp_internal'] ?? '-',
                'bapp_eksternal' => $project['bapp_eksternal'] ?? '-',
                'progress' => $project['progress'] ?? 0,
                'progress_class' => $project['progress_class'] ?? 'bg-danger',
                'progress_bar' => self::getProgressBar($project['progress'] ?? 0, null, $project['progress_class'] ?? 'bg-danger')
            ];
        });

        return response()->json([
            'data' => $formattedData,
            'count' => $filteredData->count()
        ]);
    }

    /**
     * Mendapatkan badge status untuk HTML
     */
    public static function getStatusBadge(string $status): string
    {
        $badgeClasses = [
            'Berjalan' => 'badge-success',
            'Selesai' => 'badge-secondary',
            'Pending' => 'badge-warning',
            'Ditolak' => 'badge-danger'
        ];

        $badgeClass = $badgeClasses[$status] ?? 'badge-secondary';
        return "<span class=\"badge {$badgeClass}\">{$status}</span>";
    }

    /**
     * Mendapatkan progress bar untuk HTML
     */
    public static function getProgressBar($progress, $status = null, $progressClass = null)
    {
        $barClass = 'progress-bar';
        // Pewarnaan konsisten
        if (!$progressClass) {
            if ($progress == 100) $progressClass = 'bg-success';
            elseif ($progress == 75) $progressClass = 'bg-orange';
            elseif ($progress == 50) $progressClass = 'bg-warning';
            elseif ($progress == 25) $progressClass = 'bg-primary';
            else $progressClass = 'bg-danger';
        }
        $barClass .= ' ' . $progressClass;
        return "<div class=\"progress\"><div class=\"{$barClass}\" role=\"progressbar\" style=\"width: {$progress}%\">{$progress}%</div></div>";
    }

    /**
     * Format nilai kontrak ke format Rupiah
     */
    public static function formatCurrency(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Mendapatkan data untuk DataTables
     */
    public function getDataTableData()
    {
        $projectData = $this->getProjectData();
        
        $formattedData = collect($projectData)->map(function ($project, $index) {
            return [
                'no' => $index + 1,
                'nama' => $project['nama'],
                'spph' => $project['spph'],
                'sph' => $project['sph'],
                'nego' => $project['nego'],
                'kontrak' => $project['kontrak'],
                'bapp_internal' => $project['bapp_internal'] ?? '-',
                'bapp_eksternal' => $project['bapp_eksternal'] ?? '-',
                'progress' => self::getProgressBar($project['progress'] ?? 0, null, $project['progress_class'] ?? 'bg-danger'),
                'actions' => '<button class="btn btn-sm btn-info">Detail</button> <button class="btn btn-sm btn-warning">Edit</button>'
            ];
        });

        return response()->json([
            'data' => $formattedData
        ]);
    }

    /**
     * Mendapatkan opsi untuk dropdown filter
     */
    public function getFilterOptions()
    {
        $projectData = $this->getProjectData();
        
        $spphOptions = collect($projectData)->pluck('spph')->unique()->values();
        $sphOptions = collect($projectData)->pluck('sph')->unique()->values();
        $negoOptions = collect($projectData)->pluck('nego')->unique()->values();
        $kontrakOptions = collect($projectData)->pluck('kontrak')->unique()->values();
        
        return response()->json([
            'spph' => $spphOptions,
            'sph' => $sphOptions,
            'nego' => $negoOptions,
            'kontrak' => $kontrakOptions
        ]);
    }

    public function markNotificationRead($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->is_read = true;
        $notif->save();
        return response()->json(['success' => true]);
    }

    private function generateKontrakReminders()
    {
        $kontraks = Kontrak::all();
        $now = now();
        $reminderDays = [7, 3, 2, 1, 0];
        foreach ($kontraks as $kontrak) {
            $batasAkhir = $kontrak->batas_akhir_kontrak;
            if (!$batasAkhir) continue;
            $batasAkhirDate = \Carbon\Carbon::parse($batasAkhir);
            $daysDiff = $now->diffInDays($batasAkhirDate, false);
            if (in_array($daysDiff, $reminderDays)) {
                $msg = $daysDiff === 0 ? 'Hari ini adalah batas akhir proyek "'.$kontrak->nama_proyek.'"!' : 'Batas akhir proyek "'.$kontrak->nama_proyek.'" tinggal '.$daysDiff.' hari lagi!';
                $exists = Notification::where('kontrak_id', $kontrak->id)
                    ->where('batas_akhir', $batasAkhirDate)
                    ->where('message', $msg)
                    ->exists();
                if (!$exists) {
                    Notification::create([
                        'kontrak_id' => $kontrak->id,
                        'nama_proyek' => $kontrak->nama_proyek,
                        'batas_akhir' => $batasAkhirDate,
                        'message' => $msg,
                        'is_read' => false,
                    ]);
                }
            }
        }
    }

    // Ubah dari private ke public agar bisa dipanggil dari luar
    public function generateNotifikasiSpph()
    {
        $spphs = \App\Models\Spph::all();
        $now = now();
        $reminderDays = [21, 14, 7];
        $publishedSphProjects = \App\Models\Sph::where('is_published', true)->pluck('nama_proyek')->toArray();
        foreach ($spphs as $spph) {
            // Jika proyek sudah ada di SPH, hapus SEMUA notifikasi SPPH untuk proyek ini dan lanjut ke proyek berikutnya
            if (in_array($spph->nama_proyek, $publishedSphProjects)) {
                \App\Models\Notification::where('type', 'spph')
                    ->where('nama_proyek', $spph->nama_proyek)
                    ->delete();
                continue;
            }
            $batasAkhir = $spph->batas_akhir_sph;
            if (!$batasAkhir) continue;
            $batasAkhirDate = \Carbon\Carbon::parse($batasAkhir);
            foreach ($reminderDays as $reminder) {
                $targetDate = $batasAkhirDate->copy()->subDays($reminder);
                // Jika hari ini >= targetDate dan batas akhir di masa depan
                if ($now->greaterThanOrEqualTo($targetDate) && $batasAkhirDate->isFuture()) {
                    $msg = 'Batas akhir SPPH untuk proyek "'.$spph->nama_proyek.'" tinggal '.($reminder/7).' minggu lagi!';
                    $exists = \App\Models\Notification::where('type', 'spph')
                        ->where('nama_proyek', $spph->nama_proyek)
                        ->where('batas_akhir', $batasAkhirDate)
                        ->where('message', $msg)
                        ->exists();
                    if (!$exists) {
                        $level = $reminder == 21 ? 'yellow' : ($reminder == 14 ? 'orange' : 'red');
                        \App\Models\Notification::create([
                            'kontrak_id' => null,
                            'nama_proyek' => $spph->nama_proyek,
                            'batas_akhir' => $batasAkhirDate,
                            'message' => $msg,
                            'is_read' => false,
                            'type' => 'spph',
                        ]);
                    }
                }
            }
        }
    }

    // Ubah dari private ke public agar bisa dipanggil dari luar
    public function generateNotifikasiKontrak()
    {
        $kontraks = \App\Models\Kontrak::all();
        $now = now();
        $reminderDays = [21, 14, 7];
        $bappInternalProjects = \App\Models\Bapp::where('tipe', 'internal')->pluck('nama_proyek')->toArray();
        foreach ($kontraks as $kontrak) {
            $batasAkhir = $kontrak->batas_akhir_kontrak;
            if (!$batasAkhir) continue;
            $batasAkhirDate = \Carbon\Carbon::parse($batasAkhir);
            $isInBappInternal = in_array($kontrak->nama_proyek, $bappInternalProjects);
            foreach ($reminderDays as $reminder) {
                $targetDate = $batasAkhirDate->copy()->subDays($reminder);
                // Jika proyek sudah ada di BAPP INTERNAL, hanya izinkan notifikasi 3 minggu, hapus notifikasi 2/1 minggu yang sudah ada
                if ($isInBappInternal && $reminder < 21) {
                    \App\Models\Notification::where('type', 'kontrak')
                        ->where('kontrak_id', $kontrak->id)
                        ->where('batas_akhir', $batasAkhirDate)
                        ->where(function($q){ $q->where('message', 'like', '%2 minggu%')->orWhere('message', 'like', '%1 minggu%'); })
                        ->delete();
                    continue;
                }
                if ($now->greaterThanOrEqualTo($targetDate) && $batasAkhirDate->isFuture()) {
                    $msg = 'Batas akhir kontrak untuk proyek "'.$kontrak->nama_proyek.'" tinggal '.($reminder/7).' minggu lagi!';
                    $exists = \App\Models\Notification::where('type', 'kontrak')
                        ->where('kontrak_id', $kontrak->id)
                        ->where('batas_akhir', $batasAkhirDate)
                        ->where('message', $msg)
                        ->exists();
                    if (!$exists && (!$isInBappInternal || $reminder == 21)) {
                        $level = $reminder == 21 ? 'yellow' : ($reminder == 14 ? 'orange' : 'red');
                        \App\Models\Notification::create([
                            'kontrak_id' => $kontrak->id,
                            'nama_proyek' => $kontrak->nama_proyek,
                            'batas_akhir' => $batasAkhirDate,
                            'message' => $msg,
                            'is_read' => false,
                            'type' => 'kontrak',
                        ]);
                    }
                }
            }
        }
    }
}
