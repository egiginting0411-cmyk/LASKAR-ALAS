<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
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
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="{{ url('/') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('assets/images/logos/image.png') }}" width="180" alt="">
                                </a>
                                <p class="text-center">Create your account</p>

                                <!-- Register Form -->
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" required autofocus autocomplete="name">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input id="email" type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" required autocomplete="username">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input id="password" type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            required autocomplete="new-password">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input id="password_confirmation" type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            required autocomplete="new-password">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit -->
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
                                        Sign Up
                                    </button>

                                    <!-- Link to Login -->
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                                        <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Sign In</a>
                                    </div>
                                </form>
                                <!-- End Register Form -->

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