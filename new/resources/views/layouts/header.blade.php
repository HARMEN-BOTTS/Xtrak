<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ Route('user.profile') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
                        </span>
                    </a>

                    <a href="{{ Route('user.profile') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="" height="17">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <div class="ms-3 header-item d-none d-sm-flex">
                    <p class="mt-4 ">
                        <span id="current-date" class="me-3"></span>
                        <span id="current-time"></span>
                        <br>
                        <span> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </p>
                </div>
            </div>
            @php
                $user = \App\Models\User::first();
            @endphp
            <div class="d-flex align-items-center">
                <!-- <div class="header-item">
                    @if (!auth()->user()->hasRole('Administrateur'))

                        @if ($user->is_connect)
                            {{ $user->first_name }} {{ $user->last_name }} est : En ligne
                        @else
                            {{ $user->first_name }} {{ $user->last_name }} est : Hors ligne
                        @endif
                    @endif
                </div> -->
                {{-- <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>
                --}}
                <div class="ms-1 header-item">
                    <a href="{{ route('chat') }}" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle">
                        <i class="mdi mdi-chat"></i>
                    </a>
                </div>

                <div class="ms-1 header-item d-sm-flex text-danger ">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <form method="POST" action="{{ route('deconnexion') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="mdi mdi-logout fs-16 align-middle me-1"></i>
                                <span class="align-middle " data-key="t-logout">Déconnexion</span>
                            </button>
                        </form>
                    </button>
                </div>



                <div class="dropdown ms-sm-3 header-item topbar-user bg-secondary text-white">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center text-white">

                             @if (auth()->user()->hasRole('Administrateur'))
                                 ESPACE ADMINISTATEUR
                             @elseif (auth()->user()->hasRole('Manager'))
                                 ESPACE MANAGER
                            @else
                                ESPACE CONSULTANT
                             @endif
                            {{-- @php
                                $user = \Illuminate\Support\Facades\Auth::user();
                            @endphp
                                @if ($user->profile_photo_path != null)
                                <img src=" {{ asset('storage') . '/' . $user->profile_photo_path }}"
                                    class="rounded-circle header-profile-user" alt="user-profile-image">
                                @else
                                <img src="assets/images/logo.jpg"
                                class="rounded-circle header-profile-user" alt="user-profile-image">
                                @endif
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">{{ Auth::user()->first_name }}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ Auth::user()->last_name }}</span>
                            </span> --}}
                        </span>
                    </button>
                    {{-- <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Bienvenue {{ Auth::user()->first_name }}
                            {{ Auth::user()->last_name }} </h6>
                        <a class="dropdown-item" href="{{ Route("user.profile") }}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profil</span></a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                <span class="align-middle" data-key="t-logout">Déconnexion</span>
                            </button>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</header>
