<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dasbor Pemantauan Proyek')</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Dashboard Styles -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <!-- <link href="{{ asset('css/modern-netflix.css') }}" rel="stylesheet" /> -->
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <!-- <link href="{{ asset('css/datatables-netflix.css') }}" rel="stylesheet" /> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .sb-sidenav-menu .nav-link {
                border-radius: 12px !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.03) !important;
                transition: box-shadow 0.2s, background 0.2s, border 0.2s, color 0.2s;
                border: 2px solid #fff !important;
                margin-bottom: 10px;
                background: #fff !important;
                color: #222 !important;
                font-weight: 700;
                padding: 12px 20px;
                width: 90%;
                max-width: 210px;
                margin-left: auto;
                margin-right: auto;
                box-sizing: border-box;
                display: flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                position: relative;
            }
            .sb-sidenav-menu .nav-link:hover,
            .sb-sidenav-menu .nav-link.active {
                background: #23272b !important;
                color: #fff !important;
                box-shadow: 0 4px 16px rgba(44,44,44,0.10) !important;
                border: 2px solid #23272b !important;
                text-decoration: none;
            }
            .sb-sidenav-menu .nav-link:focus {
                outline: none;
                box-shadow: 0 0 0 2px #23272b !important;
            }
            .sb-sidenav-menu .nav-link .sb-nav-link-icon {
                color: var(--primary-red) !important;
                font-size: 1.1em;
                min-width: 22px;
                height: 22px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 2px;
            }
            .sb-sidenav-menu .nav-link .sb-nav-link-icon + span,
            .sb-sidenav-menu .nav-link > span {
                flex: 1 1 auto;
                min-width: 0;
            }
            .sb-sidenav-menu .nav-link {
                user-select: none;
            }
            .sb-sidenav-menu .nav-link:active {
                background: #343a40 !important;
                color: #fff !important;
            }
            .sb-sidenav-menu .nav-link .sb-sidenav-collapse-arrow {
                margin-left: auto;
                color: var(--primary-red) !important;
            }
            .sb-sidenav-menu-nested .nav-link {
                width: 90%;
                max-width: 210px;
                margin-left: auto;
                margin-right: auto;
                border-radius: 10px !important;
                padding: 10px 18px;
                font-size: 0.97em;
            }
            /* Logout button styles */
            .logout-btn {
                background: linear-gradient(135deg, #dc3545, #c82333);
                border: none;
                color: white;
                padding: 8px 16px;
                border-radius: 20px;
                font-weight: 600;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 8px;
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
                padding: 8px 16px;
                border-radius: 20px;
                font-weight: 600;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 8px;
                margin-right: 10px;
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
                gap: 10px;
            }
            .user-info {
                color: #fff;
                font-weight: 600;
                font-size: 0.9rem;
                margin-right: 15px;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center" style="gap: 8px;">
                <a class="navbar-brand d-flex align-items-center p-0 m-0" href="{{ route('dashboard') }}">
                    <img src="{{ asset('img/logo_imss_hd-removebg.png') }}" alt="Logo IMSS Tanpa Latar Belakang" style="height:38px; width:auto; margin-right:0;">
                </a>
                <!-- Tombol garis bertumpuk vertikal untuk toggle sidebar -->
                <button class="btn btn-link btn-sm p-0 m-0" id="sidebarToggle" style="font-size: 1.5rem; color: #222; line-height:1;" title="Tutup/Buka Sidebar">
                    <span style="display: inline-block; line-height: 1;">
                        <span style="display: block; width: 24px; height: 3px; background: #222; margin: 4px 0; border-radius: 2px;"></span>
                        <span style="display: block; width: 24px; height: 3px; background: #222; margin: 4px 0; border-radius: 2px;"></span>
                        <span style="display: block; width: 24px; height: 3px; background: #222; margin: 4px 0; border-radius: 2px;"></span>
                    </span>
                </button>
            </div>
            <div class="d-flex align-items-center">
                <span class="user-info">
                    <i class="fas fa-user-circle me-2"></i>
                    {{ Auth::user()->username ?? 'User' }} ({{ Auth::user()->role ?? 'pengguna' }})
                </span>
                <div class="header-buttons">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin-landing') }}" class="back-landing-btn">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Halaman Utama
                        </a>
                    @endif
                    <!-- Logout button -->
                    <a href="#" onclick="showLogoutConfirmation()" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"><i class="fas fa-bars mr-2"></i>Menu Utama</div>
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dasbor
                            </a>
                            {{-- Hapus menu Notifikasi Proyek dari sidebar --}}
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMonitoring" aria-expanded="false" aria-controls="collapseMonitoring">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Pemantauan Proyek
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseMonitoring" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('spph.index') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                        SPPH
                                    </a>
                                    <a class="nav-link" href="{{ route('sph.index') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-signature"></i></div>
                                        SPH
                                    </a>
                                    <a class="nav-link" href="{{ route('nego.index') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-handshake"></i></div>
                                        Negosiasi
                                    </a>
                                    <a class="nav-link" href="{{ route('kontrak.index') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-contract"></i></div>
                                        Kontrak
                                    </a>
                                    <a class="nav-link" href="{{ route('bapp-internal-user') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                                        BAPP INTERNAL
                                    </a>
                                    <a class="nav-link" href="{{ route('bapp-eksternal-user') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                                        BAPP EKSTERNAL
                                    </a>
                                    <a class="nav-link" href="{{ route('loi.index') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-signature"></i></div>
                                        LoI
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Welcome </div>
                        {{ Auth::user()->username ?? 'Pengguna' }}
                    </div>
                </nav>
            </div>
            <div class="sb-sidenav-overlay"></div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>
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

        <!-- Dashboard Scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <!-- <script src="{{ asset('js/datatables-demo.js') }}"></script> -->
        <script src="{{ asset('js/dashboard-controller.js') }}"></script>
        
        <script>
            function showLogoutConfirmation() {
                $('#logoutModal').modal('show');
            }
        </script>
        
        @stack('scripts')
    </body>
</html>
