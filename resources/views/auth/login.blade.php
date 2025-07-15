<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login Dashboard</title>

    <!-- Bootstrap & Custom CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-secondary d-flex flex-column min-vh-100">
    <!-- Konten Login -->
    <div id="layoutAuthentication_content" class="flex-fill d-flex align-items-center justify-content-center">
        <main class="w-100" style="max-width: 500px;">
            <div class="container">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body">
                        <!-- Logo & Judul -->
                        <div class="text-center mb-3">
                            <img src="{{ asset('img/logo_imss_hd.jpg') }}" alt="Logo" style="height: 40px;">
                            <h5 class="mt-2 mb-3 fw-bold text-dark" style="font-weight: bold; font-style: italic;">DASHBOARD MONITORING PROJECT</h5>
                            <div class="border-bottom border-dark w-100 mx-auto mb-3"></div>
                        </div>

                        <!-- Form Login -->
                        <!-- <form method="POST" action="{{ route('login') }}">
                            @csrf -->

                        <form onsubmit="redirectToDashboard(event)">

                            <!-- NIP -->
                            <div class="form-group mb-3">
                                <label for="nip" class="form-label">Username</label>
                                <input id="nip" type="text" class="form-control @error('nip') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" name="remember" />
                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                </div>
                            </div>

                            <!-- Tombol Login -->
                            <div class="form-group text-center">
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

    <script>
        function redirectToDashboard(event) {
            event.preventDefault(); // Hindari reload
            window.location.href = "/dashboard"; // Ganti dengan URL tujuan demo kamu
        }
    </script>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>