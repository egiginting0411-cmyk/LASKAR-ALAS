<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<style>
    .card {
        background-color: #2aa15a !important;
        border: none;
        color: #fff;
    }

    .card .form-label,
    .card .form-check-label,
    .card a,
    .card p {
        color: #fff !important;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.2);
        border: 1px solid #fff;
        color: #fff;
    }

    .form-control::placeholder {
        color: #e0e0e0;
    }

    .btn-primary {
        background-color: #fff !important;
        color: #2aa15a !important;
        border: none;
    }

    .btn-primary:hover {
        background-color: #e6e6e6 !important;
        color: #2aa15a !important;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.2) !important;
        border: 1px solid #fff !important;
        color: #fff !important;
    }

    .form-control::placeholder {
        color: #e0e0e0 !important;
    }
</style>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{asset('assets/images/logos/image.png')}}" width="180" alt="">
                                </a>
                                <p class="text-center">Login ke Sistem</p>

                                <!-- Session Status -->
                                @if (session('status'))
                                <div class="alert alert-success text-center">
                                    {{ session('status') }}
                                </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email / Username</label>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" required autofocus>
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            required>
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label text-dark" for="remember">
                                                Remember this device
                                            </label>
                                        </div>
                                        @if (Route::has('password.request'))
                                        <a class="text-primary fw-bold" href="{{ route('password.request') }}">
                                            Forgot Password ?
                                        </a>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-2 fs-4 mb-4 rounded-2">
                                        Sign In
                                    </button>

                                    @if (Route::has('register'))
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-6 mb-0 fw-bold">Belum punya akun?</p>
                                        <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Daftar</a>
                                    </div>
                                    @endif
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>