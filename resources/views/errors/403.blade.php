@extends('layouts.app',['title' => "Action interdit"])
@section('title', '403 - Action interdite')
@section('css')
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
@endsection

@section('content')
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">

        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden p-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-4 text-center">
                        <div class="error-500 position-relative">
                            <img src="{{ asset('assets/images/error500.png') }}" alt=""
                                class="{{ asset('img-fluid error-500-img error-img') }}" />
                            <h1 class="title text-muted">500</h1>
                        </div>
                        <div>
                            <h3>Oups !!! Action interdit</h3>
                            <p class="text-muted w-75 mx-auto">Vous n'avez pas l'autorisation pour accéder à ce contenu</p>
                            {{-- il faut le retourner d'ou il vient --}}
                            <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="mdi mdi-arrow-left me-1"></i>Retourner</a>
                            {{-- <a href="{{ Route('dashboard') }}" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Retourner au tableau de bord</a> --}}
                        </div>
                    </div><!-- end col-->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth-page content -->
    </div>
    <!-- end auth-page-wrapper -->
@endsection
