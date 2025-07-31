@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Negosiasi</title>
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
        <div class="card mb-4">
            <div class="card-header bg-white border-bottom-0">
                <h4 class="mb-0 fw-bold">Tabel Data Negosiasi</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="negoTable">
                        <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Kode - Nama Proyek</th>
                            <th>Uraian</th>
                            <th>Negosiasi Masuk & Keluar</th>
                            <th>Hasil Negosiasi</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($negos as $index => $nego)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $nego->subkontraktor }}</td>
                                <td>{{ $nego->kode_proyek ?? '' }} - {{ $nego->nama_proyek ?? '' }}</td>
                                <td>{{ Str::limit($nego->uraian, 50) }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="showDetailNego({{ $nego->id }}, 'masuk')">Lihat Masuk</button>
                                    <button class="btn btn-secondary btn-sm" onclick="showDetailNego({{ $nego->id }}, 'keluar')">Lihat Keluar</button>
                                    <button class="btn btn-success btn-sm" onclick="showAddDetailNego({{ $nego->id }}, 'masuk')">Tambah Masuk</button>
                                    <button class="btn btn-success btn-sm" onclick="showAddDetailNego({{ $nego->id }}, 'keluar')">Tambah Keluar</button>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="showDetailNego({{ $nego->id }}, 'hasil')">Lihat Hasil</button>
                                    <button class="btn btn-success btn-sm" onclick="showAddDetailNego({{ $nego->id }}, 'hasil')">Tambah Hasil</button>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm btnEditNegoUtama" data-id="{{ $nego->id }}" data-subkontraktor="{{ $nego->subkontraktor }}" data-nama_proyek="{{ $nego->nama_proyek }}" data-uraian="{{ $nego->uraian }}">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteNego({{ $nego->id }})">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Nego Utama -->
        <div class="modal fade" id="addNegoModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('nego.storeMain') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Negosiasi Utama</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Pelanggan</label>
                                <input type="text" name="subkontraktor" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Nama - Kode Proyek</label>
                                <input type="text" name="nama_proyek" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Uraian</label>
                                <input type="text" name="uraian" class="form-control" required>
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
        <!-- Modal Tambah/Edit Detail Nego -->
        <div class="modal fade" id="addDetailNegoModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formDetailNego" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formDetailNegoTitle">Tambah Detail Negosiasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="nego_id" id="detail_nego_id">
                            <input type="hidden" name="tipe" id="detail_tipe">
                            <div class="mb-2">
                                <label>Nomor Negosiasi</label>
                                <input type="text" name="nomor_nego" id="detail_nomor_nego" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Pelanggan</label>
                                <input type="text" name="subkontraktor" id="detail_subkontraktor" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" id="detail_tanggal" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Harga Total</label>
                                <input type="text" name="harga_total" id="detail_harga_total" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Berkas Hasil Nego (PDF)</label>
                                <input type="file" name="dokumen_nego" id="detail_dokumen_nego" class="form-control">
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
        <!-- Modal Tabel Detail Nego -->
        <div class="modal fade" id="detailNegoModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Negosiasi (<span id="detailNegoTipe"></span>)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="detailNegoTableContainer"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        <!-- Modal Edit Nego Utama -->
        <div class="modal fade" id="editNegoUtamaModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formEditNegoUtama" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Negosiasi Utama</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_nego_id">
                            <div class="mb-2">
                                <label>Pelanggan</label>
                                <input type="text" name="subkontraktor" id="edit_subkontraktor" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Nama - Kode Proyek</label>
                                <input type="text" name="nama_proyek" id="edit_nama_proyek" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Uraian</label>
                                <input type="text" name="uraian" id="edit_uraian" class="form-control" required>
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
    <!-- Toast Notifikasi Global -->
    <div id="globalToast" class="toast align-items-center text-white border-0 position-fixed top-0 end-0 m-4" role="alert" aria-live="assertive" aria-atomic="true" style="z-index:9999;min-width:260px;display:none;">
      <div class="d-flex">
        <div class="toast-body" id="globalToastMsg"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" onclick="$('#globalToast').hide();"></button>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(function() {
        $('#negoTable').DataTable();
    });
    function showAddDetailNego(negoId, tipe) {
        // Tutup semua modal lain sebelum buka modal tambah/edit detail
        $('.modal').modal('hide');
        setTimeout(function() {
            $('#formDetailNego')[0].reset();
            $('#detail_nego_id').val(negoId);
            $('#detail_tipe').val(tipe);
            // Ambil pelanggan dari baris utama tabel
            var pelanggan = '';
            $('#negoTable tbody tr').each(function() {
                var idCell = $(this).find('button').first().attr('onclick');
                if (idCell && idCell.includes('showDetailNego(' + negoId + ',')) {
                    pelanggan = $(this).find('td').eq(1).text();
                }
            });
            $('#detail_subkontraktor').val(pelanggan);
            $('#formDetailNegoTitle').text('Tambah Detail Negosiasi ('+tipe+')');
            $('#addDetailNegoModal').modal('show');
        }, 400);
    }
    function showDetailNego(negoId, tipe) {
        // Tutup semua modal lain sebelum buka modal detail
        $('.modal').modal('hide');
        setTimeout(function() {
            $('#detailNegoTipe').text(tipe);
            $('#detailNegoTableContainer').html('<div class="text-center">Memuat data...</div>');
            $.get('/admin/nego/detail-by-project', { nego_id: negoId, tipe: tipe }, function(res) {
                var data = res.data.filter(function(item) { return item.tipe === tipe; });
                if(data.length > 0) {
                    var html = '<div class="table-responsive"><table class="table table-bordered">';
                    html += '<thead><tr><th>No</th><th>Nomor Negosiasi</th><th>Pelanggan</th><th>Tanggal</th><th>Harga Total</th><th>Berkas Hasil Nego</th><th>Aksi</th></tr></thead><tbody>';
                    data.forEach(function(item, idx) {
                        html += '<tr>';
                        html += '<td>' + (idx + 1) + '</td>';
                        html += '<td>' + (item.nomor_nego ?? '-') + '</td>';
                        html += '<td>' + (item.subkontraktor ?? '-') + '</td>';
                        html += '<td>' + (item.tanggal ? new Date(item.tanggal).toLocaleDateString('id-ID') : '-') + '</td>';
                        html += '<td>' + (item.harga_total ? Number(item.harga_total).toLocaleString('id-ID') : '-') + '</td>';
                        if(item.dokumen_nego && item.dokumen_nego.path) {
                            var fileUrl = "{{ asset('storage') }}/" + item.dokumen_nego.path;
                            html += '<td>' +
                                '<button type="button" class="btn btn-sm btn-primary preview-pdf-btn" data-pdf-url="' + fileUrl + '" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Pratinjau</button>' +
                                ' <span>' + (item.dokumen_nego.name ?? '') + '</span>' +
                                '</td>';
                        } else {
                            html += '<td><span class="badge bg-secondary">Tidak Ada</span></td>';
                        }
                        html += '<td>' +
                            '<button class="btn btn-warning btn-sm btnEditDetailNego" data-id="' + item.id + '" data-negoid="' + item.nego_id + '" data-tipe="' + item.tipe + '">Edit</button> ' +
                            '<button class="btn btn-danger btn-sm btnDeleteDetailNego" data-id="' + item.id + '">Hapus</button>' +
                            '</td>';
                        html += '</tr>';
                    });
                    html += '</tbody></table></div>';
                    $('#detailNegoTableContainer').html(html);
                } else {
                    $('#detailNegoTableContainer').html('<div class="alert alert-warning">Tidak ada data detail untuk tipe ini.</div>');
                }
                $('#detailNegoModal').modal('show');
            });
        }, 400);
    }
    function showGlobalToast(msg, type) {
        var toast = $('#globalToast');
        var toastMsg = $('#globalToastMsg');
        toast.removeClass('bg-success bg-danger').hide();
        if(type === 'success') toast.addClass('bg-success');
        else toast.addClass('bg-danger');
        toastMsg.text(msg);
        toast.fadeIn(200);
        setTimeout(function(){ toast.fadeOut(400); }, 2500);
    }
    // Handler submit form detail (tambah/edit)
    $('#formDetailNego').off('submit').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}');
        var editId = $(this).data('edit-id');
        var url = editId ? '/admin/nego/update-detail/' + editId : '/admin/nego/store-detail';
        var method = editId ? 'POST' : 'POST';
        if(editId) formData.append('_method', 'PUT');
        var negoId = $('#detail_nego_id').val();
        var tipe = $('#detail_tipe').val();
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'text',
            success: function(responseText) {
                var jsonStart = responseText.indexOf('{');
                var res = {};
                if (jsonStart !== -1) {
                    try { res = JSON.parse(responseText.substring(jsonStart)); } catch (e) { showGlobalToast('Gagal parsing response!', 'error'); return; }
                }
                if(res.success === false) { showGlobalToast(res.message || 'Gagal simpan detail!', 'error'); return; }
                if(res.success === true) {
                    showGlobalToast('Data detail berhasil disimpan!', 'success');
                    setTimeout(function() {
                        $('#addDetailNegoModal').modal('hide');
                        $('#formDetailNego').removeData('edit-id');
                        showDetailNego(negoId, tipe);
                    }, 900);
                } else {
                    showGlobalToast('Gagal simpan detail!', 'error');
                }
            },
            error: function(xhr) { showGlobalToast('Gagal simpan detail!', 'error'); }
        });
    });
    // Handler hapus detail
    $(document).on('click', '.btnDeleteDetailNego', function() {
        if(!confirm('Yakin hapus detail ini?')) return;
        var id = $(this).data('id');
        var negoId = $('#detail_nego_id').val();
        var tipe = $('#detail_tipe').val();
        $.ajax({
            url: '/admin/nego/delete-detail/' + id,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(res) {
                showGlobalToast('Data detail berhasil dihapus!', 'success');
                setTimeout(function() { showDetailNego(negoId, tipe); }, 900);
            },
            error: function(xhr) { showGlobalToast('Gagal hapus detail!', 'error'); }
        });
    });
    function deleteNego(id) {
        if(confirm('Yakin hapus data ini?')) {
            fetch(`/admin/nego/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            })
            .then(res => res.json())
            .then(data => { if(data.success) location.reload(); });
        }
    }
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
    // Handler tombol Edit detail
    $(document).on('click', '.btnEditDetailNego', function() {
        var id = $(this).data('id');
        $.get('/admin/nego/detail-by-id', { id: id }, function(res) {
            if(res.data && res.data.length > 0) {
                var item = res.data[0];
                $('#formDetailNego')[0].reset();
                $('#detail_nego_id').val(item.nego_id);
                $('#detail_tipe').val(item.tipe);
                $('#detail_nomor_nego').val(item.nomor_nego);
                $('#detail_subkontraktor').val(item.subkontraktor);
                $('#detail_tanggal').val(item.tanggal);
                $('#detail_harga_total').val(item.harga_total);
                $('#formDetailNego').data('edit-id', item.id);
                $('#formDetailNegoTitle').text('Edit Detail Negosiasi ('+item.tipe+')');
                $('#addDetailNegoModal').modal('show');
            }
        });
    });
    // Handler tombol Edit Nego Utama
    $(document).on('click', '.btnEditNegoUtama', function() {
        var id = $(this).data('id');
        var pelanggan = $(this).data('subkontraktor');
        var nama_proyek = $(this).data('nama_proyek');
        var uraian = $(this).data('uraian');
        $('#edit_nego_id').val(id);
        $('#edit_subkontraktor').val(pelanggan);
        $('#edit_nama_proyek').val(nama_proyek);
        $('#edit_uraian').val(uraian);
        $('#editNegoUtamaModal').modal('show');
    });
    // Handler submit form edit Nego Utama
    $('#formEditNegoUtama').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_nego_id').val();
        var data = {
            subkontraktor: $('#edit_subkontraktor').val(),
            nama_proyek: $('#edit_nama_proyek').val(),
            uraian: $('#edit_uraian').val(),
            _method: 'PUT',
            _token: '{{ csrf_token() }}'
        };
        $.ajax({
            url: '/admin/nego/update-main/' + id,
            type: 'POST',
            data: data,
            success: function(res) {
                showGlobalToast('Data utama berhasil diupdate!', 'success');
                setTimeout(function() { $('#editNegoUtamaModal').modal('hide'); location.reload(); }, 900);
            },
            error: function(xhr) { showGlobalToast('Gagal update data!', 'error'); }
        });
    });
    $(document).ready(function() {
      $(document).on('change', '#addDetailNegoModal input[type="file"]', function() {
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
    </script>
    <div class="d-flex align-items-center justify-content-end small">
        <div class="text-muted">&copy; IT IMSS 2025</div>
    </div>
</body>
</html> 