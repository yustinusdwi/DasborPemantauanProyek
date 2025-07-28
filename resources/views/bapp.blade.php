@extends('layouts.app')

@section('title', 'Dasbor Pemantauan Proyek | BAPP' . (isset($tipe) ? ' ' . strtoupper($tipe) : ''))

@section('content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">
            Daftar BAPP 
            @if(isset($tipe))
                <span class="badge bg-primary text-uppercase">{{ $tipe }}</span>
            @endif
        </li>
    </ol>
    
    <!-- Card Data BAPP -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">
                <i class="fas fa-list"></i> 
                Data Seluruh BAPP {{ isset($tipe) ? strtoupper($tipe) : '' }} Saat Ini
            </h6>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchBapp" class="form-control" placeholder="Cari Nomor BAPP, Nomor PO, Tanggal PO, Nama - Kode Proyek...">
                </div>
            </div>
            
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="bappTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nomor BAPP</th>
                            <th>Nomor PO</th>
                            <th>Tanggal PO</th>
                            <th>Tanggal Terima</th>
                            <th>Kode - Nama Proyek</th>
                            <th>Harga Total</th>
                            <th>Berkas BAPP</th>
                        </tr>
                    </thead>
                    @php
                        $columns = ['No','nomor_bapp','no_po','tanggal_po','tanggal_terima','nama_proyek','harga_total','berkas_bapp'];
                        $colCount = count($columns);
                    @endphp
                    <tbody>
                        {{-- DataTables akan mengisi nomor urut otomatis pada kolom No --}}
                        @foreach($bapps as $key => $bapp)
                        <tr>
                            <td></td> {{-- Kolom No, akan diisi otomatis oleh DataTables --}}
                            <td>{{ $bapp['nomor_bapp'] ?? '-' }}</td>
                            <td>{{ $bapp['no_po'] ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($bapp['tanggal_po'])->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($bapp['tanggal_terima'])->format('d/m/Y') }}</td>
                            <td>{{ $bapp->kode_proyek ?? '' }} - {{ $bapp->nama_proyek ?? '' }}</td>
                            <td>Rp {{ is_numeric($bapp['harga_total'] ?? null) ? number_format($bapp['harga_total'],0,',','.') : '-' }}</td>
                            <td>
                                @php
                                    $berkas = $bapp['berkas_bapp'] ?? [];
                                    if (is_string($berkas)) {
                                        $berkas = json_decode($berkas, true) ?? [];
                                    }
                                @endphp
                                @if(is_array($berkas) && count($berkas) > 0)
                                    @foreach($berkas as $file)
                                        @if(isset($file['path']))
                                            <button class="btn btn-sm btn-primary preview-bapp-btn mb-1" data-toggle="modal" data-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/' . $file['path']) }}">Pratinjau</button>
                                            <span>{{ $file['name'] ?? '' }}</span><br>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-muted">Tidak ada</span>
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
<div class="d-flex align-items-center justify-content-end small">
    <div class="text-muted">&copy; IT IMSS 2025</div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#bappTable').DataTable({
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
    $('#searchBapp').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Preview PDF - Perbaikan untuk menghindari error message channel
    $(document).on('click', '.preview-bapp-btn', function(e) {
        e.preventDefault();
        var pdfUrl = $(this).data('pdf-url');
        
        // Clear iframe terlebih dahulu
        $('#pdfPreviewFrame').attr('src', '');
        
        // Set timeout untuk memastikan iframe sudah clear
        setTimeout(function() {
            $('#pdfPreviewFrame').attr('src', pdfUrl);
            $('#pdfPreviewModal').modal('show');
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

@endsection 