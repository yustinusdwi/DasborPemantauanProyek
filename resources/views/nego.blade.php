@extends('layouts.app')

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
                    <div class="mb-3" style="max-width:350px;">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" id="searchNego" class="form-control" placeholder="Cari Negosiasi, Deskripsi, Berkas, dll...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="negoTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subkontraktor</th>
                                    <th>Nama Proyek</th>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">
        <div id="detailNegoTableContainer">
          <!-- Tabel detail akan diisi via JS -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#negoTable').DataTable({
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
    $('#searchNego').on('keyup', function() {
        table.search(this.value).draw();
    });
    // Preview PDF
    $(document).on('click', '.preview-pdf-btn', function() {
        var pdfUrl = $(this).data('pdf-url');
        // Sembunyikan modal detail sebelum buka modal preview PDF
        $('#detailNegoModal').modal('hide');
        setTimeout(function() {
            $('#pdfPreviewFrame').attr('src', pdfUrl);
            $('#pdfPreviewModal').modal('show');
        }, 300);
    });
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        $('#pdfPreviewFrame').attr('src', '');
        // Tampilkan kembali modal detail jika sebelumnya terbuka
        setTimeout(function() {
            $('#detailNegoModal').modal('show');
        }, 300);
    });
    $(document).on('click', '.lihat-detail-nego', function(e) {
        e.preventDefault();
        var negoId = $(this).data('nego-id');
        var tipe = $(this).data('tipe');
        // Ambil nama proyek dari baris tabel
        var namaProyek = $(this).closest('tr').find('td').eq(2).text();
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
        $.get('/admin/nego/detail-by-project', { nego_id: negoId }, function(res) {
            var data = res.data.filter(function(item) { return item.tipe === tipe; });
            if(data.length > 0) {
                var html = '<div class="table-responsive"><table class="table table-bordered">';
                html += '<thead><tr><th>No</th><th>Nomor Negosiasi</th><th>Subkontraktor</th><th>Tanggal</th><th>Harga Total</th><th>Berkas Hasil Nego</th></tr></thead><tbody>';
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
                            '<button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-pdf-url="' + fileUrl + '" data-toggle="modal" data-target="#pdfPreviewModal">Pratinjau</button>' +
                            ' <span>' + (item.dokumen_nego.name ?? '') + '</span>' +
                            '</td>';
                    } else {
                        html += '<td><span class="badge bg-secondary">Tidak Ada</span></td>';
                    }
                    html += '</tr>';
                });
                html += '</tbody></table></div>';
                $('#detailNegoTableContainer').html(html);
                $('#detailNegoModal').modal('show');
            } else {
                $('#detailNegoTableContainer').html('<div class="alert alert-warning">Tidak ada data detail untuk tipe ini.</div>');
                $('#detailNegoModal').modal('show');
            }
        });
    });
});
</script>
@endpush
