<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none"
    data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Connexion | Xtrak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="XTRAK- HARMEN & BOTTS" name="description" />
    <meta content="Xtrak" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/newFavicon.jpeg') }}">
    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login_bg {
            background-image: url('{{  asset('assets/images/landing.jpg')  }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            width: 100vw;
            overflow-x: hidden;
        }

        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .auth-page-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
        }


        .xtrak-logo-container {
            position: absolute;
            width: 100%;
            z-index: 3;
        }

        @media (min-width: 992px) {
            .xtrak-logo-container {
                left: 27%;
                right: 70%;
                top: 13%;
                bottom: 70%;
            }

            .xtrak-logo-container img {
                max-width: 150px;
                height: auto;
            }

            .auth-form-container {
                margin-left: 64%;
                margin-right: 30%;
                margin-top: 20%;
                width: 80%;
                max-width: 320px;
            }
        }


        @media (min-width: 768px) and (max-width: 991px) {
            .xtrak-logo-container {
                position: relative;
                text-align: center;
                margin-bottom: 2rem;
            }

            .xtrak-logo-container img {
                max-width: 180px;
                height: auto;
            }

            .auth-form-container {
                margin: 0 auto;
                width: 100%;
                max-width: 380px;
            }
        }

        @media (max-width: 767px) {
            .xtrak-logo-container {
                position: relative;
                text-align: center;
                margin-bottom: 1rem;
                margin-top: 1.5rem;
            }

            .xtrak-logo-container img {
                max-width: 150px;
                height: auto;
            }

            .auth-form-container {
                margin: 0 auto;
                width: 90%;
                max-width: 350px;
                padding: 0 10px;
            }
        }

        .auth-page-content {
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 60px);
            padding-top: 2rem;
            
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }


        .card {
            margin: 1rem 0;
            background:white;
        }

        .card-body {
            padding: 0.5rem;
        }

        .auth-logo img {
            height: 80px;
            width: auto;
            object-fit: contain;
        }

        .form-label {
            margin-bottom: 0.3rem;
        }

        .mb-3 {
            margin-bottom: 0.75rem !important;
        }

        .form-control {
            padding: 0.4rem 0.75rem;
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.4rem 1rem;
        }

        h2.mt-3 {
            margin-top: 0.75rem !important;
            font-size: 1.5rem;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
        }
    </style>
</head>

<body class="login_bg">
    <div id="particles-js"></div>

    <div class="xtrak-logo-container">
        <h1><img src="{{ asset('assets/images/xtrak.png') }}" alt="XTrak Logo" id="xtrak"></h1>
    </div>

    <div class="auth-page-wrapper">
        <div class="auth-page-content">
            <div class="container">
                <div class="auth-form-container">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-">
                                <!-- <div>
                                    <a href="index.html" class="d-inline-block auth-logo">
                                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="" class="img-fluid">
                                    </a>
                                </div> -->
                                <h2 style="color:#010066;" class="ms-2 mt-1 fw-bold">XTRAK</h2>
                            </div>
                            <div class="p-2">
                                @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow show"
                                    role="alert">
                                    <i class="ri-error-warning-line label-icon"></i><strong>Erreur</strong> -
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                <x-validation-errors class="mb-4" />

                                @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                                @endif

                                <form method="POST" action="{{ route('connexion') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Log In</label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                placeholder=""
                                                value="{{ old('email') }}">
                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" name="password"
                                                    class="form-control pe-5 password-input @error('password') border-danger @enderror"
                                                    placeholder="" id="password-input">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                                @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- <div class="form-check mb-2 ms-3">
                                            <input class="form-check-input" name="remember_me" type="checkbox"
                                                value="true" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Se souvenir de moi</label>
                                        </div> -->

                                        <div class="mt-1">
                                            <button class="btn btn-secondary w-100" type="submit">Connect</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <!-- <p class="mb-0 text-white">&copy;
                                <script>document.write(new Date().getFullYear())</script> Tous droits réservé. XTRAK, Réalisé
                                par <a class="link-light" href="https://www.harmen-botts.com/">HARMEN & BOTTS</a>
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <!-- particles js -->
    <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
    <!-- particles app js -->
    <script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>
    <!-- password-addon init -->
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
</body>

</html>
