@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data SPH</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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
        <div class="card">
            <div class="card-header bg-white border-bottom-0">
                <h4 class="mb-0 fw-bold">Tabel Data SPH</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="sphTable">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor SPH</th>
                            <th>Pelanggan</th>
                            <th>Kode - Nama Proyek</th>
                            <th>Tanggal</th>
                            <th>Uraian</th>
                            <th>Harga Total</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                            <th>Tampilkan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sphs as $index => $sph)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sph->nomor_sph }}</td>
                                <td>{{ $sph->subkontraktor }}</td>
                                <td>{{ $sph->kode_proyek ?? '' }} - {{ $sph->nama_proyek ?? '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($sph->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($sph->uraian, 50) }}</td>
                                <td>Rp {{ number_format($sph->harga_total,0,',','.') }}</td>
                                <td>
                                    @php $dokumenSph = json_decode($sph->dokumen_sph, true); @endphp
                                    @if($dokumenSph && isset($dokumenSph['path']))
                                        <div class="mb-2">
                                            <small class="text-muted d-block">{{ $dokumenSph['name'] }}</small>
                                            <a href="#" class="btn btn-sm btn-primary preview-pdf-btn" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/' . $dokumenSph['path']) }}">
                                                <i class="fa-solid fa-eye"></i> Pratinjau
                                            </a>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editSph({{ $sph->id }})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteSph({{ $sph->id }})">Hapus</button>
                                </td>
                                <td>
                                    @if(!$sph->is_published)
                                        <button class="btn btn-success btn-sm" onclick="publishSph({{ $sph->id }}, this)">Tampilkan ke Pengguna</button>
                                    @else
                                        <span class="badge bg-primary">Sudah Tampil</span>
                                        <button class="btn btn-outline-danger btn-sm ms-2" onclick="unpublishSph({{ $sph->id }}, this)">Undo</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Edit SPH -->
        <div class="modal fade" id="editSphModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editSphForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit SPH</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Nomor SPH</label>
                                <input type="text" name="nomor_sph" id="edit_nomor_sph" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Pelanggan</label>
                                <input type="text" name="subkontraktor" id="edit_subkontraktor" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Kode - Nama Proyek</label>
                                <input type="text" name="kode_proyek" id="edit_kode_proyek" class="form-control" required>
                                <input type="text" name="nama_proyek" id="edit_nama_proyek" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Uraian</label>
                                <input type="text" name="uraian" id="edit_uraian" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Harga Total</label>
                                <input type="text" name="harga_total" id="edit_harga_total" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Berkas SPH</label>
                                <input type="file" name="dokumen_sph" class="form-control">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(function() {
        $('#sphTable').DataTable();
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
    });
    $(document).ready(function() {
  $(document).on('change', '#editSphModal input[type="file"]', function() {
    var input = this;
    var $parent = $(input).parent();
    $parent.find('.file-action-btns').remove();
    if (input.files && input.files.length > 0) {
      var file = input.files[0];
      var btns = $('<div class="file-action-btns mt-2"></div>');
      var previewBtn = $('<button type="button" class="btn btn-sm btn-primary me-2"><i class="fa fa-eye"></i> Pratinjau</button>');
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
      var removeBtn = $('<button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>');
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
    function editSph(id) {
        fetch(`/admin/sph/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                $('#edit_nomor_sph').val(data.nomor_sph);
                $('#edit_subkontraktor').val(data.subkontraktor);
                $('#edit_kode_proyek').val(data.kode_proyek);
                $('#edit_nama_proyek').val(data.nama_proyek);
                $('#edit_tanggal').val(data.tanggal);
                $('#edit_uraian').val(data.uraian);
                $('#edit_harga_total').val(data.harga_total);
                $('#editSphForm').attr('action', `/admin/sph/${id}`);
                var modal = new bootstrap.Modal(document.getElementById('editSphModal'));
                modal.show();
            });
    }
    function deleteSph(id) {
        if(confirm('Yakin hapus data ini?')) {
            fetch(`/admin/sph/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            })
            .then(res => res.json())
            .then(data => { if(data.success) location.reload(); });
        }
    }
    function publishSph(id, btn) {
        if(confirm('Tampilkan data ini ke pengguna?')) {
            fetch(`/admin/sph/${id}/publish`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Ganti tombol dengan badge dan tombol undo
                    btn.parentElement.innerHTML = '<span class="badge bg-primary">Sudah Tampil</span> <button class="btn btn-outline-danger btn-sm ms-2" onclick="unpublishSph('+id+', this)">Undo</button>';
                }
            });
        }
    }
    function unpublishSph(id, btn) {
        if(confirm('Tarik kembali data ini agar tidak tampil ke pengguna?')) {
            fetch(`/admin/sph/${id}/unpublish`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Ganti tombol dengan tombol tampilkan
                    btn.parentElement.innerHTML = '<button class="btn btn-success btn-sm" onclick="publishSph('+id+', this)">Tampilkan ke Pengguna</button>';
                }
            });
        }
    }
    </script>
    <div class="d-flex align-items-center justify-content-end small">
    <div class="text-muted">&copy; IT IMSS 2025</div>
</div>
</body>
</html> 