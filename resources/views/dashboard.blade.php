@extends('layouts.app')

@section('content')
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dasbor Pemantauan Proyek</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $dashboardStats['target_sales'] }}</h4>
                                                <div>Target Penjualan</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-dollar-sign fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" onclick="showDataProyekSection()">Lihat Rincian</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $dashboardStats['target_pemasaran'] }}</h4>
                                                <div>Target Pemasaran</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-bullhorn fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" onclick="showDataProyekSection()">Lihat Rincian</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
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
                                        <canvas id="customerPieChart" width="100%" height="40"></canvas>
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
                                        <div class="chart-area">
                                            <canvas id="statusPieChart" width="100%" height="200"></canvas>
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
                                                        <th>Nama Proyek</th>
                                                        <th>SPPH</th>
                                                        <th>SPH</th>
                                                        <th>Negosiasi</th>
                                                        <th>Kontrak</th>
                                                        <th>Kemajuan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                        @foreach($projectData as $index => $project)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project['nama'] }}</td>
                            <td>{!! $project['spph'] !!}</td>
                            <td>{!! $project['sph'] !!}</td>
                            <td>{!! $project['nego'] !!}</td>
                            <td>{!! $project['kontrak'] !!}</td>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script>
let chartData = @json($chartData);
// Data dummy jika chartData kosong/null
if (!chartData || !chartData.customer_pie_chart || !chartData.status_pie_chart) {
    chartData = {
        customer_pie_chart: {
            labels: ['Pelanggan A', 'Pelanggan B', 'Pelanggan C'],
            data: [5, 3, 4],
            colors: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)'
            ]
        },
        status_pie_chart: {
            labels: ['Berjalan', 'Selesai', 'Menunggu', 'Ditolak'],
            data: [6, 2, 3, 1],
            colors: [
                'rgba(40, 167, 69, 0.8)',
                'rgba(108, 117, 125, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ]
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
    if (chartData && chartData.customer_pie_chart) {
        var ctxCustomer = document.getElementById('customerPieChart').getContext('2d');
        new Chart(ctxCustomer, {
            type: 'pie',
            data: {
                labels: chartData.customer_pie_chart.labels,
                datasets: [{
                    data: chartData.customer_pie_chart.data,
                    backgroundColor: chartData.customer_pie_chart.colors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            const dataset = data.datasets[tooltipItem.datasetIndex];
                            const total = dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((dataset.data[tooltipItem.index] / total) * 100).toFixed(1);
                            return data.labels[tooltipItem.index] + ': ' + dataset.data[tooltipItem.index] + ' proyek (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    }
    // PIE CHART STATUS
    if (chartData && chartData.status_pie_chart) {
        var ctxStatus = document.getElementById('statusPieChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: chartData.status_pie_chart.labels,
                datasets: [{
                    data: chartData.status_pie_chart.data,
                    backgroundColor: chartData.status_pie_chart.colors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            const dataset = data.datasets[tooltipItem.datasetIndex];
                            const total = dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((dataset.data[tooltipItem.index] / total) * 100).toFixed(1);
                            return data.labels[tooltipItem.index] + ': ' + dataset.data[tooltipItem.index] + ' proyek (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    }
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
            html += '<th>Nomor SPPH</th><th>Tanggal</th><th>Batas Akhir SPH</th><th>Uraian</th>';
        } else if (tipe === 'sph') {
            html += '<th>Nomor SPH</th><th>Tanggal</th><th>Uraian</th><th>Harga Total</th>';
        } else if (tipe === 'nego') {
            html += '<th>Nomor Nego</th><th>Tanggal</th><th>Uraian</th><th>Harga Total</th>';
        } else if (tipe === 'kontrak') {
            html += '<th>Nomor Kontrak</th><th>Tanggal</th><th>Uraian</th><th>Harga Total</th>';
        }
        html += '</tr></thead><tbody><tr>';
        if (tipe === 'spph') {
            html += '<td>' + (data.no_spph || '-') + '</td>';
            html += '<td>' + (data.tanggal || '-') + '</td>';
            html += '<td>' + (data.batas_akhir || '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
        } else if (tipe === 'sph') {
            html += '<td>' + (data.no_sph || '-') + '</td>';
            html += '<td>' + (data.tanggal || '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        } else if (tipe === 'nego') {
            html += '<td>' + (data.no_nego || '-') + '</td>';
            html += '<td>' + (data.tanggal || '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        } else if (tipe === 'kontrak') {
            html += '<td>' + (data.no_kontrak || '-') + '</td>';
            html += '<td>' + (data.tanggal || '-') + '</td>';
            html += '<td>' + (data.uraian || '-') + '</td>';
            html += '<td>' + (data.harga_total ? formatRupiah(data.harga_total) : '-') + '</td>';
        }
        html += '</tr></tbody></table></div>';
        $('#proyekInfoContent').html(html);
        $('#proyekInfoModal').modal('show');
        return false;
    });
            });
        </script>
@endpush