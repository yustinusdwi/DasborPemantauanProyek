@extends('layouts.app')

@section('title', 'Daftar Notifikasi Proyek')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Daftar Pemberitahuan</li>
    </ol>
    
    <!-- Filter Tahun -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                <select id="filterTahunNotifikasi" class="form-control">
                    <option value="">Semua Tahun</option>
                    @php
                        $tahunList = [];
                        foreach($notifications as $nama_proyek => $notifs) {
                            foreach($notifs as $notif) {
                                if($notif->batas_akhir) {
                                    $tahun = \Carbon\Carbon::parse($notif->batas_akhir)->format('Y');
                                    if(!in_array($tahun, $tahunList)) {
                                        $tahunList[] = $tahun;
                                    }
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
        <div class="col-md-8">
            <div class="d-flex justify-content-end">
                <button id="btnResetFilterNotifikasi" class="btn btn-secondary btn-sm">
                    <i class="fas fa-refresh"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>
    
    <div id="notifikasiContainer">
        @if($notifications->isEmpty())
            <div class="alert alert-info">Belum ada notifikasi apapun.</div>
        @else
            @foreach($notifications as $nama_proyek => $notifs)
                <div class="card mb-4 notifikasi-card" data-nama-proyek="{{ $nama_proyek }}">
                    <div class="card-header bg-primary text-white">
                        <strong>{{ $nama_proyek }}</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Batas Akhir</th>
                                    <th>Pesan</th>
                                    <th>Asal Dokumen</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($notifs as $notif)
                                <tr class="notifikasi-row" data-tahun="{{ \Carbon\Carbon::parse($notif->batas_akhir)->format('Y') }}">
                                    <td>{{ \Carbon\Carbon::parse($notif->batas_akhir)->translatedFormat('d M Y') }}</td>
                                    <td>{{ $notif->message }}</td>
                                    <td>
                                        @if($notif->type === 'spph')
                                            <span class="badge badge-info">SPPH</span>
                                        @elseif($notif->type === 'kontrak')
                                            <span class="badge badge-warning">Kontrak</span>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($notif->is_read)
                                            <span class="badge badge-success">Sudah Dibaca</span>
                                        @else
                                            <span class="badge badge-danger">Belum Dibaca</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Filter tahun functionality
    $('#filterTahunNotifikasi').on('change', function() {
        var selectedYear = $(this).val();
        filterNotifikasiByYear(selectedYear);
    });

    // Reset filter event handler
    $('#btnResetFilterNotifikasi').on('click', function() {
        $('#filterTahunNotifikasi').val('');
        filterNotifikasiByYear('');
    });

    function filterNotifikasiByYear(selectedYear) {
        console.log('Filtering by year:', selectedYear); // Debug log
        
        if (!selectedYear) {
            // Tampilkan semua notifikasi
            $('.notifikasi-card').show();
            $('.notifikasi-row').show();
            $('#emptyMessage').remove();
            return;
        }

        var hasVisibleRows = false;
        
        // Filter berdasarkan tahun
        $('.notifikasi-card').each(function() {
            var card = $(this);
            var cardHasVisibleRows = false;
            
            card.find('.notifikasi-row').each(function() {
                var row = $(this);
                var tahun = row.data('tahun');
                console.log('Row tahun:', tahun, 'Selected year:', selectedYear); // Debug log
                
                if (tahun == selectedYear) { // Gunakan == untuk string comparison
                    row.show();
                    cardHasVisibleRows = true;
                    hasVisibleRows = true;
                } else {
                    row.hide();
                }
            });
            
            // Tampilkan/sembunyikan card berdasarkan apakah ada row yang visible
            if (cardHasVisibleRows) {
                card.show();
            } else {
                card.hide();
            }
        });

        // Update pesan jika tidak ada data
        updateEmptyMessage(hasVisibleRows);
    }

    function updateEmptyMessage(hasVisibleRows) {
        console.log('Has visible rows:', hasVisibleRows); // Debug log
        
        if (!hasVisibleRows) {
            if ($('#emptyMessage').length === 0) {
                $('#notifikasiContainer').html('<div id="emptyMessage" class="alert alert-info">Tidak ada notifikasi untuk tahun yang dipilih.</div>');
            }
        } else {
            $('#emptyMessage').remove();
        }
    }
});
</script>
@endpush
@endsection 