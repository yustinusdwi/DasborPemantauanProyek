@extends('layouts.app')

@section('title', 'Dasbor Pemantauan Proyek | Dashboard')

@section('content')
                    <div class="container-fluid">
                        <div class="d-flex justify-content-end align-items-center mb-2">
                            <div class="dropdown">
                                <button class="btn btn-light position-relative dropdown-toggle" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color:#000;">
                                    <i class="fas fa-bell fa-lg" style="color:#000;"></i>
                                    @if(isset($unreadCount) && $unreadCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unreadCount }}</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="min-width:320px;max-width:400px;">
                                    <li class="dropdown-header fw-bold">Notifikasi SPPH</li>
                                    @php $notifSpph = isset($filtered) ? $filtered->where('type','spph') : collect(); @endphp
                                    @forelse($notifSpph as $notif)
                                        @php
                                            $color = 'bg-warning'; // default kuning
                                            if(str_contains($notif->message, '2 minggu')) $color = 'bg-orange';
                                            if(str_contains($notif->message, '1 minggu')) $color = 'bg-danger text-white';
                                        @endphp
                                        <li class="px-3 py-2 border-bottom small {{ $color }}">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <span class="fw-bold">{{ $notif->nama_proyek }}</span><br>
                                            <span class="text-muted">{{ $notif->message }}</span><br>
                                            <span class="text-muted"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($notif->batas_akhir)->format('d/m/Y') }}</span>
                                            <button class="btn btn-sm btn-outline-success mt-2 btn-mark-read" data-id="{{ $notif->id }}" @if($notif->is_read) disabled @endif>
                                                {{ $notif->is_read ? 'Sudah Dibaca' : 'Sudah Dibaca' }}
                                            </button>
                                        </li>
                                    @empty
                                        <li class="px-3 py-2 text-muted">Tidak ada notifikasi SPPH.</li>
                                    @endforelse
                                    <li class="dropdown-header fw-bold">Notifikasi Kontrak</li>
                                    @php $notifKontrak = isset($filtered) ? $filtered->where('type','kontrak') : collect(); @endphp
                                    @forelse($notifKontrak as $notif)
                                        @php
                                            $color = 'bg-warning';
                                            if(str_contains($notif->message, '2 minggu')) $color = 'bg-orange';
                                            if(str_contains($notif->message, '1 minggu')) $color = 'bg-danger text-white';
                                        @endphp
                                        <li class="px-3 py-2 border-bottom small {{ $color }}">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <span class="fw-bold">{{ $notif->nama_proyek }}</span><br>
                                            <span class="text-muted">{{ $notif->message }}</span><br>
                                            <span class="text-muted"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($notif->batas_akhir)->format('d/m/Y') }}</span>
                                            <button class="btn btn-sm btn-outline-success mt-2 btn-mark-read" data-id="{{ $notif->id }}" @if($notif->is_read) disabled @endif>
                                                {{ $notif->is_read ? 'Sudah Dibaca' : 'Sudah Dibaca' }}
                                            </button>
                                        </li>
                                    @empty
                                        <li class="px-3 py-2 text-muted">Tidak ada notifikasi kontrak.</li>
                                    @endforelse
                                    <div class="dropdown-divider"></div>
                                    <div class="text-center py-2">
                                        <a href="{{ route('notifikasi.list') }}" class="btn btn-link btn-sm">Lihat Semua Notifikasi</a>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dasbor Pemantauan Proyek</li>
                        </ol>
                        
                        <!-- Filter Tahun -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <select id="filterTahunDashboard" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        @php
                                            $tahunList = [];
                                            // Ambil tahun dari berbagai data
                                            foreach($projectData as $project) {
                                                if(isset($project['tanggal_spph']) && $project['tanggal_spph']) {
                                                    $tahun = $project['tanggal_spph'];
                                                    if(!in_array($tahun, $tahunList)) {
                                                        $tahunList[] = $tahun;
                                                    }
                                                }
                                                if(isset($project['tanggal_sph']) && $project['tanggal_sph']) {
                                                    $tahun = $project['tanggal_sph'];
                                                    if(!in_array($tahun, $tahunList)) {
                                                        $tahunList[] = $tahun;
                                                    }
                                                }
                                                if(isset($project['tanggal_kontrak']) && $project['tanggal_kontrak']) {
                                                    $tahun = $project['tanggal_kontrak'];
                                                    if(!in_array($tahun, $tahunList)) {
                                                        $tahunList[] = $tahun;
                                                    }
                                                }
                                            }
                                            // Tambahkan tahun dari data BAPP
                                            if(isset($dashboardStats['bapp_eksternal_data'])) {
                                                foreach($dashboardStats['bapp_eksternal_data'] as $bapp) {
                                                    if($bapp->tanggal_po) {
                                                        $tahun = \Carbon\Carbon::parse($bapp->tanggal_po)->format('Y');
                                                        if(!in_array($tahun, $tahunList)) {
                                                            $tahunList[] = $tahun;
                                                        }
                                                    }
                                                    if($bapp->tanggal_terima) {
                                                        $tahun = \Carbon\Carbon::parse($bapp->tanggal_terima)->format('Y');
                                                        if(!in_array($tahun, $tahunList)) {
                                                            $tahunList[] = $tahun;
                                                        }
                                                    }
                                                }
                                            }
                                            // Tambahkan tahun dari data kontrak
                                            if(isset($kontrakData)) {
                                                foreach($kontrakData as $kontrak) {
                                                    if(isset($kontrak['tanggal_year']) && $kontrak['tanggal_year']) {
                                                        $tahun = $kontrak['tanggal_year'];
                                                        if(!in_array($tahun, $tahunList)) {
                                                            $tahunList[] = $tahun;
                                                        }
                                                    }
                                                }
                                            }
                                            rsort($tahunList);
                                        @endphp
                                        @foreach($tahunList as $tahun)
                                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-end">
                                    <button id="btnResetFilter" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-refresh"></i> Reset Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-4">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $dashboardStats['target_sales'] }}</h4>
                                                <div>Pesanan Masuk</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-dollar-sign fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a id="btnLihatRincianKontrak" class="small text-white stretched-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#kontrakListModal">Lihat Rincian</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $dashboardStats['penjualan'] }}</h4>
                                                <div>Penjualan</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-cash-register fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a id="btnLihatRincianBappEksternal" class="small text-white stretched-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#bappEksternalListModal">Lihat Rincian</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card bg-info text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $dashboardStats['total_proyek'] }}</h4>
                                                <div>Jumlah Proyek</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-project-diagram fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="{{ route('kontrak.index') }}">Lihat Rincian</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Sebaran Proyek per Pelanggan
                                    </div>
                                    <div class="card-body">
                                        <div style="position:relative;min-height:220px;max-height:220px;display:flex;align-items:center;justify-content:center;">
                                            <canvas id="customerPieChart" width="100%" height="200" style="height:200px;width:100%;max-width:100%;"></canvas>
                                        </div>
                                        <div id="customerChartDesc" class="chart-desc">
                                            @if(isset($chartData['customer_pie_chart']))
                                                @php $allZero = array_sum($chartData['customer_pie_chart']['data']) == 0; @endphp
                                                @if($allZero)
                                                    <div class="text-center text-muted mt-2">Tidak ada data untuk divisualisasikan</div>
                                                @else
                                                    <ul class="mt-3" style="list-style:none;padding-left:0;">
                                                        @foreach($chartData['customer_pie_chart']['labels'] as $i => $label)
                                                            <li><strong>{{ $label }}:</strong> {{ $chartData['customer_pie_chart']['data'][$i] }} proyek</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Status Proyek
                                    </div>
                                    <div class="card-body">
                                        <div style="position:relative;min-height:220px;max-height:220px;display:flex;align-items:center;justify-content:center;">
                                            <canvas id="statusPieChart" width="100%" height="200" style="height:200px;width:100%;max-width:100%;"></canvas>
                                        </div>
                                        <div id="statusChartDesc" class="chart-desc">
                                            @if(isset($chartData['status_pie_chart']))
                                                @php $allZero = array_sum($chartData['status_pie_chart']['data']) == 0; @endphp
                                                @if($allZero)
                                                    <div class="text-center text-muted mt-2">Tidak ada data untuk divisualisasikan</div>
                                                @else
                                                    <ul class="mt-3" style="list-style:none;padding-left:0;">
                                                        @foreach($chartData['status_pie_chart']['labels'] as $i => $label)
                                                            <li><strong>{{ $label }}:</strong> {{ $chartData['status_pie_chart']['data'][$i] }} proyek</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4" style="margin-top:40px;">
                                    <div class="card-header">
                                        <i class="fas fa-table mr-1"></i>
                                        Ringkasan Data Proyek
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <input type="text" id="searchDashboard" class="form-control" placeholder="Cari proyek, SPPH, SPH, Negosiasi, Kontrak...">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode - Nama Proyek</th>
                                                        <th>SPPH</th>
                                                        <th>SPH</th>
                                                        <th>Negosiasi</th>
                                                        <th>Kontrak</th>
                                                        <th>BAPP INTERNAL</th>
                                                        <th>BAPP EKSTERNAL</th>
                                                        <th>Kemajuan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                        @foreach($projectData as $index => $project)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project['nama'] ?? '-' }}</td>
                            <td>{!! $project['spph'] !!}</td>
                            <td>{!! $project['sph'] !!}</td>
                            <td>{!! $project['nego'] !!}</td>
                            <td>{!! $project['kontrak'] !!}</td>
                            <td>{!! $project['bapp_internal'] !!}</td>
                            <td>{!! $project['bapp_eksternal'] !!}</td>
                            <td>
                                {!! \App\Http\Controllers\dashboardController::getProgressBar($project['progress'], null, $project['progress_class']) !!}
                                                </td>
                                            </tr>
                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
    <!-- Section lain (dataProyekSection, sphSection, negoSection, kontrakSection, filterDataSection) bisa ditambahkan di sini jika ingin tetap pakai JS switching -->
                                </div>
{{-- Tambahkan modal/card pop up info Proyek (umum untuk SPPH, SPH, Nego, Kontrak) --}}
<div class="modal fade" id="proyekInfoModal" tabindex="-1" role="dialog" aria-labelledby="proyekInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="proyekInfoModalLabel">Detail Proyek</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="proyekInfoContent">
        <!-- Konten info proyek akan diisi via JS -->
      </div>
    </div>
  </div>
                                </div>
