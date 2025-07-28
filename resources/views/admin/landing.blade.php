<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Landing - Dasbor Pemantauan Proyek</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />

    <!-- Bootstrap & Custom CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        body {
            background-color: #6c757d; /* bg-secondary */
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .landing-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .landing-card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            padding: 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            border: none;
        }
        
        .logo-section {
            margin-bottom: 30px;
        }
        
        .logo-section img {
            height: 40px;
            margin-bottom: 15px;
        }
        
        .welcome-text {
            color: #333;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        
        .user-info {
            background: #f8f9fa;
            padding: 10px 20px;
            border-radius: 25px;
            margin-bottom: 30px;
            display: inline-block;
            color: #495057;
            font-weight: 500;
        }
        
        .button-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        
        .admin-btn {
            background-color: #6c757d; /* btn-secondary */
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 200px;
            justify-content: center;
        }
        
        .admin-btn:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }
        
        .user-btn {
            background-color: #6c757d; /* btn-secondary */
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 200px;
            justify-content: center;
        }
        
        .user-btn:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
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
    </style>
</head>
<body class="bg-secondary d-flex flex-column min-vh-100">
    <!-- Logout button di pojok kanan atas -->
    <div style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <a href="#" onclick="showLogoutConfirmation()" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Konten Landing -->
    <div class="landing-container">
        <div class="landing-card">
            <div class="logo-section">
                <img src="{{ asset('img/logo_imss_hd.jpg') }}" alt="Logo IMSS">
                <div class="welcome-text">Selamat Datang, Admin!</div>
                <div class="subtitle">Pilih tampilan yang ingin Anda akses</div>
            </div>
            
            <div class="user-info">
                <i class="fas fa-user-circle me-2"></i>
                {{ Auth::user()->username ?? 'Admin' }} ({{ Auth::user()->role ?? 'admin' }})
            </div>
            
            <div class="button-container">
                <a href="{{ route('admin-dashboard') }}" class="admin-btn">
                    <i class="fas fa-cogs"></i> Tampilan Admin
                </a>
                <a href="{{ route('dashboard') }}" class="user-btn">
                    <i class="fas fa-users"></i> Tampilan Pengguna
                </a>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin keluar dari sistem?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        function showLogoutConfirmation() {
            $('#logoutModal').modal('show');
        }
    </script>
</body>
</html> 