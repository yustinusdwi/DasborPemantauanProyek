<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DASBOR ADMINISTRATOR</title>
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
        </ul>

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
                            <input type="text" name="uraian" class="form-control @error('uraian') is-invalid @enderror" value="{{ old('uraian') }}">
                            @error('uraian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Total (Rp)</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_total" class="form-control @error('harga_total') is-invalid @enderror" value="{{ old('harga_total') }}">
                            @error('harga_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                <form method="POST" action="{{ route('nego-store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor Negosiasi</label>
                        <div class="col-sm-9">
                            <input type="text" name="nomor_nego" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control">
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
                        <label class="col-sm-3 col-form-label">Berkas Negosiasi</label>
                        <div class="col-sm-9">
                            <input type="file" name="dokumen_nego" class="form-control">
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
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control">
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
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>