@extends('layouts.app')

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
                    <div class="mb-3" style="max-width:350px;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchSph" class="form-control" placeholder="Cari SPH, Nama Pekerjaan, Berkas, dll...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="sphTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nomor SPH</th>
                                    <th>Subkontraktor</th>
                                    <th>Tanggal</th>
                                    <th>Nama Proyek</th>
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
                                    <td>{{ $sph['tanggal'] }}</td>
                                    <td>{{ $sph['nama_proyek'] }}</td>
                                    <td>{{ $sph['uraian'] }}</td>
                                    <td>{{ \App\Http\Controllers\dashboardController::formatCurrency($sph['harga_total']) }}</td>
                                    <td>
                                        @if($sph['file_sph'] && isset($sph['file_sph']['path']))
                                            <div class="mb-2">
                                                <small class="text-muted d-block">{{ $sph['file_sph']['name'] }}</small>
                                                <a href="#" class="btn btn-sm btn-primary preview-pdf-btn" data-toggle="modal" data-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/' . $sph['file_sph']['path']) }}">
                                                    <i class="fa-solid fa-eye"></i> Pratinjau
                                                </a>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">
        <iframe id="pdfPreviewFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#sphTable').DataTable({
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
    $('#searchSph').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Preview PDF
    $(document).on('click', '.preview-pdf-btn', function() {
        var pdfUrl = $(this).data('pdf-url');
        $('#pdfPreviewFrame').attr('src', pdfUrl);
    });
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        $('#pdfPreviewFrame').attr('src', '');
    });
});
</script>
@endpush