<!-- Modal Hasil Negosiasi -->
<div class="modal fade" id="hasilNegoModal" tabindex="-1" aria-labelledby="hasilNegoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hasilNegoModalLabel">Detail Hasil Negosiasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="hasilNegoTableContainer">
        <!-- Tabel hasil negosiasi akan diisi via JS -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Detail BAPP INTERNAL -->
<div class="modal fade" id="bappInternalInfoModal" tabindex="-1" role="dialog" aria-labelledby="bappInternalInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bappInternalInfoModalLabel">Detail BAPP INTERNAL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bappInternalInfoContent">
        <!-- Konten info BAPP INTERNAL akan diisi via JS -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Detail BAPP EKSTERNAL -->
<div class="modal fade" id="bappEksternalInfoModal" tabindex="-1" role="dialog" aria-labelledby="bappEksternalInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bappEksternalInfoModalLabel">Detail BAPP EKSTERNAL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="bappEksternalInfoContent">
        <!-- Konten info BAPP EKSTERNAL akan diisi via JS -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Daftar Kontrak -->
<div class="modal fade" id="kontrakListModal" tabindex="-1" role="dialog" aria-labelledby="kontrakListModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="kontrakListModalLabel">Daftar Kontrak</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="modalKontrakTable" width="100%">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Kode - Nama Proyek</th>
                <th>Uraian</th>
                <th>Harga Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kontrakData as $i => $kontrak)
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $kontrak['nama_proyek'] ?? '-' }}</td>
                <td>{{ $kontrak['uraian'] ?? '-' }}</td>
                <td>Rp {{ isset($kontrak['nilai_harga_total']) ? number_format($kontrak['nilai_harga_total'],0,',','.') : '-' }}</td>
              </tr>
              @empty
              <tr><td colspan="4" class="text-center text-muted">Tidak ada data kontrak.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Daftar BAPP Eksternal -->
