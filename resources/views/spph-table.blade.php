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
                            <th>Subkontraktor</th>
                            <th>Nama Proyek</th>
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
                                <td>{{ $spph->nama_proyek }}</td>
                                <td>{{ \Carbon\Carbon::parse($spph->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($spph->batas_akhir_sph)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($spph->uraian, 50) }}</td>
                                <td>
                                    @php
                                        $dokumenSpph = json_decode($spph->dokumen_spph, true);
                                        $dokumenSow = json_decode($spph->dokumen_sow, true);
                                        $dokumenLain = json_decode($spph->dokumen_lain, true);
                                    @endphp
                                    @if(!empty($dokumenSpph) || !empty($dokumenSow) || !empty($dokumenLain))
                                        <span class="badge bg-success">Ada</span>
                                    @else
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
                                <label>Subkontraktor</label>
                                <input type="text" name="subkontraktor" id="edit_subkontraktor" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Nama Proyek</label>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(function() {
        $('#spphTable').DataTable();
    });
    function editSpph(id) {
        fetch(`/admin/spph/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                $('#edit_nomor_spph').val(data.nomor_spph);
                $('#edit_subkontraktor').val(data.subkontraktor);
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