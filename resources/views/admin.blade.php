@section('title', 'Admin | SPPH')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MarkLens - Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .header-bar {
            background-color: #fff;
            padding: 8px 20px;
            border-bottom: 2px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

        /* Logout button styles */
        .logout-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            color: white;
            padding: 6px 14px;
            border-radius: 18px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .logout-btn:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
        }
        .logout-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);
        }

        /* Back to landing button styles */
        .back-landing-btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            color: white;
            padding: 6px 14px;
            border-radius: 18px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-right: 8px;
        }
        .back-landing-btn:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
        }
        .back-landing-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
        }

        .header-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Logo and text container improvements */
        .header-bar .d-flex {
            align-items: center;
            gap: 15px;
        }
        
        .header-bar .d-flex img {
            transition: all 0.3s ease;
        }
        
        .header-bar .d-flex span {
            color: #333;
            font-weight: 600;
        }
        
        /* Responsive header adjustments */
        @media (max-width: 768px) {
            .header-bar {
                padding: 8px 12px;
                flex-direction: column;
                gap: 12px;
            }
            
            .header-bar .d-flex {
                justify-content: center;
            }
            
            .header-bar img {
                height: 60px !important;
                margin-right: 8px !important;
            }
            
            .header-buttons {
                flex-direction: column;
                gap: 6px;
                width: 100%;
            }
            
            .back-landing-btn, .logout-btn {
                width: 100%;
                justify-content: center;
                font-size: 0.8rem;
                padding: 5px 10px;
            }
        }
        
        @media (max-width: 480px) {
            .header-bar img {
                height: 50px !important;
            }
            
            .fw-bold.fs-6 {
                font-size: 0.9rem !important;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="header-bar">
        <div class="d-flex align-items-center">
            <img src="/img/imssMARKLENS-logo.png" alt="Logo IMSS" style="height:80px; width:auto; margin-right:12px; margin-top:0;">
            <span class="fw-bold fs-6">Administrator</span>
        </div>
        <div class="header-buttons">
            <a href="{{ route('admin-landing') }}" class="back-landing-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Halaman Utama
            </a>
            <a href="#" onclick="showLogoutConfirmation()" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> 
                Logout
            </a>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Konfirmasi Logout
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">
                        <i class="fas fa-question-circle text-warning me-2"></i>
                        Apakah Anda yakin ingin keluar dari sistem?
                    </p>
                    <p class="text-muted small mt-2 mb-0">
                        Sesi Anda akan diakhiri dan Anda akan diarahkan ke halaman login.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Batal
                    </button>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Ya, Logout
                        </button>
                    </form>
                </div>
            </div>
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
                <button class="nav-link" id="bapp-internal-tab" data-bs-toggle="tab" data-bs-target="#bapp-internal" type="button" role="tab">BAPP INTERNAL</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="bapp-eksternal-tab" data-bs-toggle="tab" data-bs-target="#bapp-eksternal" type="button" role="tab">BAPP EKSTERNAL</button>
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
                            <input type="text" name="nomor_spph" class="form-control @error('nomor_spph') is-invalid @enderror" value="{{ old('nomor_spph') }}" required>
                            @error('nomor_spph')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pelanggan</label>
                        <div class="col-sm-9">
                            <input type="text" name="subkontraktor" class="form-control @error('subkontraktor') is-invalid @enderror" value="{{ old('subkontraktor') }}" required>
                            @error('subkontraktor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode - Nama Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek') }}" required>
                            @error('nama_proyek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Batas Akhir SPPH</label>
                        <div class="col-sm-9">
                            <input type="date" name="batas_akhir_spph" class="form-control @error('batas_akhir_spph') is-invalid @enderror" value="{{ old('batas_akhir_spph') }}" required>
                            @error('batas_akhir_spph')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian Pekerjaan/Perihal</label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" class="form-control @error('uraian') is-invalid @enderror" value="{{ old('uraian') }}" required>
                            @error('uraian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas SPPH</label>
                        <div class="col-sm-9">
                            <input type="file" name="dokumen_spph" class="form-control @error('dokumen_spph') is-invalid @enderror" required>
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
                            <input type="text" name="nomor_sph" class="form-control @error('nomor_sph') is-invalid @enderror" value="{{ old('nomor_sph') }}" required>
                            @error('nomor_sph')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pelanggan</label>
                        <div class="col-sm-9">
                            <input type="text" name="subkontraktor" id="sph_subkontraktor" class="form-control" readonly>
                            @error('subkontraktor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode - Nama Proyek</label>
                        <div class="col-sm-9">
                            <select id="sph_nama_proyek" name="nama_proyek" class="form-control select2-proyek" required></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian Pekerjaan/Perihal</label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" id="sph_uraian" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Total (Rp)</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_total" class="form-control @error('harga_total') is-invalid @enderror" value="{{ old('harga_total') }}" required placeholder="1000 (Terbaca sistem : Rp. 1.000)">
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
                <form method="POST" action="{{ route('nego.storeMain') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pelanggan</label>
                        <div class="col-sm-9">
                            <input type="text" name="subkontraktor" id="nego_subkontraktor" class="form-control" readonly>
                            @error('subkontraktor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode - Nama Proyek</label>
                        <div class="col-sm-9">
                            <select id="nego_nama_proyek" name="nama_proyek" class="form-control select2-proyek" required></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian</label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" id="nego_uraian" class="form-control" readonly required>
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
                            <input type="text" name="nomor_kontrak" class="form-control @error('nomor_kontrak') is-invalid @enderror" value="{{ old('nomor_kontrak') }}" required>
                            @error('nomor_kontrak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pelanggan</label>
                        <div class="col-sm-9">
                            <input type="text" name="subkontraktor" id="kontrak_subkontraktor" class="form-control" readonly>
                            @error('subkontraktor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode - Nama Proyek</label>
                        <div class="col-sm-9">
                            <select id="kontrak_nama_proyek" name="nama_proyek" class="form-control select2-proyek" required></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Batas Akhir Kontrak</label>
                        <div class="col-sm-9">
                            <input type="date" name="batas_akhir_kontrak" class="form-control @error('batas_akhir_kontrak') is-invalid @enderror" value="{{ old('batas_akhir_kontrak') }}" required>
                            @error('batas_akhir_kontrak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian</label>
                        <div class="col-sm-9">
                            <input type="text" name="uraian" id="kontrak_uraian" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Total (Rp)</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_total" class="form-control @error('harga_total') is-invalid @enderror" value="{{ old('harga_total') }}" required placeholder="1000 (Terbaca sistem : Rp. 1.000)">
                            @error('harga_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">LoI (Opsional)</label>
                        <div class="col-sm-9">
                            <select id="kontrak_loi_id" name="loi_id" class="form-control select2-loi">
                                <option value="">Pilih LoI (Opsional)</option>
                            </select>
                            @error('loi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas Kontrak (PDF)</label>
                        <div class="col-sm-9">
                            <input type="file" name="dokumen_kontrak" class="form-control @error('dokumen_kontrak') is-invalid @enderror" accept="application/pdf" required>
                            @error('dokumen_kontrak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn-kirim-besar"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                    </div>
                </form>
            </div>

            {{-- === BAPP INTERNAL === --}}
            <div class="tab-pane fade" id="bapp-internal" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA BAPP INTERNAL</h5>
                <form method="POST" action="{{ route('bapp.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="tipe" value="internal">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor BAPP</label>
                        <div class="col-sm-9">
                            <input type="text" name="nomor_bapp" class="form-control @error('nomor_bapp') is-invalid @enderror" value="{{ old('nomor_bapp') }}" required>
                            @error('nomor_bapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor PO</label>
                        <div class="col-sm-9">
                            <input type="text" name="no_po" class="form-control @error('no_po') is-invalid @enderror" value="{{ old('no_po') }}" required>
                            @error('no_po')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal PO</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal_po" class="form-control @error('tanggal_po') is-invalid @enderror" value="{{ old('tanggal_po') }}" required>
                            @error('tanggal_po')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal Terima</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal_terima" class="form-control @error('tanggal_terima') is-invalid @enderror" value="{{ old('tanggal_terima') }}" required>
                            @error('tanggal_terima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode - Nama Proyek</label>
                        <div class="col-sm-9">
                            <select id="bapp_nama_proyek" name="nama_proyek" class="form-control select2-proyek" required></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Total</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_total" class="form-control @error('harga_total') is-invalid @enderror" value="{{ old('harga_total') }}" required placeholder="1000 (Terbaca sistem : Rp. 1.000)">
                            @error('harga_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas BAPP (PDF, max 200MB, bisa lebih dari 1)</label>
                        <div class="col-sm-9">
                            <input type="file" name="berkas_bapp[]" class="form-control @error('berkas_bapp') is-invalid @enderror" accept="application/pdf" multiple required>
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
            {{-- === BAPP EKSTERNAL === --}}
            <div class="tab-pane fade" id="bapp-eksternal" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA BAPP EKSTERNAL</h5>
                <form method="POST" action="{{ route('bapp.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="tipe" value="eksternal">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor BAPP</label>
                        <div class="col-sm-9">
                            <input type="text" name="nomor_bapp" class="form-control @error('nomor_bapp') is-invalid @enderror" value="{{ old('nomor_bapp') }}" required>
                            @error('nomor_bapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor PO</label>
                        <div class="col-sm-9">
                            <input type="text" name="no_po" class="form-control @error('no_po') is-invalid @enderror" value="{{ old('no_po') }}" required>
                            @error('no_po')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal PO</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal_po" class="form-control @error('tanggal_po') is-invalid @enderror" value="{{ old('tanggal_po') }}" required>
                            @error('tanggal_po')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal Terima</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal_terima" class="form-control @error('tanggal_terima') is-invalid @enderror" value="{{ old('tanggal_terima') }}" required>
                            @error('tanggal_terima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode - Nama Proyek</label>
                        <div class="col-sm-9">
                            <select id="bapp_nama_proyek_eksternal" name="nama_proyek" class="form-control select2-proyek" required></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Total</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_total" class="form-control @error('harga_total') is-invalid @enderror" value="{{ old('harga_total') }}" required placeholder="1000 (Terbaca sistem : Rp. 1.000)">
                            @error('harga_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas BAPP (PDF, max 200MB, bisa lebih dari 1)</label>
                        <div class="col-sm-9">
                            <input type="file" name="berkas_bapp[]" class="form-control @error('berkas_bapp') is-invalid @enderror" accept="application/pdf" multiple required>
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

            {{-- === LoI === --}}
            <div class="tab-pane fade" id="loi" role="tabpanel">
                <h5 class="mb-4 fw-bold">DATA LoI</h5>
                <form method="POST" action="{{ route('loi-store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nomor LoI</label>
                        <div class="col-sm-9">
                            <input type="text" name="nomor_loi" class="form-control @error('nomor_loi') is-invalid @enderror" value="{{ old('nomor_loi') }}" required>
                            @error('nomor_loi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Batas Akhir LoI</label>
                        <div class="col-sm-9">
                            <input type="date" name="batas_akhir_loi" class="form-control @error('batas_akhir_loi') is-invalid @enderror" value="{{ old('batas_akhir_loi') }}" required>
                            @error('batas_akhir_loi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">No PO</label>
                        <div class="col-sm-9">
                            <input type="text" name="no_po" class="form-control @error('no_po') is-invalid @enderror" value="{{ old('no_po') }}">
                            @error('no_po')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kontrak</label>
                        <div class="col-sm-9">
                            <select id="loi_kontrak_id" name="kontrak_id" class="form-control select2-kontrak" required>
                                <option value="">Pilih Kontrak</option>
                            </select>
                            @error('kontrak_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode - Nama Proyek</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama_proyek" id="loi_nama_proyek" class="form-control" readonly required>
                            @error('nama_proyek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Harga Total (Rp)</label>
                        <div class="col-sm-9">
                            <input type="text" name="harga_total" id="loi_harga_total" class="form-control" readonly required>
                            @error('harga_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Berkas LoI (PDF)</label>
                        <div class="col-sm-9">
                            <input type="file" name="berkas_loi" class="form-control @error('berkas_loi') is-invalid @enderror" accept="application/pdf">
                            @error('berkas_loi')
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
                                <h6 class="mb-0">BAPP INTERNAL</h6>
                            </div>
                            <div class="card-body">
                                <p>Tabel BAPP INTERNAL akan ditampilkan di sini.</p>
                                <a href="{{ route('bapp-internal-admin') }}" class="btn btn-primary">Lihat BAPP INTERNAL</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">BAPP EKSTERNAL</h6>
                            </div>
                            <div class="card-body">
                                <p>Tabel BAPP EKSTERNAL akan ditampilkan di sini.</p>
                                <a href="{{ route('bapp-eksternal-admin') }}" class="btn btn-primary">Lihat BAPP EKSTERNAL</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
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

    <!-- Bootstrap JS dan plugin -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        function formatProyek(proyek) {
            if (!proyek.id) return proyek.text;
            return proyek.text + (proyek.uraian ? ' — ' + proyek.uraian : '');
        }
        function proyekSelectInit(selector, uraianSelector, subkonSelector) {
            $(selector).select2({
                theme: 'bootstrap-5',
                placeholder: 'Cari Kode - Nama Proyek...',
                ajax: {
                    url: '/admin/spph/projects',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data.map(function(item) {
                                return { id: item.nama_proyek, text: item.nama_proyek, uraian: item.uraian, subkontraktor: item.subkontraktor };
                            })
                        };
                    },
                    cache: true
                },
                templateResult: formatProyek,
                templateSelection: formatProyek,
                allowClear: true,
                width: '100%'
            }).on('select2:select', function(e) {
                var data = e.params.data;
                if (uraianSelector) {
                    $(uraianSelector).val(data.uraian || '');
                }
                if (subkonSelector) {
                    $(subkonSelector).val(data.subkontraktor || '');
                }
            }).on('select2:clear', function(e) {
                if (uraianSelector) {
                    $(uraianSelector).val('');
                }
                if (subkonSelector) {
                    $(subkonSelector).val('');
                }
            });
        }
        // SPH
        proyekSelectInit('#sph_nama_proyek', '#sph_uraian', '#sph_subkontraktor');
        // Negosiasi
        proyekSelectInit('#nego_nama_proyek', '#nego_uraian', '#nego_subkontraktor');
        // Kontrak
        proyekSelectInit('#kontrak_nama_proyek', '#kontrak_uraian', '#kontrak_subkontraktor');
        proyekSelectInit('#bapp_nama_proyek', null, null); // untuk internal
        proyekSelectInit('#bapp_nama_proyek_eksternal', null, null); // untuk eksternal
        
        // LoI Kontrak Select
        $('#loi_kontrak_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Kontrak...',
            ajax: {
                url: '/admin/kontrak-data',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.map(function(item) {
                            return { 
                                id: item.id, 
                                text: item.nomor_kontrak + ' - ' + item.nama_proyek,
                                nama_proyek: item.nama_proyek,
                                harga_total: item.harga_total
                            };
                        })
                    };
                },
                cache: true
            },
            allowClear: true,
            width: '100%'
        }).on('select2:select', function(e) {
            var data = e.params.data;
            $('#loi_nama_proyek').val(data.nama_proyek || '');
            $('#loi_harga_total').val(data.harga_total || '');
        }).on('select2:clear', function(e) {
            $('#loi_nama_proyek').val('');
            $('#loi_harga_total').val('');
        });
        
        // Kontrak LoI Select
        $('#kontrak_loi_id').select2({
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
    });
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
    <!-- Tambahkan modal preview PDF global di akhir file -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="pdfPreviewModalLabel">Pratinjau Dokumen PDF</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
          </div>
          <div class="modal-body">
            <iframe id="pdfPreviewFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
          </div>
        </div>
      </div>
    </div>
    <script>
    $(document).ready(function() {
      // Untuk semua input file di form admin
      $(document).on('change', 'input[type="file"]', function() {
        var input = this;
        var $parent = $(input).closest('.col-sm-9');
        $parent.find('.file-action-btns').remove();
        // Multiple file
        if (input.multiple) {
          var $preview = $('#dokumen_lain_preview');
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
                // Buat DataTransfer baru tanpa file ini
                var dt = new DataTransfer();
                filesArr.forEach(function(f, i) {
                  if (i !== idx) dt.items.add(f);
                });
                input.files = dt.files;
                $(input).trigger('change'); // refresh preview
              });
              fileRow.append(previewBtn).append(removeBtn);
              $preview.append(fileRow);
            });
          }
        } else {
          if (input.files && input.files.length > 0) {
            var file = input.files[0];
            var btns = $('<div class="file-action-btns mt-2"></div>');
            // Tombol pratinjau
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
            // Tombol hapus
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
      // Untuk input file multiple BAPP
      $(document).on('change', 'input[name="berkas_bapp[]"]', function() {
        var input = this;
        var $parent = $(input).closest('.col-sm-9');
        $parent.find('.file-action-btns').remove();
        var $preview = $parent.find('.file-action-preview');
        if ($preview.length === 0) {
          $preview = $('<div class="file-action-preview mt-2"></div>');
          $parent.append($preview);
        }
        $preview.html('');
        if (input.files && input.files.length > 0) {
          var filesArr = Array.from(input.files);
          filesArr.forEach(function(file, idx) {
            if (file.size > 200 * 1024 * 1024) {
              alert('Ukuran file "' + file.name + '" melebihi 200MB!');
              return;
            }
            var fileRow = $('<div class="d-flex align-items-center mb-1 file-action-btns"></div>');
            fileRow.append('<span class="me-2">'+file.name+'</span>');
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
      });
    });
    </script>
    <script>
$(document).ready(function() {
  // Untuk semua input file multiple di form admin (dokumen_lain[], berkas_bapp[])
  var fileBufferMap = {};
  function handleMultiFileInput(input) {
    var name = input.name;
    if (!fileBufferMap[name]) fileBufferMap[name] = [];
    var $parent = $(input).closest('.col-sm-9');
    $parent.find('.file-action-btns').remove();
    var $preview = $parent.find('.file-action-preview');
    if ($preview.length === 0) {
      $preview = $('<div class="file-action-preview mt-2"></div>');
      $parent.append($preview);
    }
    // Tambah file baru ke buffer
    if (input.files && input.files.length > 0) {
      var newFiles = Array.from(input.files);
      // Cek duplikat nama file
      newFiles.forEach(function(file) {
        if (!fileBufferMap[name].some(f => f.name === file.name && f.size === file.size)) {
          fileBufferMap[name].push(file);
        }
      });
    }
    // Reset input
    input.value = '';
    // Render preview
    $preview.html('');
    fileBufferMap[name].forEach(function(file, idx) {
      var fileRow = $('<div class="d-flex align-items-center mb-1 file-action-btns"></div>');
      fileRow.append('<span class="me-2">'+file.name+'</span>');
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
      var removeBtn = $('<button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>');
      removeBtn.on('click', function(e) {
        e.preventDefault();
        fileBufferMap[name].splice(idx, 1);
        updateInputFiles(input, name);
        handleMultiFileInput(input);
      });
      fileRow.append(previewBtn).append(removeBtn);
      $preview.append(fileRow);
    });
    // Update input files
    updateInputFiles(input, name);
  }
  function updateInputFiles(input, name) {
    var dt = new DataTransfer();
    (fileBufferMap[name]||[]).forEach(function(f) { dt.items.add(f); });
    input.files = dt.files;
  }
  // Handler untuk dokumen_lain[] dan berkas_bapp[]
  $(document).on('change', 'input[type="file"][multiple]', function() {
    handleMultiFileInput(this);
  });
});
</script>
    <div class="d-flex align-items-center justify-content-end small">
        <div class="text-muted">&copy; IT IMSS 2025</div>
    </div>

    <script>
        function showLogoutConfirmation() {
            $('#logoutModal').modal('show');
        }
    </script>
</body>

</html>