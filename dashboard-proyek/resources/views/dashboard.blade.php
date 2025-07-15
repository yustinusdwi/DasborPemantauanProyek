<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dasbor Pemantauan Proyek</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/modern-netflix.css') }}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="{{ asset('css/datatables-netflix.css') }}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        
        <style>
            :root {
                --primary-red: #E60012;
                --primary-black: #000000;
                --primary-white: #FFFFFF;
                --light-gray: #f8f9fa;
                --border-gray: #dee2e6;
                --text-dark: #000000;
                --text-muted: #6c757d;
            }
            
            body {
                background-color: var(--primary-white);
                color: var(--text-dark);
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            /* Navbar Styling */
            .sb-topnav {
                background-color: var(--primary-white);
                border-bottom: 2px solid var(--primary-black);
            }
            
            .navbar-brand {
                font-weight: bold;
                font-size: 1.5rem;
                color: var(--primary-black);
            }
            
            /* Sidebar Styling */
            #layoutSidenav_nav {
                background: var(--primary-white);
                border-right: 2px solid var(--border-gray);
            }
            
            .sb-sidenav {
                background: var(--primary-white);
            }
            
            .sb-sidenav-menu-heading {
                color: var(--primary-black);
                font-weight: 800;
                font-size: 1rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 1rem 1rem 0.5rem 1rem;
                border-bottom: 2px solid var(--border-gray);
                margin-bottom: 0.5rem;
            }
            
            .sb-sidenav-menu .nav-link {
                color: var(--primary-black) !important;
                background: var(--primary-white);
                border-radius: 8px;
                margin: 2px 0.5rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                font-size: 1.05rem;
                letter-spacing: 0.2px;
                border: 1px solid transparent;
            }
            
            .sb-sidenav-menu .nav-link .sb-nav-link-icon {
                color: var(--primary-black) !important;
                margin-right: 10px;
                font-size: 1.2rem;
            }
            
            .sb-sidenav-menu .nav-link:hover,
            .sb-sidenav-menu .nav-link.active {
                background-color: var(--light-gray);
                color: var(--primary-black) !important;
                border: 1px solid var(--border-gray);
            }
            
            .sb-sidenav-menu .nav-link:hover .sb-nav-link-icon,
            .sb-sidenav-menu .nav-link.active .sb-nav-link-icon {
                color: var(--primary-black) !important;
            }
            
            .sb-sidenav-menu-nested .nav-link {
                padding-left: 2.5rem;
                font-size: 0.98rem;
                color: var(--primary-black) !important;
                font-weight: 600;
            }
            
            .sb-sidenav-footer {
                background: var(--light-gray);
                border-top: 2px solid var(--border-gray);
                color: var(--text-muted);
            }
            
            /* Card Styling */
            .card {
                background: var(--primary-white);
                border: 2px solid var(--border-gray);
                border-radius: 12px;
            }
            
            .card-header {
                background-color: var(--primary-red);
                color: var(--primary-white);
                border-radius: 10px 10px 0 0;
                font-weight: 600;
                padding: 1rem 1.25rem;
                border-bottom: 2px solid var(--primary-black);
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            /* Dashboard Cards */
            .bg-primary {
                background-color: var(--primary-red);
                border: 2px solid var(--primary-black);
            }
            
            .bg-warning {
                background-color: #ffc107;
                color: var(--primary-black);
                border: 2px solid #e0a800;
            }
            
            .bg-success {
                background-color: #28a745;
                border: 2px solid #1e7e34;
            }
            
            .bg-danger {
                background-color: #dc3545;
                border: 2px solid #c82333;
            }
            
            /* Progress Bar */
            .progress {
                height: 20px;
                margin-bottom: 0;
                background-color: var(--light-gray);
                border-radius: 10px;
                overflow: hidden;
                border: 1px solid var(--border-gray);
            }
            
            .progress-bar {
                line-height: 20px;
                font-size: 12px;
                font-weight: 600;
                background-color: var(--primary-red);
                border-radius: 9px;
            }
            
            .progress-bar.bg-danger {
                background-color: #dc3545;
            }
            
            /* Badge Styling */
            .badge {
                font-size: 11px;
                padding: 6px 10px;
                border-radius: 20px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border: 1px solid transparent;
            }
            
            .badge-success {
                background-color: #28a745;
                color: var(--primary-white);
                border-color: #1e7e34;
            }
            
            .badge-warning {
                background-color: #ffc107;
                color: var(--primary-black);
                border-color: #e0a800;
            }
            
            .badge-secondary {
                background-color: #6c757d;
                color: var(--primary-white);
                border-color: #545b62;
            }
            
            .badge-danger {
                background-color: #dc3545;
                color: var(--primary-white);
                border-color: #c82333;
            }
            
            /* Button Styling */
            .btn {
                border-radius: 8px;
                font-weight: 600;
                border: 2px solid transparent;
            }
            
            .btn-primary {
                background-color: var(--primary-red);
                border-color: var(--primary-black);
                color: var(--primary-white);
            }
            
            .btn-secondary {
                background-color: #6c757d;
                border-color: #545b62;
                color: var(--primary-white);
            }
            
            .btn-info {
                background-color: #17a2b8;
                border-color: #138496;
                color: var(--primary-white);
            }
            
            .btn-warning {
                background-color: #ffc107;
                border-color: #e0a800;
                color: var(--primary-black);
            }
            
            .btn-sm {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                margin: 2px;
                border-radius: 6px;
            }
            
            /* Table Styling */
            .table {
                background: var(--primary-white);
                border-radius: 8px;
                overflow: hidden;
                border: 2px solid var(--border-gray);
            }
            
            .table thead th {
                background-color: var(--primary-red);
                color: var(--primary-white);
                border: none;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.5px;
                padding: 1rem 0.75rem;
                border-bottom: 2px solid var(--primary-black);
            }
            
            .table tbody tr:hover {
                background-color: var(--light-gray);
            }
            
            .table tbody td {
                border-color: var(--border-gray);
                padding: 1rem 0.75rem;
                vertical-align: middle;
                color: var(--primary-black);
            }
            
            /* Form Styling */
            .form-control {
                border: 2px solid var(--border-gray);
                border-radius: 8px;
                padding: 0.75rem 1rem;
                background-color: var(--primary-white);
                color: var(--primary-black);
            }
            
            .form-control:focus {
                border-color: var(--primary-red);
                background-color: var(--primary-white);
                color: var(--primary-black);
            }
            
            .form-group label {
                font-weight: 600;
                color: var(--primary-black);
                margin-bottom: 0.5rem;
            }
            
            /* Breadcrumb Styling */
            .breadcrumb {
                background: var(--light-gray);
                border-radius: 8px;
                padding: 0.75rem 1rem;
                border: 2px solid var(--border-gray);
            }
            
            .breadcrumb-item a {
                color: var(--primary-red);
                text-decoration: none;
                font-weight: 600;
            }
            
            .breadcrumb-item.active {
                color: var(--text-muted);
            }
            
            /* DataTables Styling */
            .dataTables_wrapper {
                background: var(--primary-white);
                border-radius: 8px;
                padding: 1rem;
                border: 2px solid var(--border-gray);
            }
            
            .dataTables_length select,
            .dataTables_filter input {
                border: 2px solid var(--border-gray);
                border-radius: 6px;
                padding: 0.5rem;
                background-color: var(--primary-white);
                color: var(--primary-black);
            }
            
            .dataTables_length select:focus,
            .dataTables_filter input:focus {
                border-color: var(--primary-red);
                color: var(--primary-black);
            }
            
            .dataTables_paginate .paginate_button {
                border-radius: 6px;
                margin: 0 2px;
                border: 2px solid var(--border-gray);
                background: var(--primary-white);
                color: var(--primary-black);
            }
            
            .dataTables_paginate .paginate_button.current {
                background: var(--primary-red);
                color: var(--primary-white);
                border-color: var(--primary-black);
            }
            
            /* Main Content Area */
            #layoutSidenav_content {
                background: var(--light-gray);
                min-height: 100vh;
            }
            
            .container-fluid {
                padding: 2rem;
            }
            
            /* Responsive Design */
            @media (max-width: 768px) {
                .container-fluid {
                    padding: 1rem;
                }
                
                .card-body {
                    padding: 1rem;
                }
                
                .btn-sm {
                    padding: 0.25rem 0.5rem;
                    font-size: 0.8rem;
                }
            }
            
            /* Animation Effects */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .card, .table {
                animation: fadeIn 0.5s ease-out;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('img/logo_imss_hd.jpg') }}" alt="IMSS Logo" style="height:38px; width:auto; margin-right:10px;">
            </a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
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
                                <div class="sb-sidenav-menu-heading">Menu Utama</div>
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMonitoring" aria-expanded="false" aria-controls="collapseMonitoring">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                    Monitoring
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                                <div class="collapse" id="collapseMonitoring" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="#" onclick="showDataProyekSection()">Data Proyek</a>
                                        <a class="nav-link" href="#" onclick="showFilterDataSection()">Cari Data Proyek</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Welcome to:</div>
                        Dasbor Pemantauan Proyek
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 id="totalProducts">6</h4>
                                                <div>Total Proyek</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-project-diagram fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" onclick="showDataProyekSection()">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 id="totalSales">3</h4>
                                                <div>Proyek Aktif</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-play-circle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" onclick="showDataProyekSection()">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 id="totalOrders">1</h4>
                                                <div>Proyek Selesai</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-check-circle fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" onclick="showDataProyekSection()">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 id="totalRevenue">Rp 5.15M</h4>
                                                <div>Total Nilai Kontrak</div>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-money-bill-wave fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#" onclick="showDataProyekSection()">Lihat Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        Progress Proyek per Bulan
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Status Proyek
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Ringkasan Data Proyek
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nama Proyek</th>
                                                <th>Status</th>
                                                <th>Progress</th>
                                                <th>Estimasi Nilai</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <!-- <tfoot>
                                            <tr>
                                                <th>Nama Proyek</th>
                                                <th>Status</th>
                                                <th>Progress</th>
                                                <th>Estimasi Nilai</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot> -->
                                        <tbody>
                                            <tr>
                                                <td>Pembangunan Gedung A</td>
                                                <td><span class="badge badge-success">Aktif</span></td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 75%">75%</div>
                                                    </div>
                                                </td>
                                                <td>Rp 500.000.000</td>
                                                <td>2024-01-15</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info">Detail</button>
                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Renovasi Kantor B</td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 25%">25%</div>
                                                    </div>
                                                </td>
                                                <td>Rp 250.000.000</td>
                                                <td>2024-02-20</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info">Detail</button>
                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Instalasi Sistem IT</td>
                                                <td><span class="badge badge-success">Aktif</span></td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 90%">90%</div>
                                                    </div>
                                                </td>
                                                <td>Rp 150.000.000</td>
                                                <td>2024-03-10</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info">Detail</button>
                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pembangunan Jembatan</td>
                                                <td><span class="badge badge-secondary">Selesai</span></td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 100%">100%</div>
                                                    </div>
                                                </td>
                                                <td>Rp 1.000.000.000</td>
                                                <td>2024-01-05</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info">Detail</button>
                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pembangunan Mall</td>
                                                <td><span class="badge badge-danger">Dibatalkan</span></td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 10%">10%</div>
                                                    </div>
                                                </td>
                                                <td>Rp 2.500.000.000</td>
                                                <td>2024-04-01</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info">Detail</button>
                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Renovasi Hotel</td>
                                                <td><span class="badge badge-success">Aktif</span></td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 45%">45%</div>
                                                    </div>
                                                </td>
                                                <td>Rp 750.000.000</td>
                                                <td>2024-03-25</td>
                                                <td>
                                                    <button class="btn btn-sm btn-info">Detail</button>
                                                    <button class="btn btn-sm btn-warning">Edit</button>
                                                </td>
                                            </tr>

                                                <td>Developer</td>
                                                <td>Edinburgh</td>
                                                <td>42</td>
                                                <td>2010/12/22</td>
                                                <td>$92,575</td>
                                            </tr>
                                            <tr>
                                                <td>Jennifer Chang</td>
                                                <td>Regional Director</td>
                                                <td>Singapore</td>
                                                <td>28</td>
                                                <td>2010/11/14</td>
                                                <td>$357,650</td>
                                            </tr>
                                            <tr>
                                                <td>Brenden Wagner</td>
                                                <td>Software Engineer</td>
                                                <td>San Francisco</td>
                                                <td>28</td>
                                                <td>2011/06/07</td>
                                                <td>$206,850</td>
                                            </tr>
                                            <tr>
                                                <td>Fiona Green</td>
                                                <td>Chief Operating Officer (COO)</td>
                                                <td>San Francisco</td>
                                                <td>48</td>
                                                <td>2010/03/11</td>
                                                <td>$850,000</td>
                                            </tr>
                                            <tr>
                                                <td>Shou Itou</td>
                                                <td>Regional Marketing</td>
                                                <td>Tokyo</td>
                                                <td>20</td>
                                                <td>2011/08/14</td>
                                                <td>$163,000</td>
                                            </tr>
                                            <tr>
                                                <td>Michelle House</td>
                                                <td>Integration Specialist</td>
                                                <td>Sidney</td>
                                                <td>37</td>
                                                <td>2011/06/02</td>
                                                <td>$95,400</td>
                                            </tr>
                                            <tr>
                                                <td>Suki Burks</td>
                                                <td>Developer</td>
                                                <td>London</td>
                                                <td>53</td>
                                                <td>2009/10/22</td>
                                                <td>$114,500</td>
                                            </tr>
                                            <tr>
                                                <td>Prescott Bartlett</td>
                                                <td>Technical Author</td>
                                                <td>London</td>
                                                <td>27</td>
                                                <td>2011/05/07</td>
                                                <td>$145,000</td>
                                            </tr>
                                            <tr>
                                                <td>Gavin Cortez</td>
                                                <td>Team Leader</td>
                                                <td>San Francisco</td>
                                                <td>22</td>
                                                <td>2008/10/26</td>
                                                <td>$235,500</td>
                                            </tr>
                                            <tr>
                                                <td>Martena Mccray</td>
                                                <td>Post-Sales support</td>
                                                <td>Edinburgh</td>
                                                <td>46</td>
                                                <td>2011/03/09</td>
                                                <td>$324,050</td>
                                            </tr>
                                            <tr>
                                                <td>Unity Butler</td>
                                                <td>Marketing Designer</td>
                                                <td>San Francisco</td>
                                                <td>47</td>
                                                <td>2009/12/09</td>
                                                <td>$85,675</td>
                                            </tr>
                                            <tr>
                                                <td>Howard Hatfield</td>
                                                <td>Office Manager</td>
                                                <td>San Francisco</td>
                                                <td>51</td>
                                                <td>2008/12/16</td>
                                                <td>$164,500</td>
                                            </tr>
                                            <tr>
                                                <td>Hope Fuentes</td>
                                                <td>Secretary</td>
                                                <td>San Francisco</td>
                                                <td>41</td>
                                                <td>2010/02/12</td>
                                                <td>$109,850</td>
                                            </tr>
                                            <tr>
                                                <td>Vivian Harrell</td>
                                                <td>Financial Controller</td>
                                                <td>San Francisco</td>
                                                <td>62</td>
                                                <td>2009/02/14</td>
                                                <td>$452,500</td>
                                            </tr>
                                            <tr>
                                                <td>Timothy Mooney</td>
                                                <td>Office Manager</td>
                                                <td>London</td>
                                                <td>37</td>
                                                <td>2008/12/11</td>
                                                <td>$136,200</td>
                                            </tr>
                                            <tr>
                                                <td>Jackson Bradshaw</td>
                                                <td>Director</td>
                                                <td>New York</td>
                                                <td>65</td>
                                                <td>2008/09/26</td>
                                                <td>$645,750</td>
                                            </tr>
                                            <tr>
                                                <td>Olivia Liang</td>
                                                <td>Support Engineer</td>
                                                <td>Singapore</td>
                                                <td>64</td>
                                                <td>2011/02/03</td>
                                                <td>$234,500</td>
                                            </tr>
                                            <tr>
                                                <td>Bruno Nash</td>
                                                <td>Software Engineer</td>
                                                <td>London</td>
                                                <td>38</td>
                                                <td>2011/05/03</td>
                                                <td>$163,500</td>
                                            </tr>
                                            <tr>
                                                <td>Sakura Yamamoto</td>
                                                <td>Support Engineer</td>
                                                <td>Tokyo</td>
                                                <td>37</td>
                                                <td>2009/08/19</td>
                                                <td>$139,575</td>
                                            </tr>
                                            <tr>
                                                <td>Thor Walton</td>
                                                <td>Developer</td>
                                                <td>New York</td>
                                                <td>61</td>
                                                <td>2013/08/11</td>
                                                <td>$98,540</td>
                                            </tr>
                                            <tr>
                                                <td>Finn Camacho</td>
                                                <td>Support Engineer</td>
                                                <td>San Francisco</td>
                                                <td>47</td>
                                                <td>2009/07/07</td>
                                                <td>$87,500</td>
                                            </tr>
                                            <tr>
                                                <td>Serge Baldwin</td>
                                                <td>Data Coordinator</td>
                                                <td>Singapore</td>
                                                <td>64</td>
                                                <td>2012/04/09</td>
                                                <td>$138,575</td>
                                            </tr>
                                            <tr>
                                                <td>Zenaida Frank</td>
                                                <td>Software Engineer</td>
                                                <td>New York</td>
                                                <td>63</td>
                                                <td>2010/01/04</td>
                                                <td>$125,250</td>
                                            </tr>
                                            <tr>
                                                <td>Zorita Serrano</td>
                                                <td>Software Engineer</td>
                                                <td>San Francisco</td>
                                                <td>56</td>
                                                <td>2012/06/01</td>
                                                <td>$115,000</td>
                                            </tr>
                                            <tr>
                                                <td>Jennifer Acosta</td>
                                                <td>Junior Javascript Developer</td>
                                                <td>Edinburgh</td>
                                                <td>43</td>
                                                <td>2013/02/01</td>
                                                <td>$75,650</td>
                                            </tr>
                                            <tr>
                                                <td>Cara Stevens</td>
                                                <td>Sales Assistant</td>
                                                <td>New York</td>
                                                <td>46</td>
                                                <td>2011/12/06</td>
                                                <td>$145,600</td>
                                            </tr>
                                            <tr>
                                                <td>Hermione Butler</td>
                                                <td>Regional Director</td>
                                                <td>London</td>
                                                <td>47</td>
                                                <td>2011/03/21</td>
                                                <td>$356,250</td>
                                            </tr>
                                            <tr>
                                                <td>Lael Greer</td>
                                                <td>Systems Administrator</td>
                                                <td>London</td>
                                                <td>21</td>
                                                <td>2009/02/27</td>
                                                <td>$103,500</td>
                                            </tr>
                                            <tr>
                                                <td>Jonas Alexander</td>
                                                <td>Developer</td>
                                                <td>San Francisco</td>
                                                <td>30</td>
                                                <td>2010/07/14</td>
                                                <td>$86,500</td>
                                            </tr>
                                            <tr>
                                                <td>Shad Decker</td>
                                                <td>Regional Director</td>
                                                <td>Edinburgh</td>
                                                <td>51</td>
                                                <td>2008/11/13</td>
                                                <td>$183,000</td>
                                            </tr>
                                            <tr>
                                                <td>Michael Bruce</td>
                                                <td>Javascript Developer</td>
                                                <td>Singapore</td>
                                                <td>29</td>
                                                <td>2011/06/27</td>
                                                <td>$183,000</td>
                                            </tr>
                                            <tr>
                                                <td>Donna Snider</td>
                                                <td>Customer Support</td>
                                                <td>New York</td>
                                                <td>27</td>
                                                <td>2011/01/25</td>
                                                <td>$112,000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Data Proyek Section -->
                        <div id="dataProyekSection" style="display: none;">
                            <h1 class="mt-4">Data Proyek</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="#" onclick="showDashboard()">Dashboard</a></li>
                                <li class="breadcrumb-item active">Data Proyek</li>
                            </ol>
                            
                            <!-- Data Table -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    Data Proyek Keseluruhan
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataProyekTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nama Proyek</th>
                                                    <th>Nomor Kontrak</th>
                                                    <th>Tanggal Kontrak</th>
                                                    <th>Status</th>
                                                    <th>Estimasi Nilai</th>
                                                    <th>Progress</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Pembangunan Gedung A</td>
                                                    <td>KTRK-001</td>
                                                    <td>2024-01-15</td>
                                                    <td><span class="badge badge-success">Aktif</span></td>
                                                    <td>Rp 500.000.000</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 75%">75%</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info">Detail</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Renovasi Kantor B</td>
                                                    <td>KTRK-002</td>
                                                    <td>2024-02-20</td>
                                                    <td><span class="badge badge-warning">Pending</span></td>
                                                    <td>Rp 250.000.000</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 25%">25%</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info">Detail</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Instalasi Sistem IT</td>
                                                    <td>KTRK-003</td>
                                                    <td>2024-03-10</td>
                                                    <td><span class="badge badge-success">Aktif</span></td>
                                                    <td>Rp 150.000.000</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 90%">90%</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info">Detail</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pembangunan Jembatan</td>
                                                    <td>KTRK-004</td>
                                                    <td>2024-01-05</td>
                                                    <td><span class="badge badge-secondary">Selesai</span></td>
                                                    <td>Rp 1.000.000.000</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 100%">100%</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info">Detail</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Pembangunan Mall</td>
                                                    <td>KTRK-005</td>
                                                    <td>2024-04-01</td>
                                                    <td><span class="badge badge-danger">Dibatalkan</span></td>
                                                    <td>Rp 2.500.000.000</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 10%">10%</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info">Detail</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Renovasi Hotel</td>
                                                    <td>KTRK-006</td>
                                                    <td>2024-03-25</td> 
                                                    <td><span class="badge badge-success">Aktif</span></td>
                                                    <td>Rp 750.000.000</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 45%">45%</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info">Detail</button>
                                                        <button class="btn btn-sm btn-warning">Edit</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filter Data Section -->
                        <div id="filterDataSection" style="display: none;">
                            <h1 class="mt-4">Cari Data Proyek</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="#" onclick="showDashboard()">Dashboard</a></li>
                                <li class="breadcrumb-item active">Cari Data Proyek</li>
                            </ol>
                            
                            <!-- Filter Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-filter mr-1"></i>
                                    Cari Data Proyek
                                </div>
                                <div class="card-body">
                                    <form id="filterForm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="namaProyek">Nama Proyek</label>
                                                    <input type="text" class="form-control" id="namaProyek" placeholder="Cari nama proyek...">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nomorKontrak">Nomor Kontrak</label>
                                                    <select class="form-control" id="nomorKontrak">
                                                        <option value="">Semua Nomor Kontrak</option>
                                                        <option value="KTRK-001">KTRK-001</option>
                                                        <option value="KTRK-002">KTRK-002</option>
                                                        <option value="KTRK-003">KTRK-003</option>
                                                        <option value="KTRK-004">KTRK-004</option>
                                                        <option value="KTRK-005">KTRK-005</option>
                                                        <option value="KTRK-006">KTRK-006</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tanggalKontrak">Tanggal Kontrak</label>
                                                    <input type="date" class="form-control" id="tanggalKontrak">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status">
                                                        <option value="">Semua Status</option>
                                                        <option value="Aktif">Aktif</option>
                                                        <option value="Selesai">Selesai</option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Dibatalkan">Dibatalkan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="estimasiNilai">Estimasi Nilai Kontrak (Range)</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="number" class="form-control" id="minNilai" placeholder="Min">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="number" class="form-control" id="maxNilai" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary" onclick="applyFilter()">
                                                    <i class="fas fa-search"></i> Terapkan Filter
                                                </button>
                                                <button type="button" class="btn btn-secondary" onclick="resetFilter()">
                                                    <i class="fas fa-undo"></i> Reset Filter
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Filtered Results -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    Hasil Filter Data Proyek
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="filteredTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nama Proyek</th>
                                                    <th>Nomor Kontrak</th>
                                                    <th>Tanggal Kontrak</th>
                                                    <th>Status</th>
                                                    <th>Estimasi Nilai</th>
                                                    <th>Progress</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data will be populated by JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">&copy; IT IMSS 2025</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/chart-area-demo.js') }}"></script>
        <script src="{{ asset('js/chart-bar-demo.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables-demo.js') }}"></script>
        <script src="{{ asset('js/dashboard-data.js') }}"></script>
        <script src="{{ asset('js/netflix-effects.js') }}"></script>
        
        <!-- Custom JavaScript for Monitoring -->
        <script>
            // Sample data for filtering
            const allProjectData = [
                {
                    nama: 'Pembangunan Gedung A',
                    nomor: 'KTRK-001',
                    tanggal: '2024-01-15',
                    status: 'Aktif',
                    nilai: 500000000,
                    progress: 75
                },
                {
                    nama: 'Renovasi Kantor B',
                    nomor: 'KTRK-002',
                    tanggal: '2024-02-20',
                    status: 'Pending',
                    nilai: 250000000,
                    progress: 25
                },
                {
                    nama: 'Instalasi Sistem IT',
                    nomor: 'KTRK-003',
                    tanggal: '2024-03-10',
                    status: 'Aktif',
                    nilai: 150000000,
                    progress: 90
                },
                {
                    nama: 'Pembangunan Jembatan',
                    nomor: 'KTRK-004',
                    tanggal: '2024-01-05',
                    status: 'Selesai',
                    nilai: 1000000000,
                    progress: 100
                },
                {
                    nama: 'Pembangunan Mall',
                    nomor: 'KTRK-005',
                    tanggal: '2024-04-01',
                    status: 'Dibatalkan',
                    nilai: 2500000000,
                    progress: 10
                },
                {
                    nama: 'Renovasi Hotel',
                    nomor: 'KTRK-006',
                    tanggal: '2024-03-25',
                    status: 'Aktif',
                    nilai: 750000000,
                    progress: 45
                }
            ];
            
            // Function to show dashboard
            function showDashboard() {
                document.getElementById('dataProyekSection').style.display = 'none';
                document.getElementById('filterDataSection').style.display = 'none';
                // Show dashboard content
                const dashboardContent = document.querySelector('.container-fluid');
                const dashboardElements = dashboardContent.children;
                for (let i = 0; i < dashboardElements.length - 2; i++) { // -2 to exclude both sections
                    dashboardElements[i].style.display = 'block';
                }
            }
            
            // Function to show data proyek section
            function showDataProyekSection() {
                document.getElementById('dataProyekSection').style.display = 'block';
                document.getElementById('filterDataSection').style.display = 'none';
                // Hide dashboard content
                const dashboardContent = document.querySelector('.container-fluid');
                const dashboardElements = dashboardContent.children;
                for (let i = 0; i < dashboardElements.length - 2; i++) { // -2 to exclude both sections
                    dashboardElements[i].style.display = 'none';
                }
                
                // Initialize DataTable for data proyek
                if ($.fn.DataTable.isDataTable('#dataProyekTable')) {
                    $('#dataProyekTable').DataTable().destroy();
                }
                $('#dataProyekTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                    },
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
                    "order": [[0, "asc"]],
                    "responsive": true
                });
            }
            
            // Function to show filter data section
            function showFilterDataSection() {
                document.getElementById('dataProyekSection').style.display = 'none';
                document.getElementById('filterDataSection').style.display = 'block';
                // Hide dashboard content
                const dashboardContent = document.querySelector('.container-fluid');
                const dashboardElements = dashboardContent.children;
                for (let i = 0; i < dashboardElements.length - 2; i++) { // -2 to exclude both sections
                    dashboardElements[i].style.display = 'none';
                }
                
                // Initialize DataTable for filtered results
                if ($.fn.DataTable.isDataTable('#filteredTable')) {
                    $('#filteredTable').DataTable().destroy();
                }
                $('#filteredTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                    },
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
                    "order": [[0, "asc"]],
                    "responsive": true
                });
            }
            
            // Function to apply filter
            function applyFilter() {
                const namaProyek = document.getElementById('namaProyek').value.toLowerCase();
                const nomorKontrak = document.getElementById('nomorKontrak').value;
                const tanggalKontrak = document.getElementById('tanggalKontrak').value;
                const status = document.getElementById('status').value;
                const minNilai = document.getElementById('minNilai').value;
                const maxNilai = document.getElementById('maxNilai').value;
                
                // Filter data
                let filteredData = allProjectData.filter(project => {
                    let match = true;
                    
                    if (namaProyek && !project.nama.toLowerCase().includes(namaProyek)) {
                        match = false;
                    }
                    if (nomorKontrak && project.nomor !== nomorKontrak) {
                        match = false;
                    }
                    if (tanggalKontrak && project.tanggal !== tanggalKontrak) {
                        match = false;
                    }
                    if (status && project.status !== status) {
                        match = false;
                    }
                    if (minNilai && project.nilai < parseInt(minNilai)) {
                        match = false;
                    }
                    if (maxNilai && project.nilai > parseInt(maxNilai)) {
                        match = false;
                    }
                    
                    return match;
                });
                
                // Update filtered table
                updateFilteredTable(filteredData);
                
                // Show success message
                alert(`Filter berhasil diterapkan! Ditemukan ${filteredData.length} data.`);
            }
            
            // Function to update filtered table
            function updateFilteredTable(data) {
                const table = $('#filteredTable').DataTable();
                table.clear();
                
                data.forEach(project => {
                    const statusBadge = getStatusBadge(project.status);
                    const progressBar = getProgressBar(project.progress, project.status);
                    
                    table.row.add([
                        project.nama,
                        project.nomor,
                        project.tanggal,
                        statusBadge,
                        `Rp ${project.nilai.toLocaleString('id-ID')}`,
                        progressBar,
                        '<button class="btn btn-sm btn-info">Detail</button> <button class="btn btn-sm btn-warning">Edit</button>'
                    ]);
                });
                
                table.draw();
            }
            
            // Function to get status badge
            function getStatusBadge(status) {
                const badgeClasses = {
                    'Aktif': 'badge-success',
                    'Selesai': 'badge-secondary',
                    'Pending': 'badge-warning',
                    'Dibatalkan': 'badge-danger'
                };
                return `<span class="badge ${badgeClasses[status] || 'badge-secondary'}">${status}</span>`;
            }
            
            // Function to get progress bar
            function getProgressBar(progress, status) {
                let barClass = 'progress-bar';
                if (status === 'Dibatalkan') {
                    barClass += ' bg-danger';
                }
                return `<div class="progress"><div class="${barClass}" role="progressbar" style="width: ${progress}%">${progress}%</div></div>`;
            }
            
            // Function to reset filter
            function resetFilter() {
                document.getElementById('filterForm').reset();
                
                // Clear filtered table
                const table = $('#filteredTable').DataTable();
                table.clear().draw();
                
                alert('Filter berhasil direset!');
            }
            
            // Initialize when page loads
            $(document).ready(function() {
                // Show dashboard by default
                showDashboard();
            });
        </script>
    </body>
</html>