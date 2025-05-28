<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-sidebar="light"
    data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="XTRAK- HARMEN & BOTTS" name="description" />
    <meta content="Xtrak" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/newFavicon.jpeg') }}">
    <!-- jsvectormap css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

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
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
    <!-- Styles -->
    @livewireStyles
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('layouts.header')

        @include('layouts.sidebar')


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('layouts.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    </div>
    {{-- @include('layouts.themesettings') --}}

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>


    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    {{-- sweetalert2 --}}
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- jquery --}}
    <script src="{{ asset('assets/js/pages/jquery-3.7.1.min.js') }}"></script>
    <!-- password-addon init -->
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/invoicedetails.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        window.addEventListener('alert', ({
            detail: {
                type,
                message
            }
        }) => {
            Toast.fire({
                icon: type,
                title: message
            });
        });

        window.addEventListener('swal:modal', event => {
            new Swal({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.type
            });
        });
        window.addEventListener('swal:confirm-parameter', event => {
            new Swal({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.type,
                showCancelButton: true,
                confirmButtonColor: '#008000',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Modifier',
                cancelButtonText: 'Annuler'
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    if (event.detail.other) {
                        Livewire.emit(event.detail.method, event.detail.id, event.detail.other);
                    } else {
                        Livewire.emit(event.detail.method, event.detail.id);
                    }

                }
            });
        });
        window.addEventListener('swal:confirm', event => {
            new Swal({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.type,
                showCancelButton: true,
                confirmButtonColor: '#FF0000 ',
                cancelButtonColor: '#0000FF',
                confirmButtonText: 'Supprimer',
                cancelButtonText: 'Annuler'
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    Livewire.dispatch(event.detail.method, {
                        id: event.detail.id
                    });
                }
            });
        });
        window.addEventListener('swal:confirm-modif', event => {
            new Swal({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.type,
                showCancelButton: true,
                confirmButtonColor: '#FF0000 ',
                cancelButtonColor: '#0000FF',
                confirmButtonText: 'Modifier',
                cancelButtonText: 'Annuler'
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    Livewire.dispatch(event.detail.method, {
                        id: event.detail.id
                    });
                }
            });
        });
        window.addEventListener('close:modal', event => {
            $('.modal').modal('hide');
        });
        window.addEventListener('refresh-page', event => {
            setTimeout(function() {
                window.location.reload(false);
            }, 1500);
        });
    </script>
    <script>
        function updateClock() {
            const now = new Date();

            const jours = ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"];
            const mois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre",
                "novembre", "décembre"
            ];

            const jourEnLettres = jours[now.getDay()];
            const jourNumero = now.getDate();
            const moisEnChiffre = now.getMonth() + 1;
            const moisEnLettres = mois[now.getMonth()];
            const annee = now.getFullYear();

            const jourFormatte = jourNumero < 10 ? `0${jourNumero}` : jourNumero;

            const moisFormatte = moisEnChiffre < 10 ? `0${moisEnChiffre}` :
                moisEnChiffre;

            const heureFormattee = now.getHours().toString().padStart(2, '0');
            const minuteFormattee = now.getMinutes().toString().padStart(2, '0');
            const secondeFormattee = now.getSeconds().toString().padStart(2, '0');

            document.getElementById('current-date').textContent =
                `${jourFormatte} / ${moisFormatte} / ${annee}`;
            document.getElementById('current-time').textContent =
                `${heureFormattee}:${minuteFormattee}:${secondeFormattee}`;
        }

        setInterval(updateClock, 1000);

        updateClock();
    </script>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.hook('afterDomUpdate', () => {
                updatePreviousUrl();
            });
        });

        function updatePreviousUrl() {
            var currentUrl = window.location.href;
            localStorage.setItem('previousUrl', currentUrl);
        }

        function goBack() {
            var previousUrl = localStorage.getItem('previousUrl');
            if (previousUrl) {
                window.location.href = previousUrl;
            } else {
                window.history.back();
            }
        }
        window.addEventListener('goBack', function() {

            goBack();
        });
    </script>
    @yield('script')
    @stack('script-chart')
    @stack('page-script')
    @livewireScripts
</body>

</html>