<div class="modal fade" id="bappEksternalListModal" tabindex="-1" role="dialog" aria-labelledby="bappEksternalListModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="bappEksternalListModalLabel">Daftar BAPP Eksternal</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="modalBappEksternalTable" width="100%">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nomor BAPP</th>
                <th>Nomor PO</th>
                <th>Tanggal PO</th>
                <th>Tanggal Terima</th>
                <th>Kode - Nama Proyek</th>
                <th>Harga Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($dashboardStats['bapp_eksternal_data'] as $i => $bapp)
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $bapp->nomor_bapp ?? '-' }}</td>
                <td>{{ $bapp->no_po ?? '-' }}</td>
                <td>{{ $bapp->tanggal_po ? \Carbon\Carbon::parse($bapp->tanggal_po)->format('d/m/Y') : '-' }}</td>
                <td>{{ $bapp->tanggal_terima ? \Carbon\Carbon::parse($bapp->tanggal_terima)->format('d/m/Y') : '-' }}</td>
                <td>
                    @php
                        $namaProyek = $bapp->nama_proyek ?? '';
                        // Jika nama_proyek mengandung format "Kode - Nama Proyek", tampilkan sesuai format
                        if (strpos($namaProyek, ' - ') !== false) {
                            echo $namaProyek;
                        } else {
                            // Jika tidak ada format kode, tampilkan nama proyek saja
                            echo $namaProyek ?: '-';
                        }
                    @endphp
                </td>
                <td>Rp {{ isset($bapp->harga_total) ? number_format($bapp->harga_total,0,',','.') : '-' }}</td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center text-muted">Tidak ada data BAPP eksternal.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="d-flex align-items-center justify-content-end small">
    <div class="text-muted">&copy; IT IMSS 2025</div>
</div>
@endsection

@push('scripts')
<!-- DataTables CSS dan JS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
// Animasi angka dinamis
function animateNumber(el, start, end, duration, prefix = '', suffix = '') {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = Math.floor(progress * (end - start) + start);
        el.textContent = prefix + value.toLocaleString('id-ID') + suffix;
        if (progress < 1) {
            window.requestAnimationFrame(step);
        } else {
            el.textContent = prefix + end.toLocaleString('id-ID') + suffix;
        }
    };
    window.requestAnimationFrame(step);
}
// Animasi progress bar
function animateProgressBar(bar, target) {
    let width = 0;
    const step = () => {
        width += Math.max(1, Math.ceil(target/30));
        if (width > target) width = target;
        bar.style.width = width + '%';
        bar.textContent = width + '%';
        if (width < target) {
            setTimeout(step, 12);
        } else {
            bar.style.width = target + '%';
            bar.textContent = target + '%';
        }
    };
    bar.style.width = '0%';
    bar.textContent = '0%';
    step();
}

