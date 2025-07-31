@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('title', 'Dasbor Pemantauan Proyek | LoI')

@section('content')
<div class="container mt-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar LoI</li>
    </ol>
    
    <!-- Card Data LoI -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0"><i class="fas fa-list"></i> Data Seluruh LoI Saat Ini</h6>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nomor LoI, nama - kode proyek, nomor kontrak, atau informasi lainnya...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <select id="filterTahunLoi" class="form-control">
                                <option value="">Semua Tahun</option>
                                @php
                                    $tahunList = [];
                                    foreach($lois as $loi) {
                                        if($loi->tanggal) {
                                            $tahun = \Carbon\Carbon::parse($loi->tanggal)->format('Y');
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

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="loiTable">
                    <thead class="thead-dark">
                        <tr>
                            <th class="sortable" data-sort="no">
                                No
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="nomor_loi">
                                Nomor LoI
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="tanggal">
                                Tanggal
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="batas_akhir_loi">
                                Batas Akhir LoI
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="no_po">
                                No PO
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="nomor_kontrak">
                                Nomor Kontrak
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="pelanggan">
                                Pelanggan
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="nama_proyek">
                                Kode - Nama Proyek
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="harga_total">
                                Total Harga
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th>
                                Berkas LoI
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lois as $index => $loi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $loi->nomor_loi ?? '' }}</td>
                            <td data-sort="{{ $loi->tanggal ? $loi->tanggal->format('Y-m-d') : '' }}">{{ \Carbon\Carbon::parse($loi->tanggal)->format('d/m/Y') }}</td>
                            <td data-sort="{{ $loi->batas_akhir_loi ? $loi->batas_akhir_loi->format('Y-m-d') : '' }}">{{ $loi->batas_akhir_loi ? $loi->batas_akhir_loi->format('d/m/Y') : '' }}</td>
                            <td>{{ $loi->no_po ?? '-' }}</td>
                            <td>{{ $loi->kontrak ? $loi->kontrak->nomor_kontrak : '-' }}</td>
                            <td>{{ $loi->kontrak ? $loi->kontrak->subkontraktor : '-' }}</td>
                            <td>{{ $loi->kode_proyek ?? '' }} - {{ $loi->nama_proyek ?? '' }}</td>
                            <td data-sort="{{ $loi->harga_total ?? 0 }}">{{ $loi->harga_total ? 'Rp ' . number_format($loi->harga_total, 0, ',', '.') : '' }}</td>
                            <td>
                                @php
                                    $berkas = is_array($loi->berkas_loi ?? null) ? $loi->berkas_loi : (isset($loi->berkas_loi) ? (json_decode($loi->berkas_loi, true) ?? null) : null);
                                @endphp
                                @if($berkas && isset($berkas['path']) && Str::endsWith(strtolower($berkas['path']), '.pdf'))
                                    <button type="button" class="btn btn-sm btn-primary preview-loi-btn" data-pdf-url="{{ asset('storage/'.$berkas['path']) }}">Pratinjau</button>
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
                            <td colspan="10" class="text-center">Belum ada data LoI.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal Preview PDF -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="pdfPreviewModalLabel">Pratinjau Dokumen PDF</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <iframe id="pdfPreviewFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="d-flex align-items-center justify-content-end small">
    <div class="text-muted">&copy; IT IMSS 2025</div>
</div>

<style>
.sortable {
    cursor: pointer;
    position: relative;
    user-select: none;
}

.sortable:hover {
    background-color: #f8f9fa;
}

.sort-icon {
    margin-left: 5px;
    font-size: 0.8em;
    opacity: 0.5;
}

.sortable.sort-asc .sort-icon {
    opacity: 1;
    color: #007bff;
}

.sortable.sort-desc .sort-icon {
    opacity: 1;
    color: #007bff;
}

.sortable:hover .sort-icon {
    opacity: 0.8;
}

#searchInput {
    border-radius: 0 0 0 0;
}

#searchInput:focus {
    box-shadow: none;
    border-color: #007bff;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

.card-header {
    border-bottom: none;
}

.table th {
    border-top: none;
    background-color: #343a40;
    color: white;
    font-weight: 600;
}

.table th.sortable {
    background-color: #343a40;
}

.table th.sortable:hover {
    background-color: #495057;
}

.highlight {
    background-color: #fff3cd;
    font-weight: bold;
}
</style>

@push('scripts')
<!-- DataTables CSS dan JS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>

<script>
$(function() {
    // Inisialisasi DataTable dengan fitur searching
    if ($.fn.DataTable) {
        $('#loiTable').DataTable({
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
    $('#searchInput').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();
        var table = $('#loiTable').DataTable();
        
        if (table) {
            table.search(searchValue).draw();
        } else {
            // Fallback untuk manual search jika DataTable tidak tersedia
            var rows = $('#loiTable tbody tr');
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
    
    // Clear search saat input dikosongkan
    $('#searchInput').on('input', function() {
        if ($(this).val() === '') {
            var table = $('#loiTable').DataTable();
            if (table) {
                table.search('').draw();
            } else {
                $('#loiTable tbody tr').show();
            }
        }
    });
    
    // Filter tahun functionality
    $('#filterTahunLoi').on('change', function() {
        var selectedYear = $(this).val();
        var table = $('#loiTable').DataTable();
        
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
            var rows = $('#loiTable tbody tr');
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
    
    // Handler tombol pratinjau PDF
    $(document).on('click', '.preview-loi-btn', function(e) {
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
@endsection 