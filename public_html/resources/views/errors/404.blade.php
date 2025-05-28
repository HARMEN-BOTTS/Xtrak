<!doctype html>
<html lang="en" data-layout="twocolumn" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none"
    data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Page introuvable | XTRAK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="XTRAK- HARMEN & BOTTS" name="description" />
    <meta content="Xtrak" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />


</head>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">

        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden p-0">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <div class="text-center">
                            <img src="{{ asset('assets/images/error400-cover.png') }}" alt="error img"
                                class="img-fluid">
                            <div class="mt-3">
                                <h3 class=“text-uppercase”>Désolé, la page n’a pas été trouvée 😭</h3>
                                <p class=“text-muted mb-4”>La page que vous recherchez n’est pas disponible !</p>
                                <a href="{{ url()->previous() }}" class="btn btn-primary"><i
                                        class="mdi mdi-arrow-left me-1"></i>Retourner</a>

                            </div>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth-page content -->
    </div>
    <!-- end auth-page-wrapper -->

</body>

</html>