// Data dashboard untuk filter
let dashboardData = {
    projectData: @json($projectData),
    dashboardStats: @json($dashboardStats),
    chartData: @json($chartData),
    kontrakData: @json($kontrakData ?? [])
};

// Filter tahun functionality
function filterDashboardByYear(selectedYear) {
    console.log('Filtering by year:', selectedYear);
    
    if (!selectedYear) {
        // Reset ke data asli
        updateDashboardVisualizations(dashboardData);
        return;
    }

    // Filter data berdasarkan tahun
    let filteredData = {
        projectData: [],
        dashboardStats: {
            target_sales: 0,
            penjualan: 0,
            total_proyek: 0,
            bapp_eksternal_data: []
        },
        chartData: {
            customer_pie_chart: { labels: [], data: [], colors: [] },
            status_pie_chart: { labels: [], data: [], colors: [] }
        },
        kontrakData: []
    };

    // Filter project data
    dashboardData.projectData.forEach(project => {
        let includeProject = false;
        
        // Cek apakah ada data dengan tahun yang dipilih
        if (project.tanggal_spph && project.tanggal_spph == selectedYear) includeProject = true;
        if (project.tanggal_sph && project.tanggal_sph == selectedYear) includeProject = true;
        if (project.tanggal_kontrak && project.tanggal_kontrak == selectedYear) includeProject = true;
        
        if (includeProject) {
            filteredData.projectData.push(project);
        }
    });

    // Filter BAPP eksternal data
    if (dashboardData.dashboardStats.bapp_eksternal_data) {
        dashboardData.dashboardStats.bapp_eksternal_data.forEach(bapp => {
            let includeBapp = false;
            
            if (bapp.tanggal_po && bapp.tanggal_po.includes(selectedYear)) includeBapp = true;
            if (bapp.tanggal_terima && bapp.tanggal_terima.includes(selectedYear)) includeBapp = true;
            
            if (includeBapp) {
                filteredData.dashboardStats.bapp_eksternal_data.push(bapp);
            }
        });
    }

    // Filter kontrak data
    if (dashboardData.kontrakData) {
        dashboardData.kontrakData.forEach(kontrak => {
            if (kontrak.tanggal_year && kontrak.tanggal_year == selectedYear) {
                filteredData.kontrakData.push(kontrak);
            }
        });
    }

    // Hitung ulang statistik
    let targetSales = 0;
    let penjualan = 0;
    let jumlahProyek = 0;
    
    // Hitung jumlah proyek berdasarkan checklist kontrak
    filteredData.projectData.forEach(project => {
        if (project.kontrak && project.kontrak !== '-') {
            jumlahProyek++;
        }
    });
    
    filteredData.kontrakData.forEach(kontrak => {
        targetSales += parseInt(kontrak.nilai_harga_total || 0);
    });
    
    if (filteredData.dashboardStats.bapp_eksternal_data) {
        filteredData.dashboardStats.bapp_eksternal_data.forEach(bapp => {
            penjualan += parseInt(bapp.harga_total || 0);
        });
    }

    filteredData.dashboardStats.target_sales = 'Rp ' + targetSales.toLocaleString('id-ID');
    filteredData.dashboardStats.penjualan = 'Rp ' + penjualan.toLocaleString('id-ID');
    filteredData.dashboardStats.total_proyek = jumlahProyek;

    // Update chart data berdasarkan data yang difilter
    updateChartData(filteredData);

    // Update visualisasi
    updateDashboardVisualizations(filteredData);
}

