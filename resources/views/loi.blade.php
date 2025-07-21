@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar LoI</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nomor LoI</th>
                    <th>Nama Proyek</th>
                    <th>Berkas LoI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lois as $index => $loi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $loi->nomor_loi ?? '' }}</td>
                    <td>{{ $loi->nama_proyek ?? '' }}</td>
                    <td>
                        @php
                            $berkas = is_array($loi->berkas_loi ?? null) ? $loi->berkas_loi : (isset($loi->berkas_loi) ? (json_decode($loi->berkas_loi, true) ?? null) : null);
                        @endphp
                        @if($berkas && isset($berkas['path']) && Str::endsWith(strtolower($berkas['path']), '.pdf'))
                            <button type="button" class="btn btn-sm btn-primary preview-loi-btn" data-pdf-url="{{ asset('storage/'.$berkas['path']) }}" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Pratinjau</button>
                            <span>{{ $berkas['name'] ?? '' }}</span>
                        @elseif($berkas && isset($berkas['name']))
                            <span class="text-muted">{{ $berkas['name'] }}</span>
                        @else
                            <span class="badge bg-secondary">Tidak Ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data LoI.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal Preview PDF -->
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
</div>
<script>
    // Preview PDF
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.preview-loi-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var pdfUrl = this.getAttribute('data-pdf-url');
                document.getElementById('pdfPreviewFrame').setAttribute('src', pdfUrl);
            });
        });
        var pdfModal = document.getElementById('pdfPreviewModal');
        pdfModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('pdfPreviewFrame').setAttribute('src', '');
        });
    });
</script>
@endsection 