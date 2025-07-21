<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ADMINISTRATOR</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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

        .nav-tabs.binder-tabs {
            border-bottom: none;
        }

        .binder-tabs .nav-link {
            background: #e9ecef;
            border: 1px solid #dee2e6;
            border-bottom: none;
            margin-right: 5px;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            color: #555;
        }

        .binder-tabs .nav-link.active {
            background-color: #fff;
            font-weight: bold;
            border-color: #dee2e6 #dee2e6 #fff;
            color: #dc3545;
        }

        .panel-card {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        .btn-kirim-besar {
            background: #000;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 10px;
            padding: 0.75rem 2.5rem;
            margin-top: 2rem;
            border: none;
        }

        .btn-kirim-besar:hover {
            background: #222;
            color: #ffe066;
        }
    </style>
</head>

<body class="bg-light">
    <div class="header-bar">
        <div class="d-flex align-items-center">
            <img src="/img/logo_imss_hd.jpg" alt="Logo IMSS" style="height:36px;width:auto;margin-right:14px;">
            <span class="fw-bold fs-5">Administrator</span>
        </div>
    </div>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <ul class="nav nav-tabs binder-tabs mb-0" id="binderTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="spph-tab" data-bs-toggle="tab" data-bs-target="#spph" type="button" role="tab">SPPH</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="sph-tab" data-bs-toggle="tab" data-bs-target="#sph" type="button" role="tab">SPH</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="nego-tab" data-bs-toggle="tab" data-bs-target="#nego" type="button" role="tab">NEGOSIASI</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="kontrak-tab" data-bs-toggle="tab" data-bs-target="#kontrak" type="button" role="tab">KONTRAK</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="bapp-tab" data-bs-toggle="tab" data-bs-target="#bapp" type="button" role="tab">BAPP</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="loi-tab" data-bs-toggle="tab" data-bs-target="#loi" type="button" role="tab">LoI</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="tabel-tab" data-bs-toggle="tab" data-bs-target="#tabel" type="button" role="tab">KELOLA DATA</button>
            </li>
        </ul>

        <!-- Custom Notification -->
        <div id="custom-alert" style="display:none; position: fixed; top: 30px; right: 30px; z-index: 9999; min-width: 300px;"></div>

        <div class="tab-content panel-card" id="binderTabsContent">
            {{-- === SPPH === --}}
            <div class="tab-pane fade show active" id="spph" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA SPPH</h5>
                <form method="POST" action="{{ route('spph-store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor SPPH</label>
                        <div class="col-sm-9">
                            <input type="text" name="nomor_spph" class="form-control @error('nomor_spph') is-invalid @enderror" value="{{ old('nomor_spph') }}">
                            @error('nomor_spph')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Subkontraktor</label>
                        <div class="col-sm-9">
                            <input type="text" name="subkontraktor" class="form-control @error('subkontraktor') is-invalid @enderror" value="{{ old('subkontraktor') }}">
                            @error('subkontraktor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek') }}">
                            @error('nama_proyek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Batas Akhir SPH</label>
                        <div class="col-sm-9">
                            <input type="date" name="batas_akhir_sph" class="form-control @error('batas_akhir_sph') is-invalid @enderror" value="{{ old('batas_akhir_sph') }}">
                            @error('batas_akhir_sph')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian Pekerjaan/Perihal</label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" class="form-control @error('uraian') is-invalid @enderror" value="{{ old('uraian') }}">
                            @error('uraian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas SPPH</label>
                        <div class="col-sm-9">
                            <input type="file" name="dokumen_spph" class="form-control @error('dokumen_spph') is-invalid @enderror">
                            @error('dokumen_spph')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas SOW</label>
                        <div class="col-sm-9">
                            <input type="file" name="dokumen_sow" class="form-control @error('dokumen_sow') is-invalid @enderror">
                            @error('dokumen_sow')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas lainnya</label>
                        <div class="col-sm-9">
                            <input
                                type="file"
                                name="dokumen_lain[]"
                                class="form-control @error('dokumen_lain') is-invalid @enderror"
                                multiple
                                accept="application/pdf"
                                id="dokumen_lain_input"
                            >
                            <small class="text-muted">Pilih satu atau lebih berkas PDF. Tekan Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu berkas.</small>
                            @error('dokumen_lain')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="dokumen_lain_preview" class="mt-2"></div>
                        </div>
                    </div>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const input = document.getElementById('dokumen_lain_input');
                        const preview = document.getElementById('dokumen_lain_preview');
                        if (input) {
                            input.addEventListener('change', function() {
                                preview.innerHTML = '';
                                for (let i = 0; i < input.files.length; i++) {
                                    const file = input.files[i];
                                    const div = document.createElement('div');
                                    div.textContent = file.name;
                                    preview.appendChild(div);
                                }
                            });
                        }
                    });
                    </script>
                    <div class="text-center">
                        <button type="submit" class="btn-kirim-besar"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                    </div>
                </form>
            </div>

            {{-- === SPH === --}}
            <div class="tab-pane fade" id="sph" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA SPH</h5>
                <form method="POST" action="{{ route('sph-store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor SPH</label>
                        <div class="col-sm-9">
                            <input type="text" name="nomor_sph" class="form-control @error('nomor_sph') is-invalid @enderror" value="{{ old('nomor_sph') }}">
                            @error('nomor_sph')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Subkontraktor</label>
                        <div class="col-sm-9">
                            <input type="text" name="subkontraktor" class="form-control @error('subkontraktor') is-invalid @enderror" value="{{ old('subkontraktor') }}">
                            @error('subkontraktor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek') }}">
                            @error('nama_proyek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian Pekerjaan/Perihal</label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Total (Rp)</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_total" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas SPH</label>
                        <div class="col-sm-9">
                            <input type="file" name="dokumen_sph" class="form-control @error('dokumen_sph') is-invalid @enderror">
                            @error('dokumen_sph')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn-kirim-besar"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                    </div>
                </form>
            </div>

            {{-- === NEGOSIASI === --}}
            <div class="tab-pane fade" id="nego" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA NEGOSIASI</h5>
                <form method="POST" action="{{ route('nego.storeMain') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Subkontraktor</label>
                        <div class="col-sm-9">
                            <input type="text" name="subkontraktor" class="form-control @error('subkontraktor') is-invalid @enderror" value="{{ old('subkontraktor') }}">
                            @error('subkontraktor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek') }}">
                            @error('nama_proyek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian</label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" class="form-control @error('uraian') is-invalid @enderror" value="{{ old('uraian') }}">
                            @error('uraian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn-kirim-besar"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                    </div>
                </form>
            </div>

            {{-- === KONTRAK === --}}
            <div class="tab-pane fade" id="kontrak" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA KONTRAK</h5>
                <form method="POST" action="{{ route('kontrak-store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor Kontrak</label>
                        <div class="col-sm-9">
                            <input type="text" name="nomor_kontrak" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Subkontraktor</label>
                        <div class="col-sm-9">
                            <input type="text" name="subkontraktor" class="form-control @error('subkontraktor') is-invalid @enderror" value="{{ old('subkontraktor') }}">
                            @error('subkontraktor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek') }}">
                            @error('nama_proyek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Batas Akhir Kontrak</label>
                        <div class="col-sm-9">
                            <input type="date" name="batas_akhir_kontrak" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian Pekerjaan/Perihal</label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Total (Rp)</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_total" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas Kontrak</label>
                        <div class="col-sm-9">
                            <input type="file" name="dokumen_kontrak" class="form-control">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn-kirim-besar"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                    </div>
                </form>
            </div>

            {{-- === BAPP === --}}
            <div class="tab-pane fade" id="bapp" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA BAPP</h5>
                <form method="POST" action="{{ route('bapp.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor BAPP</label>
                        <div class="col-sm-9">
                            <input type="text" name="nomor_bapp" class="form-control @error('nomor_bapp') is-invalid @enderror" value="{{ old('nomor_bapp') }}">
                            @error('nomor_bapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor PO</label>
                        <div class="col-sm-9">
                            <input type="text" name="no_po" class="form-control @error('no_po') is-invalid @enderror" value="{{ old('no_po') }}">
                            @error('no_po')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal PO</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal_po" class="form-control @error('tanggal_po') is-invalid @enderror" value="{{ old('tanggal_po') }}">
                            @error('tanggal_po')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal Terima</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal_terima" class="form-control @error('tanggal_terima') is-invalid @enderror" value="{{ old('tanggal_terima') }}">
                            @error('tanggal_terima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek') }}">
                            @error('nama_proyek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas BAPP (PDF)</label>
                        <div class="col-sm-9">
                            <input type="file" name="berkas_bapp" class="form-control @error('berkas_bapp') is-invalid @enderror" accept="application/pdf">
                            @error('berkas_bapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn-kirim-besar"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                    </div>
                </form>
            </div>

            {{-- === DATA TABEL === --}}
            <div class="tab-pane fade" id="tabel" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA TABEL</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">SPPH</h6>
                            </div>
                            <div class="card-body">
                                <p>Tabel SPPH akan ditampilkan di sini.</p>
                                <a href="{{ route('spph-index') }}" class="btn btn-primary">Lihat SPPH</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">SPH</h6>
                            </div>
                            <div class="card-body">
                                <p>Tabel SPH akan ditampilkan di sini.</p>
                                <a href="{{ route('sph-index') }}" class="btn btn-primary">Lihat SPH</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">NEGOSIASI</h6>
                            </div>
                            <div class="card-body">
                                <p>Tabel NEGOSIASI akan ditampilkan di sini.</p>
                                <a href="{{ route('nego-index') }}" class="btn btn-primary">Lihat NEGOSIASI</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">KONTRAK</h6>
                            </div>
                            <div class="card-body">
                                <p>Tabel KONTRAK akan ditampilkan di sini.</p>
                                <a href="{{ route('kontrak-index') }}" class="btn btn-primary">Lihat KONTRAK</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">BAPP</h6>
                            </div>
                            <div class="card-body">
                                <p>Tabel BAPP akan ditampilkan di sini.</p>
                                <a href="{{ route('bapp-index') }}" class="btn btn-primary">Lihat BAPP</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">LoI</h6>
                            </div>
                            <div class="card-body">
                                <p>Tabel LoI akan ditampilkan di sini.</p>
                                <a href="{{ route('loi-index') }}" class="btn btn-primary">Lihat LoI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
    // Notifikasi custom
    function showCustomAlert(message, type) {
        const alertBox = document.getElementById('custom-alert');
        alertBox.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert" style="box-shadow:0 2px 8px rgba(0,0,0,0.15); font-weight:bold;">
            ${message}
        </div>`;
        alertBox.style.display = 'block';
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 2500);
    }

    // Tampilkan notifikasi jika ada pesan sukses/gagal dari session
    @if(session('success'))
        showCustomAlert(@json(session('success')), 'success');
    @endif
    @if($errors->any())
        showCustomAlert('Gagal menyimpan data. Mohon cek kembali isian Anda.', 'danger');
    @endif

    // Setelah submit BAPP, tetap di tab BAPP
    document.addEventListener('DOMContentLoaded', function() {
        // Jika hash #bapp di URL, aktifkan tab BAPP
        if(window.location.hash === '#bapp') {
            var bappTab = document.getElementById('bapp-tab');
            if(bappTab) {
                var tab = new bootstrap.Tab(bappTab);
                tab.show();
            }
        }
        // Jika submit form BAPP, tambahkan hash #bapp ke URL
        var bappForm = document.querySelector('form[action*="bapp.store"]');
        if(bappForm) {
            bappForm.addEventListener('submit', function() {
                window.location.hash = '#bapp';
            });
        }
    });
    </script>
</body>

</html>