function updateChartData(filteredData) {
    // Update customer pie chart berdasarkan subkontraktor dari kontrak
    let customerCount = {};
    if (filteredData.kontrakData && filteredData.kontrakData.length > 0) {
        filteredData.kontrakData.forEach(kontrak => {
            let customer = kontrak.subkontraktor || 'Unknown';
            customerCount[customer] = (customerCount[customer] || 0) + 1;
        });
    } else {
        // Fallback ke project data jika tidak ada kontrak data
        filteredData.projectData.forEach(project => {
            let customer = project.nama ? project.nama.split(' - ')[0] : 'Unknown';
            customerCount[customer] = (customerCount[customer] || 0) + 1;
        });
    }

    // Update chart data dengan deskripsi yang benar
    filteredData.chartData.customer_pie_chart = {
        labels: Object.keys(customerCount),
        data: Object.values(customerCount),
        colors: [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
        ].slice(0, Object.keys(customerCount).length)
    };

    // Update status pie chart berdasarkan progress dari project data dengan format yang diminta
    let statusCount = {};
    let progressMap = {
        0: '0% (SPPH)',
        25: '25% (SPH)',
        50: '50% (Negosiasi)',
        75: '75% (Kontrak)',
        85: '85% (BAPP Internal)',
        100: '100% (BAPP Eksternal)'
    };
    
    filteredData.projectData.forEach(project => {
        // Hitung progress berdasarkan checklist yang ada
        let progress = 0;
        if (project.sph && project.sph !== '-') progress += 25;
        if (project.nego && project.nego !== '-') progress += 25;
        if (project.kontrak && project.kontrak !== '-') progress += 25;
        if (project.bapp_internal && project.bapp_internal !== '-') progress += 10;
        if (project.bapp_eksternal && project.bapp_eksternal !== '-') progress += 15;
        
        // Gunakan format label yang sama dengan controller
        let statusLabel = progressMap[progress] || '0% (SPPH)';
        statusCount[statusLabel] = (statusCount[statusLabel] || 0) + 1;
    });

    // Update chart data dengan deskripsi yang benar dan memastikan semua status muncul
    let statusLabels = [];
    let statusData = [];
    
    // Pastikan semua status muncul dalam urutan yang benar
    Object.keys(progressMap).forEach(progress => {
        let label = progressMap[progress];
        statusLabels.push(label);
        statusData.push(statusCount[label] || 0);
    });
    
    filteredData.chartData.status_pie_chart = {
        labels: statusLabels,
        data: statusData,
        colors: [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
        ].slice(0, statusLabels.length)
    };
}

function updateDashboardVisualizations(data) {
    // Update card statistik
    let pesananEl = $(".card.bg-primary h4").get(0);
    let penjualanEl = $(".card.bg-success h4").get(0);
    let proyekEl = $(".card.bg-info h4").get(0);

    if (pesananEl) {
        let targetSales = parseInt(data.dashboardStats.target_sales.replace(/[^\d]/g, ''));
        animateNumber(pesananEl, 0, targetSales, 1200, 'Rp ');
    }
    if (penjualanEl) {
        let penjualan = parseInt(data.dashboardStats.penjualan.replace(/[^\d]/g, ''));
        animateNumber(penjualanEl, 0, penjualan, 1200, 'Rp ');
    }
    if (proyekEl) {
        animateNumber(proyekEl, 0, data.dashboardStats.total_proyek, 1200);
    }

    // Update tabel data proyek dengan perhitungan progress yang benar
    let tableBody = $('#dataTable tbody');
    if (tableBody.length > 0) {
        tableBody.empty();
        
        data.projectData.forEach((project, index) => {
            // Hitung progress berdasarkan checklist yang ada
            let progress = 0;
            if (project.sph && project.sph !== '-') progress += 25;
            if (project.nego && project.nego !== '-') progress += 25;
            if (project.kontrak && project.kontrak !== '-') progress += 25;
            if (project.bapp_internal && project.bapp_internal !== '-') progress += 10;
            if (project.bapp_eksternal && project.bapp_eksternal !== '-') progress += 15;
            
            // Tentukan progress class berdasarkan progress
            let progressClass = 'bg-danger';
            if (progress >= 100) progressClass = 'bg-success';
            else if (progress >= 75) progressClass = 'bg-orange';
            else if (progress >= 50) progressClass = 'bg-warning';
            else if (progress >= 25) progressClass = 'bg-primary';
            
            // Buat progress bar HTML
            let progressBar = `
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar ${progressClass}" role="progressbar" 
                         style="width: ${progress}%;" 
                         aria-valuenow="${progress}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                        ${progress}%
                    </div>
                </div>
            `;
            
            let row = '<tr>';
            row += '<td>' + (index + 1) + '</td>';
            row += '<td>' + (project.nama || '-') + '</td>';
            row += '<td>' + (project.spph || '-') + '</td>';
            row += '<td>' + (project.sph || '-') + '</td>';
            row += '<td>' + (project.nego || '-') + '</td>';
            row += '<td>' + (project.kontrak || '-') + '</td>';
            row += '<td>' + (project.bapp_internal || '-') + '</td>';
            row += '<td>' + (project.bapp_eksternal || '-') + '</td>';
            row += '<td>' + progressBar + '</td>';
            row += '</tr>';
            tableBody.append(row);
        });
        
        // Animate progress bars setelah tabel diupdate
        setTimeout(function() {
            $('#dataTable .progress-bar').each(function() {
                var bar = this;
                var target = parseInt(bar.getAttribute('aria-valuenow')) || 0;
                animateProgressBar(bar, target);
            });
        }, 100);
    }

    // Update charts dengan error handling dan deskripsi yang benar
    try {
        if (window.dashboardController && typeof window.dashboardController.setChartData === 'function') {
            // Update chart data dengan deskripsi yang benar
            let updatedChartData = {
                customer_pie_chart: data.chartData.customer_pie_chart,
                status_pie_chart: data.chartData.status_pie_chart
            };
            
            window.dashboardController.setChartData(updatedChartData);
            
            if (typeof window.dashboardController.initializeCharts === 'function') {
                window.dashboardController.initializeCharts();
            }
            
            // Update deskripsi chart jika ada
            updateChartDescriptions(data);
        }
    } catch (error) {
        console.log('Chart update error:', error);
    }

    // Update modal data
    updateModalData(data);
}

