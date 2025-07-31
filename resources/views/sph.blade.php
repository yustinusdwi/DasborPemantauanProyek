@extends('layouts.app')
<link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />

@section('title', 'MarkLens | SPH')

@section('content')
<style>
@media (min-width: 992px) {
  #layoutSidenav #layoutSidenav_content {
    margin-left: 225px !important;
  }
  .container-fluid {
    padding-left: 240px !important;
  }
}
</style>
<div class="container-fluid">
    <ol class="breadcrumb mb-4" style=margin-top:57px;">
        <li class="breadcrumb-item active">Surat Penawaran Harga (SPH)</li>
    </ol>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white" style="border-radius: 10px 10px 0 0; font-weight: 600; border-bottom: 2px solid #000;">
                    <i class="fas fa-table mr-1"></i>
                    Data Seluruh SPH Saat Ini
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="searchSph" class="form-control" placeholder="Cari SPH, Nama Pekerjaan, Berkas, dll...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <select id="filterTahunSph" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @php
                                        $tahunList = [];
                                        foreach($sphData as $sph) {
                                            if($sph['tanggal']) {
                                                $tahun = \Carbon\Carbon::parse($sph['tanggal'])->format('Y');
                                                if(!in_array($tahun, $tahunList)) {
                                                    $tahunList[] = $tahun;
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
                    </div>
                    <div class="table-responsive" style="max-height:65vh;overflow-y:auto;">
                        <table class="table table-bordered" id="sphTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nomor SPH</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Kode - Nama Proyek</th>
                                    <th>Uraian</th>
                                    <th>Harga Total</th>
                                    <th>Berkas SPH</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sphData as $sph)
                                <tr>
                                    <td>{{ $sph['no_sph'] }}</td>
                                    <td>{{ $sph['subkontraktor'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sph['tanggal'])->format('d/m/Y') }}</td>
                                    <td>{{ $sph['nama_proyek'] }}</td>
                                    <td>{{ $sph['uraian'] }}</td>
                                    <td>{{ \App\Http\Controllers\dashboardController::formatCurrency($sph['harga_total']) }}</td>
                                    <td>
                                        @if($sph['file_sph'] && isset($sph['file_sph']['path']))
                                            <div class="mb-2">
                                                <small class="text-muted d-block">{{ $sph['file_sph']['name'] }}</small>
                                                <button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-pdf-url="{{ asset('storage/' . $sph['file_sph']['path']) }}">
                                                    <i class="fa-solid fa-eye"></i> Pratinjau
                                                </button>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Preview PDF --}}
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfPreviewModalLabel">Pratinjau Dokumen PDF</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="pdfPreviewFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
      </div>
    </div>
  </div>
</div>
<div class="d-flex align-items-center justify-content-end small">
    <div class="text-muted">&copy; IT IMSS 2025</div>
</div>

@push('scripts')
<!-- DataTables CSS dan JS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>

<script>
$(function() {
    // Inisialisasi DataTable dengan fitur searching
    if ($.fn.DataTable) {
        $('#sphTable').DataTable({
            "language": {
                "decimal":        "",
                "emptyTable":    "Tidak ada data yang tersedia",
                "info":          "",
                "infoEmpty":     "",
                "infoFiltered":  "",
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
            "searching": true,
            "info": false,
            "paging": true,
            "dom": 'rtip'
        });
    }
    
    // Custom search functionality untuk search box di atas tabel
    $('#searchSph').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();
        var table = $('#sphTable').DataTable();
        
        if (table) {
            table.search(searchValue).draw();
        } else {
            // Fallback untuk manual search jika DataTable tidak tersedia
            var rows = $('#sphTable tbody tr');
            rows.each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.indexOf(searchValue) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
    
    // Filter tahun functionality
    $('#filterTahunSph').on('change', function() {
        var selectedYear = $(this).val();
        var table = $('#sphTable').DataTable();
        
        if (table) {
            if (selectedYear === '') {
                // Tampilkan semua data
                table.draw();
            } else {
                // Filter berdasarkan tahun
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    var tanggal = data[2]; // Kolom tanggal (index 2)
                    if (tanggal && tanggal !== '-') {
                        var tahun = tanggal.split('/')[2]; // Ambil tahun dari format dd/mm/yyyy
                        return tahun === selectedYear;
                    }
                    return false;
                });
                table.draw();
                $.fn.dataTable.ext.search.pop(); // Hapus filter setelah selesai
            }
        } else {
            // Fallback untuk manual filter jika DataTable tidak tersedia
            var rows = $('#sphTable tbody tr');
            rows.each(function() {
                var tanggalCell = $(this).find('td:eq(2)').text(); // Kolom tanggal
                if (selectedYear === '' || (tanggalCell && tanggalCell !== '-' && tanggalCell.split('/')[2] === selectedYear)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
    
    // Clear search saat input dikosongkan
    $('#searchSph').on('input', function() {
        if ($(this).val() === '') {
            var table = $('#sphTable').DataTable();
            if (table) {
                table.search('').draw();
            } else {
                $('#sphTable tbody tr').show();
            }
        }
    });
    
    // Handler tombol pratinjau PDF
    $(document).on('click', '.preview-pdf-btn', function(e) {
        e.preventDefault();
        var pdfUrl = $(this).data('pdf-url');
        $('#pdfPreviewFrame').attr('src', ''); // Clear dulu
        setTimeout(function() {
            $('#pdfPreviewFrame').attr('src', pdfUrl);
            var pdfModal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
            pdfModal.show();
        }, 100);
    });
    
    // Bersihkan src saat modal ditutup
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        setTimeout(function() {
            $('#pdfPreviewFrame').attr('src', '');
        }, 200);
    });
});
</script>
@endpush
