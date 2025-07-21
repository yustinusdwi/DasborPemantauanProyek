@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar BAPP</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nomor BAPP</th>
                    <th>Nomor PO</th>
                    <th>Tanggal PO</th>
                    <th>Tanggal Terima</th>
                    <th>Nama Proyek</th>
                    <th>Berkas BAPP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bapps as $bapp)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bapp->nomor_bapp }}</td>
                    <td>{{ $bapp->no_po }}</td>
                    <td>{{ $bapp->tanggal_po }}</td>
                    <td>{{ $bapp->tanggal_terima }}</td>
                    <td>{{ $bapp->nama_proyek }}</td>
                    <td>
                        @php
                            $berkas = is_array($bapp->berkas_bapp) ? $bapp->berkas_bapp : (json_decode($bapp->berkas_bapp, true) ?? null);
                        @endphp
                        @if($berkas && isset($berkas['path']))
                            <button class="btn btn-sm btn-primary preview-bapp-btn" data-toggle="modal" data-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/' . $berkas['path']) }}">Pratinjau</button>
                            <span>{{ $berkas['name'] ?? '' }}</span>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data BAPP.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Preview PDF (pindahkan di luar container agar tidak terpotong) --}}
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
    // Preview PDF
    $(document).on('click', '.preview-bapp-btn', function() {
        var pdfUrl = $(this).data('pdf-url');
        $('#pdfPreviewFrame').attr('src', pdfUrl);
    });
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        $('#pdfPreviewFrame').attr('src', '');
    });
});
</script>
@endpush
@endsection 