function updateChartDescriptions(data) {
    // Update deskripsi pie chart customer
    let customerChartDesc = $('#customerChartDesc');
    if (customerChartDesc.length > 0) {
        let totalProjects = data.chartData.customer_pie_chart.data.reduce((a, b) => a + b, 0);
        let uniqueCustomers = data.chartData.customer_pie_chart.labels.length;
        
        if (totalProjects === 0) {
            customerChartDesc.html('<div class="text-center text-muted mt-2">Tidak ada data untuk divisualisasikan</div>');
        } else {
            let descHtml = '<ul class="mt-3" style="list-style:none;padding-left:0;">';
            data.chartData.customer_pie_chart.labels.forEach((label, index) => {
                descHtml += `<li><strong>${label}:</strong> ${data.chartData.customer_pie_chart.data[index]} proyek</li>`;
            });
            descHtml += '</ul>';
            customerChartDesc.html(descHtml);
        }
    }
    
    // Update deskripsi pie chart status dengan format yang diminta
    let statusChartDesc = $('#statusChartDesc');
    if (statusChartDesc.length > 0) {
        let totalProjects = data.chartData.status_pie_chart.data.reduce((a, b) => a + b, 0);
        
        if (totalProjects === 0) {
            statusChartDesc.html('<div class="text-center text-muted mt-2">Tidak ada data untuk divisualisasikan</div>');
        } else {
            let descHtml = '<ul class="mt-3" style="list-style:none;padding-left:0;">';
            data.chartData.status_pie_chart.labels.forEach((label, index) => {
                descHtml += `<li><strong>${label}:</strong> ${data.chartData.status_pie_chart.data[index]} proyek</li>`;
            });
            descHtml += '</ul>';
            statusChartDesc.html(descHtml);
        }
    }
}

function updateModalData(data) {
    // Update modal kontrak
    let kontrakTableBody = $('#modalKontrakTable tbody');
    if (kontrakTableBody.length > 0) {
        kontrakTableBody.empty();
        
        data.kontrakData.forEach((kontrak, index) => {
            let row = '<tr>';
            row += '<td>' + (index + 1) + '</td>';
            row += '<td>' + (kontrak.nama_proyek || '-') + '</td>';
            row += '<td>' + (kontrak.uraian || '-') + '</td>';
            row += '<td>Rp ' + (kontrak.nilai_harga_total ? parseInt(kontrak.nilai_harga_total).toLocaleString('id-ID') : '-') + '</td>';
            row += '</tr>';
            kontrakTableBody.append(row);
        });
    }

    // Update modal BAPP eksternal
    let bappTableBody = $('#modalBappEksternalTable tbody');
    if (bappTableBody.length > 0) {
        bappTableBody.empty();
        
        if (data.dashboardStats.bapp_eksternal_data) {
            data.dashboardStats.bapp_eksternal_data.forEach((bapp, index) => {
                let row = '<tr>';
                row += '<td>' + (index + 1) + '</td>';
                row += '<td>' + (bapp.nomor_bapp || '-') + '</td>';
                row += '<td>' + (bapp.no_po || '-') + '</td>';
                row += '<td>' + (bapp.tanggal_po ? new Date(bapp.tanggal_po).toLocaleDateString('id-ID') : '-') + '</td>';
                row += '<td>' + (bapp.tanggal_terima ? new Date(bapp.tanggal_terima).toLocaleDateString('id-ID') : '-') + '</td>';
                row += '<td>' + (bapp.nama_proyek || '-') + '</td>';
                row += '<td>Rp ' + (bapp.harga_total ? parseInt(bapp.harga_total).toLocaleString('id-ID') : '-') + '</td>';
                row += '</tr>';
                bappTableBody.append(row);
            });
        }
    }
}

$(document).ready(function() {
    // Card animasi angka
    var pesananMasuk = {{ (int)str_replace(['Rp', '.', ' '], '', $dashboardStats['target_sales']) }};
    var jumlahProyek = {{ (int)$dashboardStats['total_proyek'] }};
    var pesananEl = $(".card.bg-primary h4").get(0);
    var proyekEl = $(".card.bg-info h4").get(0);
    if (pesananEl) animateNumber(pesananEl, 0, pesananMasuk, 1200, 'Rp ');
    if (proyekEl) animateNumber(proyekEl, 0, jumlahProyek, 1200);
    // Progress bar animasi
    function animateAllProgressBars() {
        $('#dataTable .progress-bar').each(function() {
            var bar = this;
            var target = parseInt(bar.textContent) || 0;
            animateProgressBar(bar, target);
        });
    }
    animateAllProgressBars();
    // Ulangi animasi progress bar saat DataTable di-draw ulang
    $('#dataTable').on('draw.dt', function() {
        animateAllProgressBars();
    });

    // Filter tahun event handler
    $('#filterTahunDashboard').on('change', function() {
        var selectedYear = $(this).val();
        filterDashboardByYear(selectedYear);
    });

    // Reset filter event handler
    $('#btnResetFilter').on('click', function() {
        $('#filterTahunDashboard').val('');
        filterDashboardByYear('');
    });
});
</script>
        <script>
