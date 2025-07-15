<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Kontrak;
use App\Models\Spph;

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
        
        return view('dashboard', compact('dashboardStats', 'projectData', 'chartData', 'spphData', 'sphData', 'negoData', 'kontrakData'));
    }

    /**
     * Mendapatkan statistik dashboard
     */
    private function getDashboardStats(): array
    {
        $jumlahKontrak = Kontrak::count();
        return [
            'target_sales' => 'Rp 10.5 Juta',
            'target_pemasaran' => 'Rp 8.2 Juta',
            'total_proyek' => $jumlahKontrak
        ];
    }

    /**
     * Mendapatkan data proyek untuk tabel
     */
    private function getProjectData(): array
    {
        $spphList = Spph::orderBy('created_at', 'desc')->get();
        $sphList = \App\Models\Sph::orderBy('created_at', 'desc')->get();
        $negoList = \App\Models\Nego::orderBy('created_at', 'desc')->get();
        $kontrakList = \App\Models\Kontrak::orderBy('created_at', 'desc')->get();
        $projectData = [];
        foreach ($spphList as $spph) {
            $sph = $sphList->firstWhere('uraian', $spph->uraian);
            $nego = $negoList->firstWhere('uraian', $spph->uraian);
            $kontrak = $kontrakList->firstWhere('uraian', $spph->uraian);

            // Hitung progress berdasarkan jumlah kolom terisi
            $step = 1; // SPPH selalu ada
            $progressClass = 'bg-secondary';
            if ($sph) {
                $step++;
                $progressClass = 'bg-primary';
            }
            if ($nego) {
                $step++;
                $progressClass = 'bg-warning';
            }
            if ($kontrak) {
                $step++;
                $progressClass = 'bg-success';
            }
            $progress = $step * 25;
            if ($progress > 100) $progress = 100;

            $projectData[] = [
                'nama' => $spph->uraian,
                'spph' => '<a href="#" class="proyek-check" data-tipe="spph" data-info="' . htmlspecialchars(json_encode([
                    'no_spph' => $spph->nomor_spph,
                    'tanggal' => $spph->tanggal,
                    'batas_akhir' => $spph->batas_akhir_sph,
                    'uraian' => $spph->uraian,
                    'file_spph' => $spph->dokumen_spph,
                    'file_sow' => $spph->dokumen_sow,
                    'file_lain' => $spph->dokumen_lain,
                ]), ENT_QUOTES, 'UTF-8') . '"><span style="color:green;font-size:1.2em;">&#10003;</span></a>',
                'sph' => $sph ? '<a href="#" class="proyek-check" data-tipe="sph" data-info="' . htmlspecialchars(json_encode([
                    'no_sph' => $sph->nomor_sph,
                    'tanggal' => $sph->tanggal,
                    'uraian' => $sph->uraian,
                    'harga_total' => $sph->harga_total,
                    'file_sph' => $sph->dokumen_sph,
                ]), ENT_QUOTES, 'UTF-8') . '"><span style="color:green;font-size:1.2em;">&#10003;</span></a>' : '-',
                'nego' => $nego ? '<a href="#" class="proyek-check" data-tipe="nego" data-info="' . htmlspecialchars(json_encode([
                    'no_nego' => $nego->nomor_nego,
                    'tanggal' => $nego->tanggal,
                    'uraian' => $nego->uraian,
                    'harga_total' => $nego->harga_total,
                    'file_nego' => $nego->dokumen_nego,
                ]), ENT_QUOTES, 'UTF-8') . '"><span style="color:green;font-size:1.2em;">&#10003;</span></a>' : '-',
                'kontrak' => $kontrak ? '<a href="#" class="proyek-check" data-tipe="kontrak" data-info="' . htmlspecialchars(json_encode([
                    'no_kontrak' => $kontrak->nomor_kontrak,
                    'tanggal' => $kontrak->tanggal,
                    'uraian' => $kontrak->uraian,
                    'harga_total' => $kontrak->harga_total,
                    'file_kontrak' => $kontrak->dokumen_kontrak,
                ]), ENT_QUOTES, 'UTF-8') . '"><span style="color:green;font-size:1.2em;">&#10003;</span></a>' : '-',
                'progress' => $progress,
                'progress_class' => $progressClass,
            ];
        }
        if (empty($projectData)) {
            return [[
                'nama' => 'Data proyek tidak tersedia',
                'spph' => '',
                'sph' => '',
                'nego' => '',
                'kontrak' => '',
                'customer' => '',
                'nomor_kontrak' => '',
                'tanggal_kontrak' => '',
                'status' => '',
                'estimasi_nilai' => 0,
                'progress' => 0
            ]];
        }
        return $projectData;
    }

    /**
     * Mendapatkan data SPPH untuk tabel
     */
    private function getSpphData(): array
    {
        return [
            [
                'no_spph' => 'SPPH-001',
                'tanggal' => '2024-01-15',
                'batas_akhir' => '2024-01-30',
                'nama_pekerjaan' => 'Pembangunan Gedung A',
                'file_spph' => 'SPPH-001.pdf',
                'file_lampiran' => 'Lampiran-SPPH-001.zip',
                'progress' => 75
            ],
            [
                'no_spph' => 'SPPH-002',
                'tanggal' => '2024-02-20',
                'batas_akhir' => '2024-03-05',
                'nama_pekerjaan' => 'Renovasi Kantor B',
                'file_spph' => 'SPPH-002.pdf',
                'file_lampiran' => 'Lampiran-SPPH-002.zip',
                'progress' => 25
            ],
            [
                'no_spph' => 'SPPH-003',
                'tanggal' => '2024-03-10',
                'batas_akhir' => '2024-03-25',
                'nama_pekerjaan' => 'Instalasi Sistem IT',
                'file_spph' => 'SPPH-003.pdf',
                'file_lampiran' => 'Lampiran-SPPH-003.zip',
                'progress' => 90
            ],
            [
                'no_spph' => 'SPPH-004',
                'tanggal' => '2024-01-05',
                'batas_akhir' => '2024-01-20',
                'nama_pekerjaan' => 'Pembangunan Jembatan',
                'file_spph' => 'SPPH-004.pdf',
                'file_lampiran' => 'Lampiran-SPPH-004.zip',
                'progress' => 100
            ],
            [
                'no_spph' => 'SPPH-005',
                'tanggal' => '2024-04-01',
                'batas_akhir' => '2024-04-15',
                'nama_pekerjaan' => 'Pembangunan Mall',
                'file_spph' => 'SPPH-005.pdf',
                'file_lampiran' => 'Lampiran-SPPH-005.zip',
                'progress' => 10
            ],
            [
                'no_spph' => 'SPPH-006',
                'tanggal' => '2024-03-25',
                'batas_akhir' => '2024-04-10',
                'nama_pekerjaan' => 'Renovasi Hotel',
                'file_spph' => 'SPPH-006.pdf',
                'file_lampiran' => 'Lampiran-SPPH-006.zip',
                'progress' => 45
            ]
        ];
    }

    /**
     * Mendapatkan data SPH untuk tabel
     */
    private function getSphData(): array
    {
        return [
            [
                'no_sph' => 'SPH-001',
                'tanggal' => '2024-01-20',
                'batas_akhir' => '2024-02-05',
                'nama_pekerjaan' => 'Pembangunan Gedung A',
                'file_sph' => 'SPH-001.pdf',
                'file_lampiran' => 'Lampiran-SPH-001.zip',
                'progress' => 80
            ],
            [
                'no_sph' => 'SPH-002',
                'tanggal' => '2024-02-25',
                'batas_akhir' => '2024-03-10',
                'nama_pekerjaan' => 'Renovasi Kantor B',
                'file_sph' => 'SPH-002.pdf',
                'file_lampiran' => 'Lampiran-SPH-002.zip',
                'progress' => 30
            ],
            [
                'no_sph' => 'SPH-003',
                'tanggal' => '2024-03-15',
                'batas_akhir' => '2024-03-30',
                'nama_pekerjaan' => 'Instalasi Sistem IT',
                'file_sph' => 'SPH-003.pdf',
                'file_lampiran' => 'Lampiran-SPH-003.zip',
                'progress' => 95
            ],
            [
                'no_sph' => 'SPH-004',
                'tanggal' => '2024-01-10',
                'batas_akhir' => '2024-01-25',
                'nama_pekerjaan' => 'Pembangunan Jembatan',
                'file_sph' => 'SPH-004.pdf',
                'file_lampiran' => 'Lampiran-SPH-004.zip',
                'progress' => 100
            ],
            [
                'no_sph' => 'SPH-005',
                'tanggal' => '2024-04-05',
                'batas_akhir' => '2024-04-20',
                'nama_pekerjaan' => 'Pembangunan Mall',
                'file_sph' => 'SPH-005.pdf',
                'file_lampiran' => 'Lampiran-SPH-005.zip',
                'progress' => 15
            ],
            [
                'no_sph' => 'SPH-006',
                'tanggal' => '2024-03-30',
                'batas_akhir' => '2024-04-15',
                'nama_pekerjaan' => 'Renovasi Hotel',
                'file_sph' => 'SPH-006.pdf',
                'file_lampiran' => 'Lampiran-SPH-006.zip',
                'progress' => 50
            ]
        ];
    }

    /**
     * Mendapatkan data Nego untuk tabel
     */
    private function getNegoData(): array
    {
        return [
            [
                'no_nego' => 'NEGO-001',
                'tanggal' => '2024-01-25',
                'batas_akhir' => '2024-02-10',
                'nama_pekerjaan' => 'Pembangunan Gedung A',
                'file_nego' => 'NEGO-001.pdf',
                'file_lampiran' => 'Lampiran-NEGO-001.zip',
                'progress' => 85
            ],
            [
                'no_nego' => 'NEGO-002',
                'tanggal' => '2024-03-01',
                'batas_akhir' => '2024-03-15',
                'nama_pekerjaan' => 'Renovasi Kantor B',
                'file_nego' => 'NEGO-002.pdf',
                'file_lampiran' => 'Lampiran-NEGO-002.zip',
                'progress' => 35
            ],
            [
                'no_nego' => 'NEGO-003',
                'tanggal' => '2024-03-20',
                'batas_akhir' => '2024-04-05',
                'nama_pekerjaan' => 'Instalasi Sistem IT',
                'file_nego' => 'NEGO-003.pdf',
                'file_lampiran' => 'Lampiran-NEGO-003.zip',
                'progress' => 98
            ],
            [
                'no_nego' => 'NEGO-004',
                'tanggal' => '2024-01-15',
                'batas_akhir' => '2024-01-30',
                'nama_pekerjaan' => 'Pembangunan Jembatan',
                'file_nego' => 'NEGO-004.pdf',
                'file_lampiran' => 'Lampiran-NEGO-004.zip',
                'progress' => 100
            ],
            [
                'no_nego' => 'NEGO-005',
                'tanggal' => '2024-04-10',
                'batas_akhir' => '2024-04-25',
                'nama_pekerjaan' => 'Pembangunan Mall',
                'file_nego' => 'NEGO-005.pdf',
                'file_lampiran' => 'Lampiran-NEGO-005.zip',
                'progress' => 20
            ],
            [
                'no_nego' => 'NEGO-006',
                'tanggal' => '2024-04-05',
                'batas_akhir' => '2024-04-20',
                'nama_pekerjaan' => 'Renovasi Hotel',
                'file_nego' => 'NEGO-006.pdf',
                'file_lampiran' => 'Lampiran-NEGO-006.zip',
                'progress' => 55
            ]
        ];
    }

    /**
     * Mendapatkan data Kontrak untuk tabel
     */
    private function getKontrakData(): array
    {
        return [
            [
                'no_kontrak' => 'KTRK-001',
                'batas_akhir' => '2024-12-31',
                'nilai_harga_total' => 500000000,
                'file_kontrak' => ['Kontrak-001.pdf', 'Lampiran-A.pdf', 'Lampiran-B.pdf']
            ],
            [
                'no_kontrak' => 'KTRK-002',
                'batas_akhir' => '2024-11-30',
                'nilai_harga_total' => 250000000,
                'file_kontrak' => ['Kontrak-002.pdf', 'Lampiran-C.pdf']
            ],
            [
                'no_kontrak' => 'KTRK-003',
                'batas_akhir' => '2024-10-31',
                'nilai_harga_total' => 150000000,
                'file_kontrak' => ['Kontrak-003.pdf', 'Lampiran-D.pdf', 'Lampiran-E.pdf', 'Lampiran-F.pdf']
            ],
            [
                'no_kontrak' => 'KTRK-004',
                'batas_akhir' => '2024-09-30',
                'nilai_harga_total' => 1000000000,
                'file_kontrak' => ['Kontrak-004.pdf', 'Lampiran-G.pdf']
            ],
            [
                'no_kontrak' => 'KTRK-005',
                'batas_akhir' => '2024-08-31',
                'nilai_harga_total' => 2500000000,
                'file_kontrak' => ['Kontrak-005.pdf', 'Lampiran-H.pdf', 'Lampiran-I.pdf']
            ],
            [
                'no_kontrak' => 'KTRK-006',
                'batas_akhir' => '2024-07-31',
                'nilai_harga_total' => 750000000,
                'file_kontrak' => ['Kontrak-006.pdf', 'Lampiran-J.pdf', 'Lampiran-K.pdf', 'Lampiran-L.pdf']
            ]
        ];
    }

    /**
     * Mendapatkan data untuk chart
     */
    private function getChartData(): array
    {
        $projectData = $this->getProjectData();
        
        // Data untuk pie chart customer
        $customerData = collect($projectData)->groupBy('customer')->map(function ($projects) {
            return count($projects);
        })->toArray();
        
        // Data pie chart status proyek dari progress di tabel
        $progressMap = [
            25 => '25% (SPPH)', //test
            50 => '50% (SPPH + SPH)',
            75 => '75% (SPPH + SPH + Nego)',
            100 => '100% (Selesai/Kontrak)'
        ];
        $progressCounts = [25 => 0, 50 => 0, 75 => 0, 100 => 0];
        foreach ($projectData as $row) {
            $p = (int)($row['progress'] ?? 0);
            if (isset($progressCounts[$p])) {
                $progressCounts[$p]++;
            }
        }
        $statusLabels = [];
        $statusCounts = [];
        foreach ($progressCounts as $p => $count) {
            $statusLabels[] = $progressMap[$p];
            $statusCounts[] = $count;
        }
        $statusColors = [
            'rgba(255, 193, 7, 0.8)',   // 25% - Kuning
            'rgba(54, 162, 235, 0.8)',  // 50% - Biru
            'rgba(255, 206, 86, 0.8)',  // 75% - Orange
            'rgba(40, 167, 69, 0.8)'    // 100% - Hijau
        ];
        return [
            'customer_pie_chart' => [
                'labels' => array_keys($customerData),
                'data' => array_values($customerData),
                'colors' => [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ]
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
                'customer' => $project['customer'],
                'nomor_kontrak' => $project['nomor_kontrak'],
                'tanggal_kontrak' => $project['tanggal_kontrak'],
                'status_badge' => self::getStatusBadge($project['status']),
                'estimasi_nilai_formatted' => self::formatCurrency($project['estimasi_nilai']),
                'progress_bar' => self::getProgressBar($project['progress'], $project['status'])
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
        if ($progressClass) {
            $barClass .= ' ' . $progressClass;
        }
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
                'customer' => $project['customer'],
                'nomor_kontrak' => $project['nomor_kontrak'],
                'tanggal_kontrak' => $project['tanggal_kontrak'],
                'status' => self::getStatusBadge($project['status']),
                'estimasi_nilai' => self::formatCurrency($project['estimasi_nilai']),
                'progress' => self::getProgressBar($project['progress'], $project['status']),
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
}
