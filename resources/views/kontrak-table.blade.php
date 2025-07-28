@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kontrak</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .header-bar {
            background-color: #fff;
            padding: 15px 30px;
            border-bottom: 2px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-imss {
            height:36px;width:auto;margin-right:14px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="header-bar mb-4">
        <div class="d-flex align-items-center">
            <img src="/img/logo_imss_hd.jpg" alt="Logo IMSS" class="logo-imss">
            <span class="fw-bold fs-5">Administrator</span>
        </div>
        <a href="{{ route('admin') }}" class="btn btn-outline-secondary">Kembali ke Admin</a>
    </div>
    <div class="container py-4">
        <div class="card">
            <div class="card-header bg-white border-bottom-0">
                <h4 class="mb-0 fw-bold">Tabel Data Kontrak</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="kontrakTable">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor Kontrak</th>
                            <th>Pelanggan</th>
                            <th>Kode - Nama Proyek</th>
                            <th>Tanggal</th>
                            <th>Batas Akhir Kontrak</th>
                            <th>Uraian</th>
                            <th>Harga Total</th>
                            <th>LoI</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kontraks as $index => $kontrak)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kontrak->nomor_kontrak }}</td>
                                <td>{{ $kontrak->subkontraktor }}</td>
                                <td>{{ $kontrak->kode_proyek ?? '' }} - {{ $kontrak->nama_proyek ?? '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($kontrak->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($kontrak->batas_akhir_kontrak)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($kontrak->uraian, 50) }}</td>
                                <td>Rp {{ number_format($kontrak->harga_total,0,',','.') }}</td>
                                <td>
                                    @if($kontrak->loi)
                                        <span class="badge bg-info">{{ $kontrak->loi->nomor_loi }}</span>
                                        <br><small class="text-muted">{{ $kontrak->loi->nama_proyek }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php $dokumenKontrak = json_decode($kontrak->dokumen_kontrak, true); $hasFile = false; @endphp
                                    @if(is_array($dokumenKontrak) && isset($dokumenKontrak['path']))
                                        <button type="button" class="btn btn-sm btn-primary preview-kontrak-btn" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/'.$dokumenKontrak['path']) }}">Pratinjau</button>
                                        <span>{{ $dokumenKontrak['name'] ?? '' }}</span>
                                        @php $hasFile = true; @endphp
                                    @elseif(is_array($dokumenKontrak) && isset($dokumenKontrak[0]['path']))
                                        @foreach($dokumenKontrak as $file)
                                            @if(isset($file['path']))
                                                <div class="mb-1">
                                                    <button type="button" class="btn btn-sm btn-primary preview-kontrak-btn" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal" data-pdf-url="{{ asset('storage/'.$file['path']) }}">Pratinjau</button>
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
                                    <button class="btn btn-warning btn-sm" onclick="editKontrak({{ $kontrak->id }})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteKontrak({{ $kontrak->id }})">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Edit Kontrak -->
        <div class="modal fade" id="editKontrakModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editKontrakForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kontrak</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Nomor Kontrak</label>
                                <input type="text" name="nomor_kontrak" id="edit_nomor_kontrak" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Pelanggan</label>
                                <input type="text" name="subkontraktor" id="edit_subkontraktor" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Kode - Nama Proyek</label>
                                <input type="text" name="nama_proyek" id="edit_nama_proyek" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Batas Akhir Kontrak</label>
                                <input type="date" name="batas_akhir_kontrak" id="edit_batas_akhir_kontrak" class="form-control" required>
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
                                <label>LoI (Opsional)</label>
                                <select name="loi_id" id="edit_loi_id" class="form-control">
                                    <option value="">Pilih LoI (Opsional)</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>Berkas Kontrak</label>
                                <input type="file" name="dokumen_kontrak" class="form-control">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(function() {
        $('#kontrakTable').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": [9, 10] } // Kolom Dokumen dan Aksi tidak bisa di-sort
            ]
        });
        
        // Select2 untuk LoI di modal edit
        $('#edit_loi_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih LoI (Opsional)...',
            ajax: {
                url: '/admin/loi-data',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.map(function(item) {
                            return { 
                                id: item.id, 
                                text: item.nomor_loi + ' - ' + item.nama_proyek,
                                nomor_loi: item.nomor_loi,
                                nama_proyek: item.nama_proyek
                            };
                        })
                    };
                },
                cache: true
            },
            allowClear: true,
            width: '100%'
        });
        
        // Preview PDF
        $(document).on('click', '.preview-kontrak-btn', function(e) {
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
      $(document).on('change', '#editKontrakModal input[type="file"]', function() {
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
    function editKontrak(id) {
        fetch(`/admin/kontrak/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                $('#edit_nomor_kontrak').val(data.nomor_kontrak);
                $('#edit_subkontraktor').val(data.subkontraktor);
                $('#edit_nama_proyek').val(data.nama_proyek);
                $('#edit_tanggal').val(data.tanggal);
                $('#edit_batas_akhir_kontrak').val(data.batas_akhir_kontrak);
                $('#edit_uraian').val(data.uraian);
                $('#edit_harga_total').val(data.harga_total);
                
                // Set LoI jika ada
                if (data.loi_id && data.loi) {
                    var option = new Option(data.loi.nomor_loi + ' - ' + data.loi.nama_proyek, data.loi_id, true, true);
                    $('#edit_loi_id').append(option).trigger('change');
                } else {
                    $('#edit_loi_id').val('').trigger('change');
                }
                
                $('#editKontrakForm').attr('action', `/admin/kontrak/${id}`);
                var modal = new bootstrap.Modal(document.getElementById('editKontrakModal'));
                modal.show();
            });
    }
    function deleteKontrak(id) {
        if(confirm('Yakin hapus data ini?')) {
            fetch(`/admin/kontrak/${id}`, {
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