let chartData = @json($chartData);
// Pastikan chartData ada sebelum digunakan
if (!chartData) {
    chartData = {
        customer_pie_chart: {
            labels: [],
            data: [],
            colors: []
        },
        status_pie_chart: {
            labels: [],
            data: [],
            colors: []
        }
    };
}
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.dashboardController !== 'undefined') {
        window.dashboardController.setChartData(chartData);
        window.dashboardController.initializeCharts();
    }
    // Pencarian manual untuk tabel utama
    var searchInput = document.getElementById('searchDashboard');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            var value = this.value.toLowerCase();
            var table = document.getElementById('dataTable');
            var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var text = row.textContent.toLowerCase();
                if (text.indexOf(value) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }
    // Pencarian manual untuk modal kontrak
    var kontrakSearch = document.getElementById('modalKontrakTable');
    if (kontrakSearch) {
        // Tidak ada search bar, tapi bisa ditambah jika perlu
    }
    // Pencarian manual untuk modal BAPP Eksternal
    var bappEksternalTable = document.getElementById('modalBappEksternalTable');
    if (bappEksternalTable) {
        // Tidak ada search bar, tapi bisa ditambah jika perlu
    }
    // Checklist hasil nego (modal)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-detail-hasil-nego') || e.target.closest('.btn-detail-hasil-nego')) {
            e.preventDefault();
            try {
                var button = e.target.classList.contains('btn-detail-hasil-nego') ? e.target : e.target.closest('.btn-detail-hasil-nego');
                var namaProyek = button.getAttribute('data-nama-proyek');
                var hasilNegoTableContainer = document.getElementById('hasilNegoTableContainer');
                if (hasilNegoTableContainer) hasilNegoTableContainer.innerHTML = '<div class="text-center">Memuat data...</div>';
                
                function formatRupiah(angka) {
                    if (!angka || isNaN(angka)) return '-';
                    var number_string = angka.toString().replace(/[^\d]/g, ''),
                        sisa = number_string.length % 3,
                        rupiah = number_string.substr(0, sisa),
                        ribuan = number_string.substr(sisa).match(/\d{3}/g);
                    if (ribuan) {
                        rupiah += (sisa ? '.' : '') + ribuan.join('.');
                    }
                    return 'Rp. ' + rupiah;
                }
                
                fetch('/nego/detail-by-project?nama_proyek=' + encodeURIComponent(namaProyek))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(res => {
                        var data = res.data.filter(function(item) { return item.tipe === 'hasil'; });
                        var html = '';
                        if(data.length > 0) {
                            html += '<div class="table-responsive"><table class="table table-bordered">';
                            html += '<thead><tr><th>No</th><th>Nomor Negosiasi</th><th>Pelanggan</th><th>Tanggal</th><th>Harga Total</th></tr></thead><tbody>';
                            data.forEach(function(item, idx) {
                                html += '<tr>';
                                html += '<td>' + (idx + 1) + '</td>';
                                html += '<td>' + (item.nomor_nego ?? '-') + '</td>';
                                html += '<td>' + (item.subkontraktor ?? '-') + '</td>';
                                html += '<td>' + (item.tanggal ? new Date(item.tanggal).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-') + '</td>';
                                html += '<td>' + (item.harga_total ? formatRupiah(item.harga_total) : '-') + '</td>';
                                html += '</tr>';
                            });
                            html += '</tbody></table></div>';
                        } else {
                            html = '<div class="alert alert-warning">Tidak ada data hasil negosiasi untuk proyek ini.</div>';
                        }
                        if (hasilNegoTableContainer) hasilNegoTableContainer.innerHTML = html;
                        var hasilNegoModal = new bootstrap.Modal(document.getElementById('hasilNegoModal'));
                        hasilNegoModal.show();
                    })
                    .catch(error => {
                        console.log('Error fetching nego data:', error);
                        if (hasilNegoTableContainer) {
                            hasilNegoTableContainer.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat memuat data.</div>';
                        }
                    });
            } catch (error) {
                console.log('Nego button click error:', error);
            }
        }
    });

    $(document).on('click', '.btn-mark-read', function() {
        var btn = $(this);
        var id = btn.data('id');
        if(btn.prop('disabled')) return;
        
        try {
            $.post({
                url: '/notification/read/' + id,
                data: {_token: '{{ csrf_token() }}'},
                success: function(res) {
                    if(res.success) {
                        btn.prop('disabled', true).text('Sudah Dibaca');
                        // Update badge
                        var badge = $('#notifDropdown .badge');
                        var count = parseInt(badge.text()) || 0;
                        if(count > 1) badge.text(count-1);
                        else badge.remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Notification read error:', error);
                }
            });
        } catch (error) {
            console.log('Notification click error:', error);
        }
    });
            });
        </script>
