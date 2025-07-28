@extends('layouts.app')

@section('title', 'Dasbor Pemantauan Proyek | Dashboard')

@section('content')
                    <div class="container-fluid">
                        <div class="d-flex justify-content-end align-items-center mb-2">
                            <div class="dropdown">
                                <button class="btn btn-light position-relative dropdown-toggle" type="button" id="notifDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#000;">
                                    <i class="fas fa-bell fa-lg" style="color:#000;"></i>
                                    @if(isset($unreadCount) && $unreadCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unreadCount }}</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notifDropdown" style="min-width:320px;max-width:400px;">
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
                                        <a id="btnLihatRincianKontrak" class="small text-white stretched-link" href="javascript:void(0)" data-toggle="modal" data-target="#kontrakListModal">Lihat Rincian</a>
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
                                        <a id="btnLihatRincianBappEksternal" class="small text-white stretched-link" href="javascript:void(0)" data-toggle="modal" data-target="#bappEksternalListModal">Lihat Rincian</a>
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
                                        @if(isset($chartData['customer_pie_chart']))
                                            @php $allZero = array_sum($chartData['customer_pie_chart']['data']) == 0; @endphp
                                            <div class="chart-desc">
                                                @if($allZero)
                                                    <div class="text-center text-muted mt-2">Tidak ada data untuk divisualisasikan</div>
                                                @else
                                                    <ul class="mt-3" style="list-style:none;padding-left:0;">
                                                        @foreach($chartData['customer_pie_chart']['labels'] as $i => $label)
                                                            <li><strong>{{ $label }}:</strong> {{ $chartData['customer_pie_chart']['data'][$i] }} proyek</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endif
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
                                        @if(isset($chartData['status_pie_chart']))
                                            @php $allZero = array_sum($chartData['status_pie_chart']['data']) == 0; @endphp
                                            <div class="chart-desc">
                                                @if($allZero)
                                                    <div class="text-center text-muted mt-2">Tidak ada data untuk divisualisasikan</div>
                                                @else
                                                    <ul class="mt-3" style="list-style:none;padding-left:0;">
                                                        @foreach($chartData['status_pie_chart']['labels'] as $i => $label)
                                                            <li><strong>{{ $label }}:</strong> {{ $chartData['status_pie_chart']['data'][$i] }} proyek</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endif
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
                            <td>{{ $project['kode'] ?? '' }} - {{ $project['nama'] ?? '' }}</td>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
                <td>{{ $bapp->nama_proyek ?? '-' }}</td>
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
$(document).ready(function() {
    if (typeof window.dashboardController !== 'undefined') {
        window.dashboardController.setChartData(chartData);
        window.dashboardController.initializeCharts();
    }
    var table = $('#dataTable').DataTable({
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
        dom: 'rtip' // hilangkan search bar default
    });
    $('#searchDashboard').on('keyup', function() {
        table.search(this.value).draw();
    });

    // PIE CHART CUSTOMER
    // Hapus seluruh blok PIE CHART CUSTOMER di bawah $(document).ready jika sudah ada inisialisasi Chart.js di dashboard-controller.js.
    // Event pop up info proyek (umum untuk spph, sph, nego, kontrak)
    $(document).on('click', '.proyek-check', function(e) {
        e.preventDefault();
        var data = $(this).data('info');
        if (typeof data === 'string') data = JSON.parse(data);
        var tipe = $(this).data('tipe');
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
        var html = '<div class="table-responsive"><table class="table table-bordered">';
        html += '<thead><tr>';
        if (tipe === 'spph') {
                                html += '<th>Nomor SPPH</th><th>Pelanggan</th><th>Tanggal</th><th>Batas Akhir SPH</th><th>Uraian</th>';
        } else if (tipe === 'sph') {
            html += '<th>Nomor SPH</th><th>Pelanggan</th><th>Tanggal</th><th>Uraian</th><th>Harga Total</th>';
        } else if (tipe === 'nego') {
            html += '<th>Nomor Nego</th><th>Pelanggan</th><th>Tanggal</th><th>Uraian</th><th>Harga Total</th>';
        } else if (tipe === 'kontrak') {
            html += '<th>Nomor Kontrak</th><th>Pelanggan</th><th>Tanggal</th><th>Batas Akhir Kontrak</th><th>Uraian</th><th>Harga Total</th>';
        }
        html += '</tr></thead><tbody><tr>';
        if (tipe === 'spph') {
            html += '<td>' + (data.no_spph || '-') + '</td>';
            html += '<td>' + (data.subkontraktor || '-') + '</td>';
            html += '<td>' + (data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-') + '</td>';
            html += '<td>' + (data.batas_akhir ? new Date(data.batas_akhir).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
        } else if (tipe === 'sph') {
            html += '<td>' + (data.no_sph || '-') + '</td>';
            html += '<td>' + (data.subkontraktor || '-') + '</td>';
            html += '<td>' + (data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        } else if (tipe === 'nego') {
            html += '<td>' + (data.no_nego || '-') + '</td>';
            html += '<td>' + (data.subkontraktor || '-') + '</td>';
            html += '<td>' + (data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        } else if (tipe === 'kontrak') {
            html += '<td>' + (data.no_kontrak || '-') + '</td>';
            html += '<td>' + (data.subkontraktor || '-') + '</td>';
            html += '<td>' + (data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-') + '</td>';
            html += '<td>' + (data.batas_akhir ? new Date(data.batas_akhir).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'}) : '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        }
        html += '</tr></tbody></table></div>';
        $('#proyekInfoContent').html(html);
        $('#proyekInfoModal').modal('show');
        return false;
    });

    $(document).on('click', '.btn-detail-hasil-nego', function(e) {
        e.preventDefault();
        var namaProyek = $(this).data('nama-proyek');
        $('#hasilNegoTableContainer').html('<div class="text-center">Memuat data...</div>');
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
        $.get('/admin/nego/detail-by-project', { nama_proyek: namaProyek }, function(res) {
            var data = res.data.filter(function(item) { return item.tipe === 'hasil'; });
            if(data.length > 0) {
                var html = '<div class="table-responsive"><table class="table table-bordered">';
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
                $('#hasilNegoTableContainer').html(html);
            } else {
                $('#hasilNegoTableContainer').html('<div class="alert alert-warning">Tidak ada data hasil negosiasi untuk proyek ini.</div>');
            }
            $('#hasilNegoModal').modal('show');
        });
    });

    $(document).on('click', '.btn-mark-read', function() {
        var btn = $(this);
        var id = btn.data('id');
        if(btn.prop('disabled')) return;
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
            }
        });
    });
            });
        </script>
<script>
$(document).ready(function() {
  // Inisialisasi DataTable
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
  // Buka modal secara manual jika ada masalah event
  $('#btnLihatRincianKontrak').on('click', function(e) {
    e.preventDefault();
    $('#kontrakListModal').modal('show');
  });
  $('#kontrakListModal').on('shown.bs.modal', function () {
    $('#modalKontrakTable').DataTable().columns.adjust().responsive.recalc();
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