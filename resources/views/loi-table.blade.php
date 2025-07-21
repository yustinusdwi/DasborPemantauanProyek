@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data LoI</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="card mb-4">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">Tabel Data LoI</h4>
                <a href="{{ route('admin') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Admin</a>
            </div>
            <div class="card-body">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addLoiModal" id="btnTambahLoi">Tambah LoI</button>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="loiTable">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor LoI</th>
                            <th>Nama Proyek</th>
                            <th>Berkas LoI</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($lois as $index => $loi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $loi->nomor_loi ?? '' }}</td>
                                <td>{{ $loi->nama_proyek ?? '' }}</td>
                                <td>
                                    @php
                                        $berkas = is_array($loi->berkas_loi ?? null) ? $loi->berkas_loi : (isset($loi->berkas_loi) ? (json_decode($loi->berkas_loi, true) ?? null) : null);
                                    @endphp
                                    @if($berkas && isset($berkas['path']) && Str::endsWith(strtolower($berkas['path']), '.pdf'))
                                        <button type="button" class="btn btn-sm btn-primary preview-loi-btn" data-pdf-url="{{ asset('storage/'.$berkas['path']) }}" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Pratinjau</button>
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
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data LoI.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Tambah/Edit LoI -->
        <div class="modal fade" id="addLoiModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formLoi" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formLoiTitle">Tambah LoI</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="loi_id">
                            <div class="mb-2">
                                <label>Nomor LoI</label>
                                <input type="text" name="nomor_loi" id="nomor_loi" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Nama Proyek</label>
                                <input type="text" name="nama_proyek" id="nama_proyek" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Berkas LoI (PDF)</label>
                                <input type="file" name="berkas_loi" id="berkas_loi" class="form-control">
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
        $('#loiTable').DataTable();
    });
    // Reset form saat klik Tambah LoI
    $(document).on('click', '#btnTambahLoi', function() {
        $('#formLoi')[0].reset();
        $('#loi_id').val('');
        $('#formLoiTitle').text('Tambah LoI');
    });
    // Preview PDF
    $(document).on('click', '.preview-loi-btn', function() {
        var pdfUrl = $(this).data('pdf-url');
        $('#pdfPreviewFrame').attr('src', pdfUrl);
    });
    $('#pdfPreviewModal').on('hidden.bs.modal', function () {
        $('#pdfPreviewFrame').attr('src', '');
    });
    // Tambah/Edit LoI (AJAX dummy, sesuaikan jika sudah ada endpoint)
    $('#formLoi').on('submit', function(e) {
        e.preventDefault();
        alert('Fitur simpan LoI belum diimplementasikan.');
        $('#addLoiModal').modal('hide');
    });
    // Edit LoI (AJAX dummy, sesuaikan jika sudah ada endpoint)
    $(document).on('click', '.btnEditLoi', function() {
        alert('Fitur edit LoI belum diimplementasikan.');
    });
    // Hapus LoI (AJAX dummy, sesuaikan jika sudah ada endpoint)
    $(document).on('click', '.btnDeleteLoi', function() {
        if(!confirm('Yakin hapus data ini?')) return;
        alert('Fitur hapus LoI belum diimplementasikan.');
    });
    </script>
</body>
</html> 