<script>
$(document).ready(function() {
  // Inisialisasi DataTable untuk modal kontrak
  if ($.fn.DataTable) {
    $('#modalKontrakTable').DataTable({
      "language": {
        "decimal":        "",
        "emptyTable":    "Tidak ada data yang tersedia",
        "info":          "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        "infoEmpty":     "Menampilkan 0 sampai 0 dari 0 entri",
        "infoFiltered":  "(difilter dari _MAX_ total entri)",
        "infoPostFix":   "",
        "thousands":     ",",
        "lengthMenu":    "Tampilkan _MENU_ entri",
        "loadingRecords": "Memuat...",
        "processing":    "Memproses...",
        "search":        "Cari:",
        "zeroRecords":   "Tidak ditemukan data yang sesuai",
        "paginate": {
          "first":      "Pertama",
          "last":       "Terakhir",
          "next":       "Selanjutnya",
          "previous":   "Sebelumnya"
        },
        "aria": {
          "sortAscending":  ": aktifkan untuk mengurutkan kolom naik",
          "sortDescending": ": aktifkan untuk mengurutkan kolom turun"
        }
      },
      "pageLength": 10,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
      "order": [[0, "asc"]],
      "responsive": true,
      dom: 'rtip'
    });
  }
  
  // Inisialisasi DataTable untuk modal BAPP Eksternal
  if ($.fn.DataTable) {
    $('#modalBappEksternalTable').DataTable({
      "language": {
        "decimal":        "",
        "emptyTable":    "Tidak ada data yang tersedia",
        "info":          "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        "infoEmpty":     "Menampilkan 0 sampai 0 dari 0 entri",
        "infoFiltered":  "(difilter dari _MAX_ total entri)",
        "infoPostFix":   "",
        "thousands":     ",",
        "lengthMenu":    "Tampilkan _MENU_ entri",
        "loadingRecords": "Memuat...",
        "processing":    "Memproses...",
        "search":        "Cari:",
        "zeroRecords":   "Tidak ditemukan data yang sesuai",
        "paginate": {
          "first":      "Pertama",
          "last":       "Terakhir",
          "next":       "Selanjutnya",
          "previous":   "Sebelumnya"
        },
        "aria": {
          "sortAscending":  ": aktifkan untuk mengurutkan kolom naik",
          "sortDescending": ": aktifkan untuk mengurutkan kolom turun"
        }
      },
      "pageLength": 10,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
      "order": [[0, "asc"]],
      "responsive": true,
      dom: 'rtip'
    });
  }
  
  // Event handler untuk modal kontrak
  $('#btnLihatRincianKontrak').on('click', function(e) {
    e.preventDefault();
    var kontrakModal = new bootstrap.Modal(document.getElementById('kontrakListModal'));
    kontrakModal.show();
  });
  
  // Event handler untuk modal BAPP Eksternal
  $('#btnLihatRincianBappEksternal').on('click', function(e) {
    e.preventDefault();
    var bappModal = new bootstrap.Modal(document.getElementById('bappEksternalListModal'));
    bappModal.show();
  });
  
  // Event handler untuk modal yang sudah ditampilkan - dengan pengecekan yang lebih aman
  $('#kontrakListModal').on('shown.bs.modal', function () {
    try {
      if ($.fn.DataTable && $.fn.DataTable.isDataTable('#modalKontrakTable')) {
        var table = $('#modalKontrakTable').DataTable();
        if (table && typeof table.columns === 'function' && typeof table.columns().adjust === 'function') {
          table.columns.adjust();
        }
        if (table && typeof table.responsive === 'object' && typeof table.responsive.recalc === 'function') {
          table.responsive.recalc();
        }
      }
    } catch (error) {
      console.log('DataTable adjustment error:', error);
    }
  });
  
  $('#bappEksternalListModal').on('shown.bs.modal', function () {
    try {
      if ($.fn.DataTable && $.fn.DataTable.isDataTable('#modalBappEksternalTable')) {
        var table = $('#modalBappEksternalTable').DataTable();
        if (table && typeof table.columns === 'function' && typeof table.columns().adjust === 'function') {
          table.columns.adjust();
        }
        if (table && typeof table.responsive === 'object' && typeof table.responsive.recalc === 'function') {
          table.responsive.recalc();
        }
      }
    } catch (error) {
      console.log('DataTable adjustment error:', error);
    }
  });
});
</script>
@endpush

@push('styles')
<style>
.bg-orange { background-color: #fd7e14 !important; color: #fff; }
.bg-danger { background-color: #dc3545 !important; color: #fff; }
.bg-warning { background-color: #ffe066 !important; color: #000; }
.progress-bar.bg-danger {
    color: #000 !important;
    font-weight: bold;
}
</style>
@endpush