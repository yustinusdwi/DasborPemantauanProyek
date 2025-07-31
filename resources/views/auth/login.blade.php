<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login Dashboard</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-imss-no-bg.png') }}" />

    <!-- Bootstrap & Custom CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-control {
            border-radius: 6px;
            border: 1.5px solid #e9ecef;
            padding: 10px 12px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #6c757d;
            box-shadow: 0 0 0 0.15rem rgba(108, 117, 125, 0.25);
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 6px;
            padding: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(108, 117, 125, 0.3);
        }
        
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        
        /* Logo and title improvements */
        .text-center img {
            transition: all 0.3s ease;
        }
        
        .text-center h5 {
            color: #495057;
            letter-spacing: 0.5px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .text-center img {
                height: 100px !important;
                transform: scale(1) !important;
            }
            
            .text-center h5 {
                font-size: 1rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .card-body {
                padding: 1rem;
            }
            
            .text-center img {
                height: 80px !important;
            }
            
            .text-center h5 {
                font-size: 0.9rem !important;
            }
        }
    </style>
</head>

<body class="bg-secondary d-flex flex-column min-vh-100">
    <!-- Konten Login -->
    <div id="layoutAuthentication_content" class="flex-fill d-flex align-items-center justify-content-center">
        <main class="w-100" style="max-width: 500px;">
            <div class="container">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body">
                        <!-- Logo & Judul -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/imssMARKLENS-logo.png') }}" alt="Logo" style="height: 120px; transform: scale(1.1); margin-bottom: 10px;">
                            <h5 class="mt-2 mb-3 fw-bold text-dark" style="font-weight: bold; font-style: italic; font-size: 1.1rem;">DASBOR PEMANTAUAN PROYEK PEMASARAN</h5>
                            <div class="border-bottom border-dark w-100 mx-auto mb-3"></div>
                        </div>

                        <!-- Form Login -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Username -->
                            <div class="form-group mb-3">
                                <label for="username" class="form-label fw-semibold">Username</label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-group mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" name="remember" />
                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                </div>
                            </div>

                            <!-- Tombol Login -->
                            <div class="form-group text-center mb-3">
                                <button type="submit" class="btn btn-secondary w-100">Login</button>
                            </div>

                            <div class="d-flex align-items-center justify-content-end small">
                                <div class="text-muted">&copy; IT IMSS 2025</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>