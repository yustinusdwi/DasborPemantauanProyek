@extends('layouts.app')

@section('title', 'MarkLens | Negosiasi')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Negosiasi Proyek</li>
    </ol>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white" style="border-radius: 10px 10px 0 0; font-weight: 600; border-bottom: 2px solid #000;">
                    <i class="fas fa-table mr-1"></i>
                    Data Seluruh Negosiasi Saat Ini
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="searchNego" class="form-control" placeholder="Cari Negosiasi, Deskripsi, Berkas, dll...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <select id="filterTahunNego" class="form-control">
                                    <option value="">Semua Tahun</option>
                                    @php
                                        $tahunList = [];
                                        foreach($negoData as $nego) {
                                            // Ambil tahun dari created_at atau tanggal terbaru
                                            $tahun = \Carbon\Carbon::now()->format('Y');
                                            if(!in_array($tahun, $tahunList)) {
                                                $tahunList[] = $tahun;
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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="negoTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggan</th>
                                    <th>Kode - Nama Proyek</th>
                                    <th>Uraian</th>
                                    <th>Negosiasi Masuk & Keluar</th>
                                    <th>Hasil Negosiasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($negoData as $index => $nego)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $nego['subkontraktor'] }}</td>
                                    <td>{{ $nego['nama_proyek'] }}</td>
                                    <td>{{ $nego['uraian'] }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm lihat-detail-nego" data-nego-id="{{ $nego['id'] }}" data-tipe="masuk">Lihat Detail Masuk</button>
                                        <button class="btn btn-secondary btn-sm lihat-detail-nego" data-nego-id="{{ $nego['id'] }}" data-tipe="keluar">Lihat Detail Keluar</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm lihat-detail-nego" data-nego-id="{{ $nego['id'] }}" data-tipe="hasil">Lihat Hasil Negosiasi</button>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="pdfPreviewFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
      </div>
    </div>
  </div>
</div>
<!-- Modal Detail Negosiasi -->
<div class="modal fade" id="detailNegoModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Negosiasi Proyek: <span id="modalNamaProyek"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="detailNegoTableContainer">
          <!-- Tabel detail akan diisi via JS -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<div class="d-flex align-items-center justify-content-end small">
    <div class="text-muted">&copy; IT IMSS 2025</div>
</div>
@endsection

@push('scripts')
<!-- DataTables CSS dan JS -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>

<script>
$(function() {
    // Inisialisasi DataTable dengan fitur searching
    if ($.fn.DataTable) {
        $('#negoTable').DataTable({
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
    $('#searchNego').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();
        var table = $('#negoTable').DataTable();
        
        if (table) {
            table.search(searchValue).draw();
        } else {
            // Fallback untuk manual search jika DataTable tidak tersedia
            var rows = $('#negoTable tbody tr');
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
    $('#searchNego').on('input', function() {
        if ($(this).val() === '') {
            var table = $('#negoTable').DataTable();
            if (table) {
                table.search('').draw();
            } else {
                $('#negoTable tbody tr').show();
            }
        }
    });
    
    // Filter tahun functionality
    $('#filterTahunNego').on('change', function() {
        var selectedYear = $(this).val();
        var table = $('#negoTable').DataTable();
        
        if (table) {
            if (selectedYear === '') {
                // Tampilkan semua data
                table.draw();
            } else {
                // Filter berdasarkan tahun (karena nego tidak punya kolom tanggal, gunakan tahun saat ini)
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    // Untuk nego, kita akan menampilkan semua data karena tidak ada kolom tanggal
                    return true;
                });
                table.draw();
                $.fn.dataTable.ext.search.pop(); // Hapus filter setelah selesai
            }
        } else {
            // Fallback untuk manual filter jika DataTable tidak tersedia
            var rows = $('#negoTable tbody tr');
            rows.each(function() {
                // Untuk nego, tampilkan semua data karena tidak ada kolom tanggal
                $(this).show();
            });
        }
    });

    // Handler tombol detail nego
    $(document).on('click', '.lihat-detail-nego', function(e) {
        e.preventDefault();
        var negoId = $(this).data('nego-id');
        var tipe = $(this).data('tipe');
        var namaProyek = $(this).closest('tr').find('td:eq(2)').text();
        $('#modalNamaProyek').text(namaProyek);
        $('#detailNegoTableContainer').html('<div class="text-center">Memuat data...</div>');
        
        function formatRupiah(angka) {
            if (!angka || isNaN(angka)) return '-';
            var number_string = angka.toString().replace(/[^\d]/g, ''),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);
            if (ribuan) {
                rupiah += (sisa ? '.' : '') + ribuan.join('.');
            }
            return 'Rp. ' + rupiah;
        }
        
        $.get('/nego/detail-by-project', { nego_id: negoId })
            .done(function(res) {
                var data = res.data.filter(function(item) { return item.tipe === tipe; });
                if(data.length > 0) {
                    var html = '<div class="table-responsive"><table class="table table-bordered">';
                    html += '<thead><tr><th>No</th><th>Nomor Negosiasi</th><th>Pelanggan</th><th>Tanggal</th><th>Harga Total</th><th>Berkas Hasil Nego</th></tr></thead><tbody>';
                    data.forEach(function(item, idx) {
                        html += '<tr>';
                        html += '<td>' + (idx + 1) + '</td>';
                        html += '<td>' + (item.nomor_nego ?? '-') + '</td>';
                        html += '<td>' + (item.subkontraktor ?? '-') + '</td>';
                        html += '<td>' + (item.tanggal ? new Date(item.tanggal).toLocaleDateString('id-ID') : '-') + '</td>';
                        html += '<td>' + (item.harga_total ? formatRupiah(item.harga_total) : '-') + '</td>';
                        if(item.dokumen_nego && item.dokumen_nego.path) {
                            var fileUrl = "{{ asset('storage') }}/" + item.dokumen_nego.path;
                            html += '<td>' +
                                '<button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-pdf-url="' + fileUrl + '">Pratinjau</button>' +
                                ' <span>' + (item.dokumen_nego.name ?? '') + '</span>' +
                                '</td>';
                        } else {
                            html += '<td><span class="badge bg-secondary">Tidak Ada</span></td>';
                        }
                        html += '</tr>';
                    });
                    html += '</tbody></table></div>';
                    $('#detailNegoTableContainer').html(html);
                    var detailModal = new bootstrap.Modal(document.getElementById('detailNegoModal'));
                    detailModal.show();
                } else {
                    $('#detailNegoTableContainer').html('<div class="alert alert-warning">Tidak ada data detail untuk tipe ini.</div>');
                    var detailModal = new bootstrap.Modal(document.getElementById('detailNegoModal'));
                    detailModal.show();
                }
            })
            .fail(function() {
                $('#detailNegoTableContainer').html('<div class="alert alert-danger">Terjadi kesalahan saat memuat data.</div>');
                var detailModal = new bootstrap.Modal(document.getElementById('detailNegoModal'));
                detailModal.show();
            });
    });

    // Handler tombol pratinjau PDF (baik di tabel utama maupun di modal detail)
    $(document).on('click', '.preview-pdf-btn', function(e) {
        e.preventDefault();
        var pdfUrl = $(this).data('pdf-url');
        if (!pdfUrl) {
            alert('URL PDF tidak valid');
            return;
        }
        var iframe = document.getElementById('pdfPreviewFrame');
        if (iframe) {
            iframe.src = '';
            setTimeout(function() {
                iframe.src = pdfUrl;
                var pdfModal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
                pdfModal.show();
            }, 100);
        }
    });

    // Handle modal close untuk PDF
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        var iframe = document.getElementById('pdfPreviewFrame');
        if (iframe) {
            setTimeout(function() {
                iframe.src = '';
            }, 200);
        }
    });
    
    $('#pdfPreviewModal').on('shown.bs.modal', function () {
        var iframe = document.getElementById('pdfPreviewFrame');
        if (iframe) {
            iframe.style.height = '600px';
        }
    });
});
</script>
@endpush
