@extends('layouts.app')
@section('title', 'Dasbor Pemantauan Proyek | Kontrak')
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
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th>Batas Akhir Kontrak</th>
                                    <th>Kode - Nama Proyek</th>
                                    <th>Uraian</th>
                                    <th>Harga Total</th>
                                    <th>LoI</th>
                                    <th>Berkas Kontrak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kontrakData as $kontrak)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kontrak['no_kontrak'] }}</td>
                                    <td>{{ $kontrak['subkontraktor'] }}</td>
                                    <td>{{ $kontrak['tanggal'] ? \Carbon\Carbon::parse($kontrak['tanggal'])->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $kontrak['batas_akhir'] ? \Carbon\Carbon::parse($kontrak['batas_akhir'])->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $kontrak['kode_proyek'] ?? '' }} - {{ $kontrak['nama_proyek'] ?? '' }}</td>
                                    <td>{{ $kontrak['uraian'] }}</td>
                                    <td>{{ \App\Http\Controllers\dashboardController::formatCurrency($kontrak['nilai_harga_total']) }}</td>
                                    <td>
                                        @if(isset($kontrak['loi_info']))
                                            <span class="badge bg-info">{{ $kontrak['loi_info']['nomor_loi'] }}</span>
                                            <br><small class="text-muted">{{ $kontrak['loi_info']['nama_proyek'] }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($kontrak['file_kontrak'] && isset($kontrak['file_kontrak']['path']))
                                            <div class="mb-2">
                                                <small class="text-muted d-block">{{ $kontrak['file_kontrak']['name'] }}</small>
                                                <button type="button" class="btn btn-sm btn-primary preview-pdf-btn" 
                                                        data-pdf-url="{{ asset('storage/' . $kontrak['file_kontrak']['path']) }}">
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
<div class="d-flex align-items-center justify-content-end small">
    <div class="text-muted">&copy; IT IMSS 2025</div>
</div>
@endsection

<!-- Modal Preview PDF (letakkan di luar section) -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfPreviewModalLabel">Pratinjau Dokumen PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body" style="min-height:70vh;">
        <iframe id="pdfPreviewFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
$(function() {
    // Handler tombol pratinjau PDF
    $(document).on('click', '.preview-pdf-btn', function(e) {
        e.preventDefault();
        var pdfUrl = $(this).data('pdf-url');
        $('#pdfPreviewFrame').attr('src', ''); // Clear dulu
        setTimeout(function() {
            $('#pdfPreviewFrame').attr('src', pdfUrl);
            $('#pdfPreviewModal').modal('show');
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
