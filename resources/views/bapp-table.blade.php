@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data BAPP</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card mb-4">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">Tabel Data BAPP</h4>
                <a href="{{ route('admin') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Admin</a>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBappModal" id="btnTambahBapp">Tambah BAPP</button>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="bappTable">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor BAPP</th>
                            <th>No PO</th>
                            <th>Tanggal PO</th>
                            <th>Tanggal Terima</th>
                            <th>Nama Proyek</th>
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
                                <td>{{ $bapp->tanggal_po }}</td>
                                <td>{{ $bapp->tanggal_terima }}</td>
                                <td>{{ $bapp->nama_proyek }}</td>
                                <td>
                                    @php
                                        $berkas = is_array($bapp->berkas_bapp) ? $bapp->berkas_bapp : (json_decode($bapp->berkas_bapp, true) ?? null);
                                    @endphp
                                    @if($berkas && isset($berkas['path']) && Str::endsWith(strtolower($berkas['path']), '.pdf'))
                                        <button type="button" class="btn btn-sm btn-primary preview-bapp-btn" data-pdf-url="{{ asset('storage/'.$berkas['path']) }}" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Pratinjau</button>
                                        <span>{{ $berkas['name'] ?? '' }}</span>
                                    @elseif($berkas && isset($berkas['name']))
                                        <span class="text-muted">{{ $berkas['name'] }}</span>
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
                                <label>Nama Proyek</label>
                                <input type="text" name="nama_proyek" id="nama_proyek" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Berkas BAPP (PDF)</label>
                                <input type="file" name="berkas_bapp" id="berkas_bapp" class="form-control">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(function() {
        $('#bappTable').DataTable();
    });
    // Reset form saat klik Tambah BAPP
    $(document).on('click', '#btnTambahBapp', function() {
        $('#formBapp')[0].reset();
        $('#bapp_id').val('');
        $('#formBappTitle').text('Tambah BAPP');
    });
    // Preview PDF
    $(document).on('click', '.preview-bapp-btn', function() {
        var pdfUrl = $(this).data('pdf-url');
        $('#pdfPreviewFrame').attr('src', pdfUrl);
    });
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        $('#pdfPreviewFrame').attr('src', '');
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
    </script>
</body>
</html> 