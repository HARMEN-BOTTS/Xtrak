 <!-- ========== App Menu ========== -->
 <div class="app-menu navbar-menu">
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="https://www.harmen-botts.com/" class="logo logo-dark">
             <span class="logo-sm">
                 <img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid" height="250" width="250">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid" height="250" width="250">
             </span>
         </a>
         <!-- Light Logo-->
         <a href="https://www.harmen-botts.com/" class="logo logo-light">
             <span class="logo-sm">
                 <img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid" height="250" width="250">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('assets/images/logo.jpg') }}" class="img-fluid" height="250" width="250">
             </span>
         </a>
         <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
             id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <div id="scrollbar">
         <div class="container-fluid">
             <div id="two-column-menu">
             </div>
              <ul class="navbar-nav" id="navbar-nav">
                 <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                 <li class="nav-item {{ request()->routeIs('landing') ? 'bg-dash-sidebar' : '' }}">
                     <a class="nav-link menu-link  {{ request()->routeIs('landing') ? '' : '' }}   {{ request()->routeIs('laning') ? 'active' : '' }}"
                         href="{{ route('landing') }}">
                         <i class="ri-dashboard-2-line"></i>
                         <span data-key="t-dashboards">
                             @if (auth()->user()->hasRole('Administrateur'))
                             ADM WORKSPACE
                             @elseif (auth()->user()->hasRole('Manager'))
                             ESPACE MANAGER
                             @elseif (auth()->user()->hasRole('CST+'))
                             ESPACE CONSULTANT+
                             @else
                             ESPACE CONSULTANT
                             @endif
                         </span>
                     </a>

                 </li> <!-- end Dashboard Menu -->

                 {{-- @can(['Menu accès BaseCDT'])
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('candidates.index') ? 'active' : '' }}"
                 href="{{ route('candidates.index') }}">
                 <i class="ri-apps-2-line"></i> <span data-key="t-apps">Accès BaseCDT</span>
                 </a>

                 </li>
                 @endcan --}}
                 <!-- <a href="{{ route('cdtvue') }}" class="nav-link {{ request()->routeIs('cdtvue*') ? 'active' : '' }}" data-key="t-chat">CDTvue</a> -->

                 <a class="nav-link"
                     href="/landing">
                     <i class="ri-apps-2-line"></i> <span data-key="t-vault" style="color:#09ff00">LANDING</span>
                 </a>





                 <!-- Vues -->

                 @can('Menu etats')
                 <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->is(['cdtvue', 'oppvue', 'trgvue', 'facvue', 'cdtvue/*', 'oppvue/*', 'trgvue/*', 'facvue/*']) ? 'active' : '' }}"
                         href="#vues" data-bs-toggle="collapse" role="button"
                         aria-expanded="{{ request()->is(['cdtvue', 'oppvue', 'trgvue', 'facvue', 'cdtvue/*', 'oppvue/*', 'trgvue/*', 'facvue/*']) ? 'true' : 'false' }}"
                         aria-controls="vues">
                         <i class="ri-apps-2-line"></i> <span data-key="t-vues" style="color:#09ff00">VUES</span>
                     </a>
                     <div class="collapse menu-dropdown {{ request()->is(['cdtvue', 'oppvue', 'trgvue', 'facvue', 'cdtvue/*', 'oppvue/*', 'trgvue/*', 'facvue/*']) ? 'show' : '' }}"
                         id="vues">
                         <ul class="nav nav-sm flex-column">
                             @if (auth()->user()->hasRole('Administrateur'))
                             <li class="nav-item">
                                 <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">CDTvue</span></a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('oppdashboard') }}" class="nav-link {{ request()->routeIs('oppdashboard*') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">OPPvue</span></a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('trgdashboard') }}" class="nav-link {{ request()->routeIs('trgdashboard*') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">TRGvue</span></a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('ctcdashboard') }}" class="nav-link {{ request()->routeIs('ctcdashboard*') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">CTCvue</span></a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('cstdashboard') }}" class="nav-link {{ request()->routeIs('cstdashboard*') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">CSTvue</span></a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('mcpdashboard') }}" class="nav-link {{ request()->routeIs('mcpdashboard*') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">MCPvue</span></a>
                             </li>
                             @elseif (auth()->user()->hasRole('Manager'))
                             <li class="nav-item">
                                 <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">CDTvue</span></a>
                             </li>
                             <li class="nav-item">
                                 <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs('oppvue*') ? 'active' : '' }}" data-key="t-chat"><span style="color:orange">OPPvue</span></a>
                             </li>
                             @elseif (auth()->user()->hasRole('CST+'))
