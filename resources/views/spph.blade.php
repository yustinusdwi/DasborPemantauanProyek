@extends('layouts.app')
<link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />

@section('title', 'Dasbor Pemantauan Proyek | SPPH')

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
    <ol class="breadcrumb mb-4" style="margin-top:57px;">
        <li class="breadcrumb-item active">Surat Permintaan Penawaran Harga (SPPH)</li>
    </ol>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white" style="border-radius: 10px 10px 0 0; font-weight: 600; border-bottom: 2px solid #000;">
                    <i class="fas fa-table mr-1"></i>
                    Data Seluruh SPPH Saat Ini
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="searchSpph" class="form-control" placeholder="Cari SPPH, Nama Pekerjaan, Berkas, dll...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <select id="filterTahunSpph" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @php
                                        $tahunList = [];
                                        foreach($spphData as $spph) {
                                            if($spph['tanggal']) {
                                                $tahun = \Carbon\Carbon::parse($spph['tanggal'])->format('Y');
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="spphTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nomor SPPH</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Batas Akhir SPPH</th>
                                    <th>Kode - Nama Proyek</th>
                                    <th>Uraian</th>
                                    <th>Berkas SPPH</th>
                                    <th>Berkas SOW</th>
                                    <th>Berkas Lainnya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($spphData as $spph)
                                <tr>
                                    <td>{{ $spph['no_spph'] }}</td>
                                    <td>{{ $spph['subkontraktor'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($spph['tanggal'])->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($spph['batas_akhir'])->format('d/m/Y') }}</td>
                                    <td>{{ $spph['nama_proyek'] }}</td>
                                    <td>{{ $spph['uraian'] }}</td>
                                    <td>
                                        @if($spph['file_spph'] && isset($spph['file_spph']['path']))
                                            <div class="mb-2">
                                                <small class="text-muted d-block">{{ $spph['file_spph']['name'] }}</small>
                                                <a href="#" class="btn btn-sm btn-primary preview-pdf-btn" data-toggle="modal" data-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/' . $spph['file_spph']['path']) }}">
                                                    <i class="fa-solid fa-eye"></i> Pratinjau
                                                </a>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($spph['file_sow'] && isset($spph['file_sow']['path']))
                                            <div class="mb-2">
                                                <small class="text-muted d-block">{{ $spph['file_sow']['name'] }}</small>
                                                <a href="#" class="btn btn-sm btn-primary preview-pdf-btn" data-toggle="modal" data-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/' . $spph['file_sow']['path']) }}">
                                                    <i class="fa-solid fa-eye"></i> Pratinjau
                                                </a>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($spph['file_lain']) && is_array($spph['file_lain']))
                                            @foreach($spph['file_lain'] as $file)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">{{ $file['name'] }}</small>
                                                    <a href="#" class="btn btn-sm btn-primary preview-pdf-btn" data-toggle="modal" data-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/' . $file['path']) }}">
                                                        <i class="fa-solid fa-eye"></i> Pratinjau
                                                    </a>
                                                </div>
                                            @endforeach
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#spphTable').DataTable({
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
        dom: 'rtip'
    });
    $('#searchSpph').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Filter tahun functionality
    $('#filterTahunSpph').on('change', function() {
        var selectedYear = $(this).val();
        
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
    });
    
    // Preview PDF - Perbaikan untuk menghindari error message channel
    $(document).on('click', '.preview-pdf-btn', function(e) {
        e.preventDefault();
        var pdfUrl = $(this).data('pdf-url');
        
        // Clear iframe terlebih dahulu
        $('#pdfPreviewFrame').attr('src', '');
        
        // Set timeout untuk memastikan iframe sudah clear
        setTimeout(function() {
            $('#pdfPreviewFrame').attr('src', pdfUrl);
            var pdfModal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
            pdfModal.show();
        }, 100);
    });
    
    // Handle modal close dengan benar
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        // Clear iframe dengan timeout untuk menghindari error
        setTimeout(function() {
            $('#pdfPreviewFrame').attr('src', '');
        }, 200);
    });
    
    // Handle modal show untuk memastikan iframe siap
    $('#pdfPreviewModal').on('shown.bs.modal', function () {
        // Pastikan iframe sudah ter-set dengan benar
        var iframe = document.getElementById('pdfPreviewFrame');
        if (iframe) {
            iframe.style.height = '600px';
        }
    });
});
</script>
@endpush
