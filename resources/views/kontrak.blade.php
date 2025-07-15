@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Kontrak Proyek</li>
    </ol>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white" style="border-radius: 10px 10px 0 0; font-weight: 600; border-bottom: 2px solid #000;">
                    <i class="fas fa-table mr-1"></i>
                    Data Seluruh Kontrak Saat Ini
                </div>
                <div class="card-body">
                    <div class="mb-3" style="max-width:350px;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchKontrak" class="form-control" placeholder="Cari Kontrak, Berkas, dll...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="kontrakTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Kontrak</th>
                                    <th>Tanggal</th>
                                    <th>Batas Akhir Kontrak</th>
                                    <th>Uraian</th>
                                    <th>Harga Total</th>
                                    <th>Berkas Kontrak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kontrakData as $kontrak)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kontrak['no_kontrak'] }}</td>
                                    <td>{{ $kontrak['tanggal'] }}</td>
                                    <td>{{ $kontrak['batas_akhir'] }}</td>
                                    <td>{{ $kontrak['uraian'] }}</td>
                                    <td>{{ \App\Http\Controllers\dashboardController::formatCurrency($kontrak['nilai_harga_total']) }}</td>
                                    <td>
                                        @if(!empty($kontrak['file_kontrak']) && is_array($kontrak['file_kontrak']))
                                            @foreach($kontrak['file_kontrak'] as $file)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">{{ $file['name'] }}</small>
                                                    <button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-toggle="modal" data-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/' . $file['path']) }}">
                                                        <i class="fa-solid fa-eye"></i> Pratinjau
                                                    </button>
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#kontrakTable').DataTable({
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
    $('#searchKontrak').on('keyup', function() {
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
