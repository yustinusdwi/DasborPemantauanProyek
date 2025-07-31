@php use Illuminate\Support\Str; @endphp
@section('title', 'MarkLens - Admin | BAPP' . (isset($tipe) ? ' ' . strtoupper($tipe) : ''))
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MarkLens - Admin | BAPP @if(isset($tipe)){{ strtoupper($tipe) }}@endif</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .header-bar {
            background-color: #fff;
            padding: 15px 30px;
            border-bottom: 2px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
                <h4 class="mb-0 fw-bold">Tabel Data BAPP @if(isset($tipe))<span class="badge bg-primary text-uppercase">{{ $tipe }}</span>@endif</h4>
                <a href="{{ route('admin') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Admin</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="bappTable">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor BAPP</th>
                            <th>No PO</th>
                            <th>Tanggal PO</th>
                            <th>Tanggal Terima</th>
                            <th>Kode - Nama Proyek</th>
                            <th>Harga Total</th>
                            <th>Berkas BAPP</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bapps as $index => $bapp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $bapp->nomor_bapp }}</td>
                                <td>{{ $bapp->no_po }}</td>
                                <td>{{ \Carbon\Carbon::parse($bapp->tanggal_po)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($bapp->tanggal_terima)->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $namaProyek = $bapp->nama_proyek ?? '';
                                        // Jika nama_proyek mengandung format "Kode - Nama Proyek", tampilkan sesuai format
                                        if (strpos($namaProyek, ' - ') !== false) {
                                            echo $namaProyek;
                                        } else {
                                            // Jika tidak ada format kode, tampilkan nama proyek saja
                                            echo $namaProyek ?: '-';
                                        }
                                    @endphp
                                </td>
                                <td>Rp {{ number_format($bapp->harga_total,0,',','.') }}</td>
                                <td>
                                    @php
                                        $berkas = is_array($bapp->berkas_bapp) ? $bapp->berkas_bapp : (json_decode($bapp->berkas_bapp, true) ?? null);
                                    @endphp
                                    @if($berkas)
                                        @if(is_array($berkas) && count($berkas) > 0)
                                            @foreach($berkas as $index => $file)
                                                @if(isset($file['path']) && Str::endsWith(strtolower($file['path']), '.pdf'))
                                                    <div class="mb-1">
                                                        <button type="button" class="btn btn-sm btn-primary preview-bapp-btn" data-pdf-url="{{ asset('storage/'.$file['path']) }}">
                                                            <i class="fas fa-eye"></i> Pratinjau
                                                        </button>
                                                        <span class="small">{{ $file['name'] ?? 'File ' . ($index + 1) }}</span>
                                                    </div>
                                                @elseif(isset($file['name']))
                                                    <div class="mb-1">
                                                        <span class="text-muted small">{{ $file['name'] }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @elseif(isset($berkas['path']) && Str::endsWith(strtolower($berkas['path']), '.pdf'))
                                            <button type="button" class="btn btn-sm btn-primary preview-bapp-btn" data-pdf-url="{{ asset('storage/'.$berkas['path']) }}">
                                                <i class="fas fa-eye"></i> Pratinjau
                                            </button>
                                            <span>{{ $berkas['name'] ?? '' }}</span>
                                        @elseif(isset($berkas['name']))
                                            <span class="text-muted">{{ $berkas['name'] }}</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm btnEditBapp" data-id="{{ $bapp->id }}">Edit</button>
                                    <button class="btn btn-danger btn-sm btnDeleteBapp" data-id="{{ $bapp->id }}">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Tambah/Edit BAPP -->
        <div class="modal fade" id="addBappModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formBapp" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formBappTitle">Tambah BAPP</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="bapp_id">
                            <div class="mb-2">
                                <label>Nomor BAPP</label>
                                <input type="text" name="nomor_bapp" id="nomor_bapp" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>No PO</label>
                                <input type="text" name="no_po" id="no_po" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Tanggal PO</label>
                                <input type="date" name="tanggal_po" id="tanggal_po" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Tanggal Terima</label>
                                <input type="date" name="tanggal_terima" id="tanggal_terima" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Kode - Nama Proyek</label>
                                <input type="text" name="nama_proyek" id="nama_proyek" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Berkas BAPP (PDF)</label>
                                <input type="file" name="berkas_bapp[]" id="berkas_bapp" class="form-control" multiple>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Preview PDF -->
        <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="pdfPreviewModalLabel">
                    <i class="fas fa-file-pdf"></i> Pratinjau Dokumen PDF
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(function() {
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
            "order": [[1, "asc"]], // Ubah order ke kolom nomor_bapp
            "columnDefs": [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                    "className": "text-center"
                }
            ]
        });
        
        // Update nomor urut saat data berubah
        table.on('draw', function() {
            table.column(0, {page: 'current'}).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        });
    });
    // Reset form saat klik Tambah BAPP
    $(document).on('click', '#btnTambahBapp', function() {
        $('#formBapp')[0].reset();
        $('#bapp_id').val('');
        $('#formBappTitle').text('Tambah BAPP');
    });
    // Preview PDF
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
    // Tambah/Edit BAPP
    $('#formBapp').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id = $('#bapp_id').val();
        var url = id ? '/admin/bapp/update/' + id : '/admin/bapp/store';
        var method = 'POST';
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(res, status, xhr) {
                // Robust JSON parse (handle PHP notice)
                var responseText = xhr.responseText || '';
                try {
                    var jsonStart = responseText.indexOf('{');
                    var resJson = JSON.parse(responseText.slice(jsonStart));
                    if(resJson.success) {
                        $('#addBappModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Gagal simpan data!');
                    }
                } catch(e) {
                    alert('Gagal parsing response!');
                }
            },
            error: function(xhr) {
                alert('Gagal simpan data!');
            }
        });
    });
    // Edit BAPP
    $(document).on('click', '.btnEditBapp', function() {
        var id = $(this).data('id');
        $.get('/admin/bapp', function(res) {
            var bapp = res.bapps.find(function(item) { return item.id == id; });
            if(bapp) {
                $('#bapp_id').val(bapp.id);
                $('#nomor_bapp').val(bapp.nomor_bapp);
                $('#no_po').val(bapp.no_po);
                $('#tanggal_po').val(bapp.tanggal_po);
                $('#tanggal_terima').val(bapp.tanggal_terima);
                $('#nama_proyek').val(bapp.nama_proyek);
                $('#formBappTitle').text('Edit BAPP');
                $('#addBappModal').modal('show');
            }
        });
    });
    // Hapus BAPP
    $(document).on('click', '.btnDeleteBapp', function() {
        if(!confirm('Yakin hapus data ini?')) return;
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/bapp/delete/' + id,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(res) {
                location.reload();
            }
        });
    });
    $(document).ready(function() {
      $(document).on('change', '#addBappModal input[type="file"]', function() {
        var input = this;
        var $parent = $(input).parent();
        $parent.find('.file-action-btns').remove();
        if (input.files && input.files.length > 0) {
          var file = input.files[0];
          var btns = $('<div class="file-action-btns mt-2"></div>');
          var previewBtn = $('<button type="button" class="btn btn-sm btn-primary me-2"><i class="fas fa-eye"></i> Pratinjau</button>');
          previewBtn.on('click', function(e) {
            e.preventDefault();
            if (file.type === 'application/pdf') {
              var fileURL = URL.createObjectURL(file);
              $('#pdfPreviewFrame').attr('src', fileURL);
              $('#pdfPreviewModal').modal('show');
              $('#pdfPreviewModal').on('hidden.bs.modal', function() {
                $('#pdfPreviewFrame').attr('src', '');
                URL.revokeObjectURL(fileURL);
              });
            } else {
              alert('Hanya file PDF yang dapat dipratinjau.');
            }
          });
          var removeBtn = $('<button type="button" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>');
          removeBtn.on('click', function(e) {
            e.preventDefault();
            $(input).val('');
            $parent.find('.file-action-btns').remove();
          });
          btns.append(previewBtn).append(removeBtn);
          $parent.append(btns);
        }
      });
    });
    </script>
</body>
</html> 