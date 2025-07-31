@php use Illuminate\Support\Str; @endphp
@section('title', 'MarkLens - Admin | LoI')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MarkLens - Admin | LoI</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .header-bar {
            background-color: #fff;
            padding: 15px 30px;
            border-bottom: 2px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dataTables_empty {
            text-align: center !important;
            padding: 20px !important;
            color: #6c757d !important;
            font-style: italic;
        }
        .table tbody tr td:empty {
            border: none;
            background: transparent;
        }
    </style>
</head>
<body class="bg-light">
    <div class="header-bar mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ asset('img/imssMARKLENS-logo.png') }}" alt="Logo IMSS" style="height:80px; width:auto; margin-right:12px; margin-top:0;">
            <span class="fw-bold fs-6">Administrator</span>
        </div>
        <a href="{{ route('admin') }}" class="btn btn-outline-secondary">Kembali ke Admin</a>
    </div>
    <div class="container py-4">
        <div class="card mb-4">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">Tabel Data LoI</h4>
                <a href="{{ route('admin') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Admin</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="loiTable">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor LoI</th>
                            <th>Tanggal</th>
                            <th>Batas Akhir LoI</th>
                            <th>No PO</th>
                            <th>Nomor Kontrak</th>
                            <th>Pelanggan</th>
                            <th>Kode - Nama Proyek</th>
                            <th>Total Harga</th>
                            <th>Berkas LoI</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($lois->count() > 0)
                            @foreach($lois as $index => $loi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $loi->nomor_loi ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($loi->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $loi->batas_akhir_loi ? \Carbon\Carbon::parse($loi->batas_akhir_loi)->format('d/m/Y') : '' }}</td>
                                    <td>{{ $loi->no_po ?? '-' }}</td>
                                    <td>{{ $loi->kontrak ? $loi->kontrak->nomor_kontrak : '-' }}</td>
                                    <td>{{ $loi->kontrak ? $loi->kontrak->subkontraktor : '-' }}</td>
                                    <td>{{ $loi->kode_proyek ?? '' }} - {{ $loi->nama_proyek ?? '' }}</td>
                                    <td>{{ $loi->harga_total ? 'Rp ' . number_format($loi->harga_total, 0, ',', '.') : '' }}</td>
                                    <td>
                                        @php
                                            $berkas = is_array($loi->berkas_loi ?? null) ? $loi->berkas_loi : (isset($loi->berkas_loi) ? (json_decode($loi->berkas_loi, true) ?? null) : null);
                                        @endphp
                                        @if($berkas && isset($berkas['path']) && Str::endsWith(strtolower($berkas['path']), '.pdf'))
                                            <button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-pdf-url="{{ asset('storage/'.$berkas['path']) }}">Pratinjau</button>
                                            <span>{{ $berkas['name'] ?? '' }}</span>
                                        @elseif($berkas && isset($berkas['name']))
                                            <span class="text-muted">{{ $berkas['name'] }}</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btnEditLoi" data-id="{{ $loi->id ?? '' }}">Edit</button>
                                        <button class="btn btn-danger btn-sm btnDeleteLoi" data-id="{{ $loi->id ?? '' }}">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <!-- Baris kosong untuk DataTables -->
                            <tr style="display: none;">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $(function() {
        try {
            var table = $('#loiTable').DataTable({
                "language": {
                    "emptyTable": "Belum ada data LoI.",
                    "zeroRecords": "Tidak ada data yang cocok dengan pencarian."
                },
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthChange": true,
                "pageLength": 10,
                "responsive": true,
                "destroy": true,
                "columnDefs": [
                    { "orderable": false, "targets": [9, 10] } // Kolom Berkas LoI dan Aksi tidak bisa di-sort
                ]
            });
            
            // Tambahkan event listener untuk error handling
            table.on('error.dt', function(e, settings, techNote, message) {
                console.error('DataTable error:', message);
                // Reload halaman jika terjadi error
                setTimeout(function() {
                    location.reload();
                }, 1000);
            });
            
        } catch (error) {
            console.error('Error initializing DataTable:', error);
            // Fallback jika DataTable gagal diinisialisasi
            $('#loiTable').addClass('table-striped');
        }
    });

    // Preview PDF
        $(document).on('click', '.preview-pdf-btn', function(e) {
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
    // Edit LoI
    $(document).on('click', '.btnEditLoi', function() {
        var id = $(this).data('id');
        $.get('/admin/loi/' + id + '/edit', function(data) {
            // Tampilkan data dalam alert untuk sementara
            var message = 'Data LoI untuk edit:\n';
            message += 'ID: ' + data.id + '\n';
            message += 'Nomor LoI: ' + data.nomor_loi + '\n';
            message += 'Tanggal: ' + data.tanggal + '\n';
            message += 'Batas Akhir: ' + data.batas_akhir_loi + '\n';
            message += 'No PO: ' + data.no_po + '\n';
            message += 'Nama - Kode Proyek: ' + data.nama_proyek + '\n';
            message += 'Harga Total: ' + data.harga_total;
            alert(message);
        });
    });
    
    // Hapus LoI
    $(document).on('click', '.btnDeleteLoi', function() {
        if(!confirm('Yakin hapus data ini?')) return;
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        
        $.ajax({
            url: '/admin/loi/' + id,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Hapus baris dari DataTable
                var table = $('#loiTable').DataTable();
                table.row($row).remove().draw();
                
                // Jika tidak ada data lagi, reload halaman untuk menghindari error
                if (table.data().count() === 0) {
                    // Destroy DataTable dan reload halaman
                    table.destroy();
                    setTimeout(function() {
                        location.reload();
                    }, 100);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    });

    </script>
</body>
</html> 