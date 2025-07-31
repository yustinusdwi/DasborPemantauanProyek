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
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchBapp" class="form-control" placeholder="Cari Nomor BAPP, Nomor PO, Tanggal PO, Kode - Nama Proyek...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <select id="filterTahunBapp" class="form-control">
                                <option value="">Semua Tahun</option>
                                @php
                                    $tahunList = [];
                                    foreach($bapps as $bapp) {
                                        if($bapp['tanggal_po']) {
                                            $tahun = \Carbon\Carbon::parse($bapp['tanggal_po'])->format('Y');
                                            if(!in_array($tahun, $tahunList)) {
                                                $tahunList[] = $tahun;
                                            }
                                        }
                                        if($bapp['tanggal_terima']) {
                                            $tahun = \Carbon\Carbon::parse($bapp['tanggal_terima'])->format('Y');
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
                            <td>{{ $loop->iteration }}</td> {{-- Kolom No dengan nomor urut manual --}}
                            <td>{{ $bapp['nomor_bapp'] ?? '-' }}</td>
                            <td>{{ $bapp['no_po'] ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($bapp['tanggal_po'])->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($bapp['tanggal_terima'])->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $namaProyek = $bapp['nama_proyek'] ?? '';
                                    // Jika nama_proyek mengandung format "Kode - Nama Proyek", tampilkan sesuai format
                                    if (strpos($namaProyek, ' - ') !== false) {
                                        echo $namaProyek;
                                    } else {
                                        // Jika tidak ada format kode, tampilkan nama proyek saja
                                        echo $namaProyek ?: '-';
                                    }
                                @endphp
                            </td>
                            <td>Rp {{ is_numeric($bapp['harga_total'] ?? null) ? number_format($bapp['harga_total'],0,',','.') : '-' }}</td>
                            <td>
                                @php
                                    $berkas = $bapp['berkas_bapp'] ?? [];
                                    // Pastikan berkas adalah array
                                    if (is_string($berkas)) {
                                        $berkas = json_decode($berkas, true) ?? [];
                                    }
                                    // Jika bukan array, buat array kosong
                                    if (!is_array($berkas)) {
                                        $berkas = [];
                                    }
                                @endphp
                                @if(is_array($berkas) && count($berkas) > 0)
                                    @foreach($berkas as $file)
                                        @if(isset($file['path']))
                                            <div class="mb-2">
                                                <small class="text-muted d-block">{{ $file['name'] ?? '' }}</small>
                                                <button type="button" class="btn btn-sm btn-primary preview-pdf-btn" 
                                                        data-pdf-url="{{ asset('storage/' . $file['path']) }}">
                                                    <i class="fa-solid fa-eye"></i> Pratinjau
                                                </button>
                                            </div>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="min-height:70vh;">
        <iframe id="pdfPreviewFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<!-- DataTables CSS inline untuk Bootstrap 5 -->
<style>
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #333;
    margin-bottom: 10px;
}
.dataTables_wrapper .dataTables_length select {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 2px;
}
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 4px 8px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border: 1px solid #ddd;
    padding: 4px 8px;
    margin: 0 2px;
    cursor: pointer;
    border-radius: 4px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #007bff;
    color: white;
    border-color: #007bff;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #e9ecef;
}
.dataTables_wrapper .dataTables_info {
    margin-top: 10px;
}
</style>

<!-- DataTables Scripts dengan versi yang lebih stabil -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Cek apakah DataTables tersedia
    if (typeof $.fn.DataTable === 'undefined') {
        console.log('DataTables tidak tersedia, menggunakan tabel biasa');
        // Fallback: buat tabel biasa dengan search manual
        $('#searchBapp').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#bappTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        return;
    }
    
    // Inisialisasi DataTable
    var table = $('#bappTable').DataTable({
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
        "order": [[1, "asc"]],
        "responsive": true,
        "info": false,
        "paging": true,
        "searching": true,
        "columnDefs": [
            {
                "targets": 0,
                "searchable": false,
                "orderable": false,
                "className": "text-center"
            }
        ],
        dom: 'rtip'
    });
    
    // Update nomor urut saat data berubah
    table.on('draw', function() {
        table.column(0, {page: 'current'}).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    });
    
    // Search functionality
    $('#searchBapp').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Filter tahun functionality
    $('#filterTahunBapp').on('change', function() {
        var selectedYear = $(this).val();
        
        if (selectedYear === '') {
            // Tampilkan semua data
            table.draw();
        } else {
            // Filter berdasarkan tahun dari kolom tanggal PO atau tanggal terima
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var tanggalPo = data[3]; // Kolom tanggal PO (index 3)
                var tanggalTerima = data[4]; // Kolom tanggal terima (index 4)
                
                if (tanggalPo && tanggalPo !== '-') {
                    var tahunPo = tanggalPo.split('/')[2]; // Ambil tahun dari format dd/mm/yyyy
                    if (tahunPo === selectedYear) return true;
                }
                
                if (tanggalTerima && tanggalTerima !== '-') {
                    var tahunTerima = tanggalTerima.split('/')[2]; // Ambil tahun dari format dd/mm/yyyy
                    if (tahunTerima === selectedYear) return true;
                }
                
                return false;
            });
            table.draw();
            $.fn.dataTable.ext.search.pop(); // Hapus filter setelah selesai
        }
    });
    
    // Handler tombol pratinjau PDF
    $(document).on('click', '.preview-pdf-btn', function(e) {
        e.preventDefault();
        var pdfUrl = $(this).data('pdf-url');
        
        if (!pdfUrl) {
            alert('URL PDF tidak valid');
            return;
        }
        
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