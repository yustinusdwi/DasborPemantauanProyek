@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data SPPH</title>
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
                <h4 class="mb-0 fw-bold">Tabel Data SPPH</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="spphTable">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor SPPH</th>
                            <th>Pelanggan</th>
                            <th>Kode - Nama Proyek</th>
                            <th>Tanggal</th>
                            <th>Batas Akhir SPH</th>
                            <th>Uraian</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($spphs as $index => $spph)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $spph->nomor_spph }}</td>
                                <td>{{ $spph->subkontraktor }}</td>
                                <td>{{ $spph->kode_proyek ?? '' }} - {{ $spph->nama_proyek ?? '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($spph->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($spph->batas_akhir_sph)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($spph->uraian, 50) }}</td>
                                <td>
                                    @php
                                        $dokumenSpph = json_decode($spph->dokumen_spph, true);
                                        $dokumenSow = json_decode($spph->dokumen_sow, true);
                                        $dokumenLain = json_decode($spph->dokumen_lain, true);
                                        $hasFile = false;
                                    @endphp
                                    @if($dokumenSpph && isset($dokumenSpph['path']))
                                        <div class="mb-1">
                                            <button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/'.$dokumenSpph['path']) }}">SPPH</button>
                                            <span>{{ $dokumenSpph['name'] ?? '' }}</span>
                                        </div>
                                        @php $hasFile = true; @endphp
                                    @endif
                                    @if($dokumenSow && isset($dokumenSow['path']))
                                        <div class="mb-1">
                                            <button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/'.$dokumenSow['path']) }}">SOW</button>
                                            <span>{{ $dokumenSow['name'] ?? '' }}</span>
                                        </div>
                                        @php $hasFile = true; @endphp
                                    @endif
                                    @if(is_array($dokumenLain))
                                        @foreach($dokumenLain as $file)
                                            @if(isset($file['path']))
                                                <div class="mb-1">
                                                    <button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/'.$file['path']) }}">Lainnya</button>
                                                    <span>{{ $file['name'] ?? '' }}</span>
                                                </div>
                                                @php $hasFile = true; @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                    @if(!$hasFile)
                                        <span class="badge bg-secondary">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editSpph({{ $spph->id }})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteSpph({{ $spph->id }})">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Edit SPPH -->
        <div class="modal fade" id="editSpphModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editSpphForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit SPPH</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Nomor SPPH</label>
                                <input type="text" name="nomor_spph" id="edit_nomor_spph" class="form-control" required>
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
                                <label>Batas Akhir SPH</label>
                                <input type="date" name="batas_akhir_sph" id="edit_batas_akhir_sph" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Uraian</label>
                                <input type="text" name="uraian" id="edit_uraian" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Berkas SPPH</label>
                                <input type="file" name="dokumen_spph" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label>Berkas SOW</label>
                                <input type="file" name="dokumen_sow" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label>Berkas Lainnya</label>
                                <input type="file" name="dokumen_lain[]" class="form-control" multiple>
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
    <div class="d-flex align-items-center justify-content-end small">
    <div class="text-muted">&copy; IT IMSS 2025</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(function() {
        $('#spphTable').DataTable();
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
  // Untuk semua input file di modal edit SPPH
  $(document).on('change', '#editSpphModal input[type="file"]', function() {
    var input = this;
    var $parent = $(input).parent();
    $parent.find('.file-action-btns').remove();
    // Multiple file (dokumen_lain[])
    if (input.multiple) {
      // Buat preview di bawah input
      var $preview = $parent.find('.file-action-preview');
      if ($preview.length === 0) {
        $preview = $('<div class="file-action-preview mt-2"></div>');
        $parent.append($preview);
      }
      $preview.html('');
      if (input.files && input.files.length > 0) {
        var filesArr = Array.from(input.files);
        filesArr.forEach(function(file, idx) {
          var fileRow = $('<div class="d-flex align-items-center mb-1 file-action-btns"></div>');
          fileRow.append('<span class="me-2">'+file.name+'</span>');
          // Tombol pratinjau
          var previewBtn = $('<button type="button" class="btn btn-sm btn-primary me-2"><i class="fa fa-eye"></i></button>');
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
          // Tombol hapus
          var removeBtn = $('<button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>');
          removeBtn.on('click', function(e) {
            e.preventDefault();
            var dt = new DataTransfer();
            filesArr.forEach(function(f, i) { if (i !== idx) dt.items.add(f); });
            input.files = dt.files;
            $(input).trigger('change');
          });
          fileRow.append(previewBtn).append(removeBtn);
          $preview.append(fileRow);
        });
      }
    } else {
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
    }
  });
});
    function editSpph(id) {
        fetch(`/admin/spph/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                $('#edit_nomor_spph').val(data.nomor_spph);
                $('#edit_subkontraktor').val(data.subkontraktor);
                $('#edit_kode_proyek').val(data.kode_proyek);
                $('#edit_nama_proyek').val(data.nama_proyek);
                $('#edit_tanggal').val(data.tanggal);
                $('#edit_batas_akhir_sph').val(data.batas_akhir_sph);
                $('#edit_uraian').val(data.uraian);
                $('#editSpphForm').attr('action', `/admin/spph/${id}`);
                var modal = new bootstrap.Modal(document.getElementById('editSpphModal'));
                modal.show();
            });
    }
    function deleteSpph(id) {
        if(confirm('Yakin hapus data ini?')) {
            fetch(`/admin/spph/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            })
            .then(res => res.json())
            .then(data => { if(data.success) location.reload(); });
        }
    }
    </script>
</body>
</html> 