<!--                         <li class="nav-item">
                                 <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">CDT_CST+vue</span></a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">CDT_CSTvue</span></a>
                             </li> -->
                             @can('CST+ Vue')
                             <li class="nav-item">
                                 <a href="{{ route('dashboard') }}" class="nav-link {{ !request()->query('dashboard') ? 'active' : '' }}" data-key="t-chat">
                                     <span style="color:#09ff00">CDT_CST+vue</span>
                                 </a>
                             </li>
                             @endcan
                             <li class="nav-item">
                                <a href="{{ route('dashboard', ['dashboard' => 'consultant']) }}" class="nav-link {{ request()->query('dashboard') === 'consultant' ? 'active' : '' }}" data-key="t-chat">
                                        <span style="color:#09ff00">CDT_CSTvue</span>
                                </a>
                            </li>
                             <li class="nav-item">
                                 <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs('oppvue*') ? 'active' : '' }}" data-key="t-chat"><span style="color:orange">OPP_CSTvue</span></a>
                             </li>
                             @else
                             <li class="nav-item">
                                 <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">CDT_CSTvue</span></a>
                             </li>
                             <li class="nav-item">
                                 <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs('oppvue*') ? 'active' : '' }}" data-key="t-chat"><span style="color:orange">OPP_CSTvue</span></a>
                             </li>
                             @endif
                         </ul>
                     </div>
                 </li>
                 @endcan



                 <!-- Gestion -->

                 @can('Menu capture / gestion')
                 <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->routeIs(['candidates.create', 'import.candidat', 'state*']) ? 'active' : '' }}"
                         href="#sidebarApps" data-bs-toggle="collapse" role="button"
                         aria-expanded="{{ request()->routeIs(['candidates.create', 'import.candidat', 'state*']) ? 'true' : 'false' }}"
                         aria-controls="sidebarApps">
                         <i class="ri-apps-2-line"></i> <span style="color:#09ff00" data-key="t-apps">GESTION</span>
                     </a>
                     <div class="collapse menu-dropdown {{ request()->routeIs(['candidates.create', 'import.candidat', 'state*']) ? 'show' : '' }}"
                         id="sidebarApps">
                         <ul class="nav nav-sm flex-column">
                             @can('Menu saisie')
                             <li class="nav-item">
                                 <a href="#saisie" class="nav-link {{ request()->routeIs('candidates.create', 'import.candidat') ? 'active' : '' }} " data-bs-toggle="collapse" role="button"
                                     aria-expanded="{{ request()->routeIs('candidates.create', 'import.candidat') ? 'true' : 'false' }}"
                                     aria-controls="saisie" data-key="t-signin">
                                     <span style="color:#09ff00">Saisie</span>
                                 </a>

                                 <div class="collapse menu-dropdown {{ request()->routeIs('candidates.create', 'import.candidat') ? 'show' : '' }}"
                                     id="saisie">
                                     <ul class="nav nav-sm flex-column">
                                         @can('Menu etats')
                                         <li class="nav-item">
                                             <a class="nav-link menu-link {{ request()->is(['formcdt', 'formopp', 'formcdt/*', 'formopp/*']) ? 'active' : '' }}"
                                                 href="#formulaires" data-bs-toggle="collapse" role="button"
                                                 aria-expanded="{{ request()->is(['formcdt', 'formopp', 'formcdt/*', 'formopp/*']) ? 'true' : 'false' }}"
                                                 aria-controls="formulaires">
                                                 <span data-key="t-formulaires" style="color:#09ff00">Formulaires</span>
                                             </a>

                                             <div class="collapse menu-dropdown {{ request()->is(['formcdt', 'formopp', 'formcdt/*', 'formopp/*']) ? 'show' : '' }}"
                                                 id="formulaires">
                                                 <ul class="nav nav-sm flex-column">
                                                     @if (auth()->user()->hasRole('Administrateur'))
                                                     <li class="nav-item">
                                                         <a href="{{ route('candidates.create') }}" class="nav-link {{ request()->routeIs('candidates.create') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">FormCDT</span></a>
                                                     </li>
                                                     <li class="nav-item">
                                                         <a href="/opportunity" class="nav-link" data-key="t-chat"><span style="color:#09ff00">FormOPP</span></a>
                                                     </li>
                                                     <li class="nav-item">
                                                         <a href="/trgform" class="nav-link" data-key="t-chat"><span style="color:#09ff00">FormTRG</span></a>
                                                     </li>
                                                     <li class="nav-item">
                                                         <a href="/ctcform" class="nav-link" data-key="t-chat"><span style="color:#09ff00">FormCTC</span></a>
                                                     </li>
                                                     <li class="nav-item">
                                                         <a href="/cstform" class="nav-link" data-key="t-chat"><span style="color:#09ff00">FormCST</span></a>
                                                     </li>
                                                     <li class="nav-item">
                                                         <a href="/mcpform" class="nav-link" data-key="t-chat"><span style="color:#09ff00">FormMCP</span></a>
                                                     </li>
                                                     @else
                                                     <li class="nav-item">
                                                         <a href="{{ route('candidates.create') }}" class="nav-link {{ request()->routeIs('candidates.create') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">FormCDT</span></a>
                                                     </li>
                                                     @endif
                                                 </ul>
                                             </div>
                                             @endcan

                                             @can('Menu etats')
                                         <li class="nav-item">
                                             <a class="nav-link menu-link {{ request()->is(['canevascdt', 'canevasann', 'canevascdt/*', 'canevasann/*']) ? 'active' : '' }}"
                                                 href="#uploads" data-bs-toggle="collapse" role="button"
                                                 aria-expanded="{{ request()->is(['canevascdt', 'canevasann', 'canevascdt/*', 'canevasann/*']) ? 'true' : 'false' }}"
                                                 aria-controls="uploads">
                                                 <span data-key="t-uploads" style="color:#09ff00">Uploads</span>
                                             </a>

                                             <div class="collapse menu-dropdown {{ request()->is(['canevascdt', 'canevasann', 'canevascdt/*', 'canevasann/*']) ? 'show' : '' }}"
                                                 id="uploads">
                                                 <ul class="nav nav-sm flex-column">

                                                     <li class="nav-item">
                                                         <a href="{{ route('import.candidat') }}" class="nav-link {{ request()->routeIs('import.candidat') ? 'active' : '' }}" data-key="t-chat"><span style="color:#09ff00">uploadCDT</span></a>
                                                     </li>
                                                     @if (auth()->user()->hasRole('Administrateur'))
                                                     <li class="nav-item">
                                                         <a href="{{ route('canevasann') }}" class="nav-link {{ request()->routeIs('canevasann*') ? 'active' : '' }}" data-key="t-chat"><span style="color:white">uploadANN</span></a>
                                                     </li>
                                                     @endif
                                                 </ul>
                                             </div>
                                             @endcan
                                     </ul>
                                 </div>
                             </li>
                             @endcan

                             @can('Menu etats')
                             <li class="nav-item">
                                 <a href="#etats" class="nav-link {{ request()->routeIs('state*') ? 'active' : '' }}" data-bs-toggle="collapse" role="button"
                                     aria-expanded="{{ request()->routeIs('state*') ? 'true' : 'false' }}"
                                     aria-controls="etats" data-key="t-signin">
                                     <span style="color:#09ff00">Statuts</span>
                                 </a>
                                 <div class="collapse menu-dropdown {{ request()->routeIs('state*') ? 'show' : '' }}"
                                     id="etats">
                                     <ul class="nav nav-sm flex-column">
                                         <li class="nav-item">
                                             <a href="{{ route('state', 'Certifié') }}"
                                                 class="nav-link {{ request()->route()->named('state') && request()->route('state') === 'Certifié' ? 'active' : '' }}"
                                                 data-key="t-chat"><span style="color:#09ff00">Certifiés</span></a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="{{ route('state', 'Attente') }}"
                                                 class="nav-link {{ request()->route()->named('state') && request()->route('state') === 'Attente' ? 'active' : '' }}"
                                                 data-key="t-chat"><span style="color:#09ff00">Attente</span></a>
                                         </li>
                                     </ul>
                                 </div>
                             </li>
                             @endcan
                         </ul>
                     </div>
                 </li>
                 @endcan







                 <!-- Vault Dropdown -->

                 @can('Menu etats')
                 <a class="nav-link menu-link {{ request()->is(['tables', 'filtrages', 'vue', 'uploads', 'tables/*', 'filtrages/*', 'vue/*', 'uploads/*']) ? 'active' : '' }}"
                     href="#vault" data-bs-toggle="collapse" role="button"
                     aria-expanded="{{ request()->is(['tables', 'filtrages', 'vue', 'uploads', 'tables/*', 'filtrages/*', 'vue/*', 'uploads/*']) ? 'true' : 'false' }}"
                     aria-controls="vault">
                     <i class="ri-apps-2-line"></i> <span data-key="t-vault" style="color:orange">VAULT</span>
                 </a>
                 <div class="collapse menu-dropdown {{ request()->is(['tables', 'filtrages', 'vue', 'uploads', 'tables/*', 'filtrages/*', 'vue/*', 'uploads/*']) ? 'show' : '' }}"
                     id="vault">
                     <ul class="nav nav-sm flex-column">
                         <li class="nav-item">
                             <!-- <a href="{{ route('tables') }}" class="nav-link {{ request()->routeIs('tables*') ? 'active' : '' }}" data-key="t-tables" style="color:orange">Tables</a> -->
                             <a class="nav-link menu-dropdown"
                                 href="#tables" data-bs-toggle="collapse" role="button"
                                 aria-controls="tables">
                                 <span data-key="t-tables" style="color:orange">Tables</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <!-- <a href="{{ route('filtrages') }}" class="nav-link {{ request()->routeIs('filtrages*') ? 'active' : '' }}" data-key="t-filtrages" style="color:orange">Filtrages</a> -->
                             <a class="nav-link menu-dropdown"
                                 href="#filtrages" data-bs-toggle="collapse" role="button"
                                 aria-controls="filtrages">
                                 <span data-key="t-filtrages" style="color:orange">Filtrages</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link menu-dropdown"
                                 href="#vue" data-bs-toggle="collapse" role="button"
                                 aria-controls="vue">
                                 <span data-key="t-vue" style="color:orange">Vues</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link menu-dropdown"
                                 href="#upload" data-bs-toggle="collapse" role="button"
                                 aria-controls="upload">
                                 <span data-key="t-upload" style="color:orange">Uploads</span>
                             </a>
                         </li>
                     </ul>
                 </div>
                 @endcan



                 <!-- Activity -->

                 @can('Menu activité')
                 <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->is(['connexions', 'connexions/*', 'detail', 'detail/*']) ? 'active' : '' }}"
                         href="#activite" data-bs-toggle="collapse" role="button"
                         aria-expanded="{{ request()->is(['connexions', 'connexions/*', 'detail', 'detail/*']) ? 'true' : 'false' }}"
                         aria-controls="activite">
                         <i class="ri-apps-2-line"></i> <span style="color:#09ff00" data-key="t-apps">ACTIVITE</span>
                     </a>

                     <div class="collapse menu-dropdown {{ request()->is(['connexions', 'connexions/*', 'detail', 'detail/*']) ? 'show' : '' }}"
                         id="activite">
                         <ul class="nav nav-sm flex-column">
                             @can('Menu connexion')
                             <li class="nav-item">
                                 <a href="{{ route('connexions') }}"
                                     class="nav-link {{ request()->routeIs('connexions*') ? 'active' : '' }}"
                                     data-key="t-chat"><span style="color:#09ff00">Connexions</span></a>
                             </li>
                             @endcan
                             @can('Menu Détails')
                             <li class="nav-item">
                                 <a href="{{ route('detail') }}"
                                     class="nav-link {{ request()->routeIs('detail*') ? 'active' : '' }}"
                                     data-key="t-chat"><span style="color:#09ff00">Détails</span> </a>
                             </li>
                             @endcan
                         </ul>
                     </div>
                 </li>
                 @endcan





                 <!-- Parameters -->

                 @can('Menu paramètres')
                 <li class="nav-item">
                     <a class="nav-link menu-link {{ request()->routeIs(['user.profile', 'users.index', 'roles.index', 'roles.permissions', 'nextsteps.index','nsdates.index', 'compagnies.index', 'metiers', 'disponibilities.index', 'civs.index','candidate_statuts.index','candidate_states.index']) ? 'active' : '' }}"
                         href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false"
                         aria-controls="sidebarAuth">
                         <i class="ri-settings-3-line"></i> <span style="color:#09ff00" data-key="t-authentication">PARAMETRES</span>
                     </a>
                     <div class="collapse menu-dropdown {{ request()->routeIs(['user.profile', 'users.index', 'roles.index', 'roles.permissions', 'nextsteps.index','nsdates.index', 'compagnies.index', 'metiers', 'disponibilities.index', 'civs.index','candidate_statuts.index','candidate_states.index']) ? 'show' : '' }}"
                         id="sidebarAuth">
                         <ul class="nav nav-sm flex-column">
                             @can('Menu utilisateur')
                             <li class="nav-item">
                                 <a href="#sidebarSignInUsers" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                     role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                     data-key="t-signin">
                                     <span style="color:#09ff00; font-size:16px">Utilisateurs</span>
                                 </a>
                                 <div class="collapse menu-dropdown {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'show' : '' }}"
                                     id="sidebarSignInUsers">
                                     <ul class="nav nav-sm flex-column">
                                         @can('Liste des utilisateurs')
                                         <li class="nav-item">
                                             <a href="{{ route('users.index') }}"
                                                 class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                                 data-key="t-basic"> <span style="color:#09ff00">Liste</span></a>
                                         </li>
                                         @endcan
                                         @can('Gestion des rôles')
                                         <li class="nav-item">
                                             <a href="{{ route('roles.index') }}"
                                                 class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}"
                                                 data-key="t-signup"><span style="color:#09ff00">Rôles</span>
                                             </a>
                                         </li>
                                         @endcan
                                         @can('Gestion des permissions')
                                         <li class="nav-item">
                                             <a href="{{ route('roles.permissions') }}"
                                                 class="nav-link {{ request()->routeIs('roles.permissions') ? 'active' : '' }}"
                                                 data-key="t-signup"><span style="color:#09ff00">Permissions</span>
                                             </a>
                                         </li>
                                         @endcan
                                     </ul>
                                 </div>
                             </li>
                             @endcan

                             @can('Menu utilisateur')
                             <li class="nav-item">
                                 <a href="#sidebarSignInUsers" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                     role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                     data-key="t-signin">
                                     <span style="color:#09ff00;font-size:16px;"> Données </span>
                                 </a>
                                 <div class="collapse menu-dropdown {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'show' : '' }}"
                                     id="sidebarSignInUsers">
                                     <ul class="nav nav-sm flex-column">

                                         @can('Menu etats')
                                         <li class="nav-item">
                                             <a href="#sidebarSignInUsers" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                 role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                                 data-key="t-signin">
                                                 <span style="color:#09ff00;font-size:16px;"> Tables </span>
                                             </a>
                                             <div class="collapse menu-dropdown {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'show' : '' }}"
                                                 id="sidebarSignInUsers">
                                                 <ul class="nav nav-sm flex-column">
                                                     @can('Menu paramètre BaseCDT')
                                                     <li class="nav-item">
                                                         <a href="#sidebarSignInBaseCDT" class="nav-link {{ request()->routeIs(['nextsteps.index','nsdates.index', 'compagnies.index', 'metiers', 'disponibilities.index', 'civs.index','candidate_statuts.index','candidate_states.index']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                             role="button" aria-expanded="{{ request()->routeIs('nextsteps.index','nsdates.index', 'compagnies.index', 'metiers', 'disponibilities.index', 'civs.index','candidate_statuts.index','candidate_states.index') ? 'true' : 'false' }}" aria-controls="sidebarSignInBaseCDT"
                                                             data-key="t-signin">
                                                             <span style="color:#09ff00; font-size:16px;"> CDT </span>
                                                         </a>
                                                         <div class="collapse menu-dropdown {{ request()->routeIs(['nextsteps.index','nsdates.index', 'compagnies.index', 'metiers', 'disponibilities.index', 'civs.index','candidate_statuts.index','candidate_states.index']) ? 'show' : '' }}"
                                                             id="sidebarSignInBaseCDT">
                                                             <ul class="nav nav-sm flex-column">
                                                                 @can('nextStep')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('nextsteps.index') }}"
                                                                         class="nav-link {{ request()->routeIs('nextsteps.index') ? 'active' : '' }}"
                                                                         data-key="t-signup"> <span style="color:#09ff00"> NextStep </span>
                                                                     </a>
                                                                 </li>
                                                                 @endcan
                                                                 @can('nsDate')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('nsdates.index') }}"
                                                                         class="nav-link {{ request()->routeIs('nsdates.index') ? 'active' : '' }}"
                                                                         data-key="t-signup"> <span style="color:#09ff00"> NsDate </span>
                                                                     </a>
                                                                 </li>
                                                                 @endcan
                                                                 @can('Gestion des sociétes')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('compagnies.index') }}"
                                                                         class="nav-link {{ request()->routeIs('compagnies.index') ? 'active' : '' }}"
                                                                         data-key="t-signup"> <span style="color:#09ff00">Sociétes</span>
                                                                     </a>
                                                                 </li>
                                                                 @endcan

                                                                 @can('Gestion des Métier2')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('metiers') }}"
                                                                         class="nav-link {{ request()->routeIs('metiers') ? 'active' : '' }}"
                                                                         data-key="t-basic"><span style="color:#09ff00">Métiers</span></a>
                                                                 </li>
                                                                 @endcan

                                                                 @can('Gestion des disponibilites')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('disponibilities.index') }}"
                                                                         class="nav-link {{ request()->routeIs('disponibilities.index') ? 'active' : '' }}"
                                                                         data-key="t-basic"> <span style="color:#09ff00"> Disponibilites</span></a>
                                                                 </li>
                                                                 @endcan
                                                                 @can('Gestion des civilites')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('civs.index') }}"
                                                                         class="nav-link {{ request()->routeIs('civs.index') ? 'active' : '' }}"
                                                                         data-key="t-basic"> <span style="color:#09ff00"> Civ.</span></a>
                                                                 </li>
                                                                 @endcan
                                                                 @can('Gestion des statuts')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('candidate_statuts.index') }}"
                                                                         class="nav-link {{ request()->routeIs('candidate_statuts.index') ? 'active' : '' }}"
                                                                         data-key="t-basic"> <span style="color:#09ff00"> Statut</span> </a>
                                                                 </li>
                                                                 @endcan
                                                                 @can('Gestion des etats')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('candidate_states.index') }}"
                                                                         class="nav-link {{ request()->routeIs('candidate_states.index') ? 'active' : '' }}"
                                                                         data-key="t-basic"> <span style="color:#09ff00">Etat </span> </a>
                                                                 </li>
                                                                 @endcan
                                                             </ul>
                                                         </div>
                                                         @can('Gestion des permissions')
                                                     <li class="nav-item">
                                                         <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                             role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                                             data-key="t-signin">
                                                             <span style="color:orange; font-size:16px;">OPP</span>
                                                         </a>
                                                     </li>
                                                     @endcan
                                                     @can('Gestion des rôles')
                                                     <li class="nav-item">
                                                         <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                             role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                                             data-key="t-signin">
                                                             <span style="color:orange; font-size:16px;">TRG</span>
                                                         </a>
                                                         @endcan
                                                         @can('Gestion des rôles')
                                                     <li class="nav-item">
                                                         <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                             role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                                             data-key="t-signin">
                                                             <span style="color:orange; font-size:16px;">CTC</span>
                                                         </a>
                                                         @endcan
                                                     </li>
                                                     @endcan
                                                 </ul>
                                             </div>
                                         </li>
                                         @endcan



                                         @can('Menu etats')
                                         <li class="nav-item">
                                             <a href="#sidebarSignInUsers" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                 role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                                 data-key="t-signin">
                                                 <span style="color:#09ff00;font-size:16px;"> Lists </span>
                                             </a>
                                             <div class="collapse menu-dropdown {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'show' : '' }}"
                                                 id="sidebarSignInUsers">
                                                 <ul class="nav nav-sm flex-column">
                                                     @can('Menu paramètre BaseCDT')
                                                     <li class="nav-item">
                                                         <a href="#sidebarSignInBaseCDT" class="nav-link {{ request()->routeIs(['nextsteps.index','nsdates.index', 'compagnies.index', 'metiers', 'disponibilities.index', 'civs.index','candidate_statuts.index','candidate_states.index']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                             role="button" aria-expanded="{{ request()->routeIs('nextsteps.index','nsdates.index', 'compagnies.index', 'metiers', 'disponibilities.index', 'civs.index','candidate_statuts.index','candidate_states.index') ? 'true' : 'false' }}" aria-controls="sidebarSignInBaseCDT"
                                                             data-key="t-signin">
                                                             <span style="color:#09ff00; font-size:16px;"> CDT_EVT </span>
                                                         </a>
                                                         <div class="collapse menu-dropdown {{ request()->routeIs(['nextsteps.index','nsdates.index', 'compagnies.index', 'metiers', 'disponibilities.index', 'civs.index','candidate_statuts.index','candidate_states.index']) ? 'show' : '' }}"
                                                             id="sidebarSignInBaseCDT">
                                                             <ul class="nav nav-sm flex-column">
                                                                 @can('nextStep')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('nextsteps.index') }}"
                                                                         class="nav-link {{ request()->routeIs('nextsteps.index') ? 'active' : '' }}"
                                                                         data-key="t-signup"> <span style="color:#09ff00"> Dénomination </span>
                                                                     </a>
                                                                 </li>
                                                                 @endcan
                                                                 @can('nsDate')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('nsdates.index') }}"
                                                                         class="nav-link {{ request()->routeIs('nsdates.index') ? 'active' : '' }}"
                                                                         data-key="t-signup"> <span style="color:#09ff00"> Expertise </span>
                                                                     </a>
                                                                 </li>
                                                                 @endcan
                                                                 @can('Gestion des sociétes')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('compagnies.index') }}"
                                                                         class="nav-link {{ request()->routeIs('compagnies.index') ? 'active' : '' }}"
                                                                         data-key="t-signup"> <span style="color:#09ff00">Effectif</span>
                                                                     </a>
                                                                 </li>
                                                                 @endcan

                                                                 @can('Gestion des Métier2')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('metiers') }}"
                                                                         class="nav-link {{ request()->routeIs('metiers') ? 'active' : '' }}"
                                                                         data-key="t-basic"><span style="color:#09ff00">C.A.</span></a>
                                                                 </li>
                                                                 @endcan

                                                                 @can('Gestion des disponibilites')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('disponibilities.index') }}"
                                                                         class="nav-link {{ request()->routeIs('disponibilities.index') ? 'active' : '' }}"
                                                                         data-key="t-basic"> <span style="color:#09ff00"> Nature</span></a>
                                                                 </li>
                                                                 @endcan
                                                                 @can('Gestion des civilites')
                                                                 <li class="nav-item">
                                                                     <a href="{{ route('civs.index') }}"
                                                                         class="nav-link {{ request()->routeIs('civs.index') ? 'active' : '' }}"
                                                                         data-key="t-basic"> <span style="color:#09ff00">Contact (ref.)</span></a>
                                                                 </li>
                                                                 @endcan
                                                             </ul>
                                                         </div>
                                                         @can('Gestion des permissions')
                                                     <li class="nav-item">
                                                         <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                             role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                                             data-key="t-signin">
                                                             <span style="color:orange; font-size:16px;">CTC_EVT</span>
                                                         </a>
                                                     </li>
                                                     @endcan
                                                     @can('Gestion des rôles')
                                                     <li class="nav-item">
                                                         <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                             role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                                             data-key="t-signin">
                                                             <span style="color:orange; font-size:16px;">OPP_EVT</span>
                                                         </a>
                                                         @endcan
                                                         @can('Gestion des rôles')
                                                     <li class="nav-item">
                                                         <a href="javascript:void(0);" onclick="alert('New features coming soon! ✅')" class="nav-link {{ request()->routeIs(['users.index', 'roles.index', 'roles.permissions']) ? 'active' : '' }}" data-bs-toggle="collapse"
                                                             role="button" aria-expanded="{{ request()->routeIs('users.index', 'roles.index', 'roles.permissions') ? 'true' : 'false' }}" aria-controls="sidebarSignInUsers"
                                                             data-key="t-signin">
                                                             <span style="color:orange; font-size:16px;">TRG_EVT</span>
                                                         </a>
                                                         @endcan
                                                     </li>
                                                     @endcan
                                                 </ul>
                                             </div>
                                         </li>
                                         @endcan
                                     </ul>
                                 </div>
                             </li>
                             @endcan
                             <li class="nav-item">
                                 <a href="{{ route('user.profile') }}"
                                     class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}"
                                     data-key="t-signup"> <span style="color:#09ff00; font-size:16px;"> Mon profil </span>
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </li>
                 @endcan
             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
 <!-- Left Sidebar End -->
 <!-- Vertical Overlay-->
 <div class="vertical-overlay"></div>
