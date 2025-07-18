<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dasbor Pemantauan Proyek</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Dashboard Styles -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/modern-netflix.css') }}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="{{ asset('css/datatables-netflix.css') }}" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .sb-sidenav-menu .nav-link {
                border-radius: 12px !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.03) !important;
                transition: box-shadow 0.2s, background 0.2s, border 0.2s;
                border: 2px solid #fff !important;
                margin: 0 auto 10px auto;
                background: #fff !important;
                color: #222 !important;
                font-weight: 700;
                padding: 12px 20px;
                width: calc(100% - 16px);
                box-sizing: border-box;
                display: flex;
                align-items: center;
            }
            .sb-sidenav-menu .nav-link:hover,
            .sb-sidenav-menu .nav-link.active {
                background: #fff !important;
                color: #222 !important;
                box-shadow: 0 4px 16px rgba(230,0,18,0.10) !important;
                border: 2px solid var(--primary-red) !important;
            }
            .sb-sidenav-menu .nav-link .sb-nav-link-icon {
                color: var(--primary-red) !important;
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
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('dashboard') }}">Refresh Dashboard</a>
                    </div>
                </li>
            </ul>
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
                                    <a class="nav-link" href="{{ route('bapp.index') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                                        BAPP
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Welcome </div>
                        Pengguna
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
        <!-- Dashboard Scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables-demo.js') }}"></script>
        <script src="{{ asset('js/dashboard-controller.js') }}"></script>
        @stack('scripts')
    </body>
</html>
