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
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nomor LoI, nama - kode proyek, nomor kontrak, atau informasi lainnya...">
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
<script>
    $(document).ready(function() {
        let currentSort = { column: null, direction: 'asc' };
        let originalData = [];
        let filteredData = [];
        
        // Store original data
        $('#loiTable tbody tr').each(function() {
            originalData.push($(this).clone());
        });
        filteredData = [...originalData];
        
        // Search functionality
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            filterAndDisplayData(searchTerm);
        });
        
        // Sorting functionality
        $('.sortable').on('click', function() {
            const column = $(this).data('sort');
            const $this = $(this);
            
            // Update sort direction
            if (currentSort.column === column) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.column = column;
                currentSort.direction = 'asc';
            }
            
            // Update sort icons
            $('.sortable').removeClass('sort-asc sort-desc');
            $('.sortable .sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
            $this.addClass(currentSort.direction === 'asc' ? 'sort-asc' : 'sort-desc');
            $this.find('.sort-icon').removeClass('fa-sort').addClass(currentSort.direction === 'asc' ? 'fa-sort-up' : 'fa-sort-down');
            
            // Sort and display data
            sortAndDisplayData();
        });
        
        // Preview PDF functionality
        $('.preview-loi-btn').on('click', function(e) {
            e.preventDefault();
            var pdfUrl = $(this).data('pdf-url');
            $('#pdfPreviewFrame').attr('src', pdfUrl);
            $('#pdfPreviewModal').modal('show');
        });
        
        // Clear iframe when modal is hidden
        $('#pdfPreviewModal').on('hidden.bs.modal', function () {
            $('#pdfPreviewFrame').attr('src', '');
        });
        
        function filterAndDisplayData(searchTerm) {
            filteredData = originalData.filter(function(row) {
                const text = $(row).text().toLowerCase();
                return text.includes(searchTerm);
            });
            
            sortAndDisplayData();
        }
        
        function sortAndDisplayData() {
            if (currentSort.column && filteredData.length > 0) {
                filteredData.sort(function(a, b) {
                    let aVal, bVal;
                    
                    if (currentSort.column === 'no') {
                        aVal = parseInt($(a).find('td:first').text());
                        bVal = parseInt($(b).find('td:first').text());
                    } else {
                        const aCell = $(a).find(`td:nth-child(${getColumnIndex(currentSort.column)})`);
                        const bCell = $(b).find(`td:nth-child(${getColumnIndex(currentSort.column)})`);
                        
                        if (currentSort.column === 'tanggal' || currentSort.column === 'batas_akhir_loi') {
                            aVal = aCell.data('sort') || '';
                            bVal = bCell.data('sort') || '';
                        } else if (currentSort.column === 'harga_total') {
                            aVal = parseFloat(aCell.data('sort') || 0);
                            bVal = parseFloat(bCell.data('sort') || 0);
                        } else {
                            aVal = aCell.text().toLowerCase();
                            bVal = bCell.text().toLowerCase();
                        }
                    }
                    
                    if (currentSort.direction === 'asc') {
                        return aVal > bVal ? 1 : -1;
                    } else {
                        return aVal < bVal ? 1 : -1;
                    }
                });
            }
            
            displayData();
        }
        
        function getColumnIndex(column) {
            const columnMap = {
                'no': 1,
                'nomor_loi': 2,
                'tanggal': 3,
                'batas_akhir_loi': 4,
                'no_po': 5,
                'nomor_kontrak': 6,
                'pelanggan': 7,
                'nama_proyek': 8,
                'harga_total': 9
            };
            return columnMap[column] || 1;
        }
        
        function displayData() {
            const $tbody = $('#loiTable tbody');
            $tbody.empty();
            
            if (filteredData.length === 0) {
                $tbody.append('<tr><td colspan="10" class="text-center">Tidak ada data yang ditemukan.</td></tr>');
            } else {
                filteredData.forEach(function(row, index) {
                    const $newRow = $(row);
                    $newRow.find('td:first').text(index + 1);
                    $tbody.append($newRow);
                });
                
                // Re-attach preview button events
                $('.preview-loi-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    var pdfUrl = $(this).data('pdf-url');
                    $('#pdfPreviewFrame').attr('src', pdfUrl);
                    $('#pdfPreviewModal').modal('show');
                });
            }
        }
    });
</script>
@endpush
@endsection 