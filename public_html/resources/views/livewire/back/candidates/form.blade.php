<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
    'title' => 'Nouvelle saisie',
    'breadcrumbItems' => [
    ['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Forms', 'url' => ''] ,['text' => 'CDTform', 'url' => '/candidates/create']
    ],
    ])
    <div class="row">
        <div class="col-lg-12">
            <div style="margin-top: -1%;margin-left:-10px;" class="p-2 mb-3 d-flex justify-content-between">
                <div>
                </div>
                <div>
                    <a href="{{ route('trgdashboard') }}" class="me-2 text-black {{ request()->routeIs('trgdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">TRG</a> -
                    <a href="{{ route('dashboard') }}" class="mx-2 text-black {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CDT</a> -
                    <a href="{{ route('oppdashboard') }}" class="mx-2 text-black  {{ request()->routeIs('oppdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">OPP</a> -
                    <a href="{{ route('mcpdashboard') }}" class="mx-2 text-black {{ request()->routeIs('mcpdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">MCP</a> -
                    <a href="{{ route('ctcdashboard') }}" class="mx-2 text-black {{ request()->routeIs('ctcdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CTC</a> -
                    <a href="{{ route('dashboard') }}" class="mx-2 text-black  {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">ANN</a> -
                    <a href="{{ route('cstdashboard') }}" class="ms-2 text-black {{ request()->routeIs('cstdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CST</a>
                </div>
            </div>

            <div class="card">
                <!-- <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 1 ? 'active' : '' }} fw-bold {{ $step != 1 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 1 ? '#info' : '' }}" role="tab">
                            Informations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 2 ? 'active' : '' }} fw-bold {{ $step != 2 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 2 ? '#' : '#documents' }}" role="tab">
                            Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 3 ? 'active' : '' }} fw-bold {{ $step != 3 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 3 ? '#' : '#cre' }}" role="tab">
                            C.R.E
                        </a>
                    </li>
                </ul> -->


                <div class="tab-content text-muted">
                    <div class="tab-pane fade  {{ $step == 1 ? 'show active' : '' }}" id="info" role="tabpanel">

                        <form wire:submit.prevent="storeCandidateData()">
                            @csrf
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="p-2 flex-grow-1">

                                        <!-- <h1 style="margin-left:38px; font-size:1.5rem;background:yellow;width:18%;padding:10px;text-align:center" class="mb-0 card-title ">
                                            {{ $action == 'create' ? "CDTform" : "CDTform" }}
                                        </h1> -->



                                        <div class="button-group-main">
                                            <div class="button-group-left-main">
                                                <h5 style="margin-left:-22px; background-color:yellow; border-radius:5px; color:black;padding:12px;margin-top:-2px">CDTform</h5>
                                                <div class="one">
                                                    <a href="/cdtevtlist">
                                                        <button type="button" class="btn btn-evtmain">EVT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i> </button>
                                                    </a>
                                                    <button type="button" class="btn btn-evtmain" onclick="openModal()">EVT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                                                </div>
                                                <div class="two">
                                                    <a href="/opplist">
                                                        <button type="button" class="btn btn-validmain">OPP <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                                    </a>
                                                    <button id="linkNewOPP" type="button" class="btn btn-validmain"><i class="fas fa-link"></i></button>
                                                </div>
                                                <div class="two">
                                                    <a href="/cdtmcplist">
                                                        <button type="button" class="btn btn-mcp">MCP <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                                    </a>
                                                    <button id="linkNewCDT" type="button" class="btn btn-mcp"><i class="fas fa-link"></i></button>
                                                </div>
                                                <div class="one">
                                                    <a href="">
                                                        <button type="button" class="btn"><i class="fa-regular fa-envelope fa-2x"></i></button>
                                                    </a>
                                                    <button style="color:red;" type="button" class="btn" onclick="openModal()"><i class="fa-solid fa-phone fa-2x"></i></button>
                                                </div>
                                                <div class="three">
                                                    <button type="button" class="btn btn-erase" wire:click="resetForm"><i class="fa-solid fa-eraser fa-lg"></i></button>
                                                    <a href="/candidates/create">
                                                        <button type="button" style="background:red;" wire:click="" class="btn btn-danger">
                                                            <i class="fa-regular fa-trash-can fa-lg"></i>
                                                        </button>
                                                    </a>
                                                    <button style="background-color:#00CCDD;color:white;" wire:loading.remove wire:target="storeCandidateData" type="submit"
                                                        class="btn"><i class="fa-regular fa-floppy-disk fa-lg"></i>
                                                        {{ $action == 'create' ? '' : '' }}</button>
                                                    <button wire:loading wire:target="storeCandidateData" type="button"
                                                        class="save btn btn-primary" disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span>
                                                    </button>
                                                    <a href="/landing">
                                                        <button type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    {{-- @if (!$action == 'update')
                                        <div class="p-2">
                                            <a href="{{ Route('import.candidat') }}" class="btn btn-primary">Uplodad</a>
                                </div>
                                @endif --}}
                                <!-- <div class="p-2">
                                    <a wire:click='resetForm' class="btn btn-danger"></i>Effacer</a>
                                </div> -->
                                <!-- <div class="p-2">
                                    <button wire:click.prevent="storeCandidateData2" wire:loading.remove wire:target="storeCandidateData2" type="button"
                                        class="save btn btn-success btn-label right ms-auto nexttab"><i
                                            class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                                        {{ $action == 'create' ? 'Save' : 'Save' }}</button>

                                    <button wire:loading wire:target="storeCandidateData2" type="button"
                                        class="save btn btn-primary" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Saving...
                                    </button>
                                </div> -->
                                <div class="p-2">
                                    {{-- <a href="{{ url()->previous() }}" class="btn btn-primary"><i
                                        class="mdi mdi-arrow-left me-1"></i>
                                    @if (!auth()->user()->hasRole('Administrateur'))
                                    Retour en arrirère
                                    @else
                                    Base
                                    @endif
                                    </a> --}}
                                    <!-- <a href="/dashboard" class="btn btn-secondary me-1 ms-5"><i
                                            class="mdi mdi-arrow-left me-1"></i>{{ $action == 'create' ? 'Base' : 'Base et terminer' }}</a> -->
                                </div>

                            </div>


                    </div>
                    <ul style="margin-left:5%;" class="nav nav-tabs-custom border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $step == 1 ? 'active' : '' }} fw-bold {{ $step != 1 ? 'disabled' : '' }}"
                                data-bs-toggle="tab" href="{{ $step != 1 ? '#info' : '' }}" role="tab">
                                Informations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $step == 2 ? 'active' : '' }} fw-bold {{ $step != 2 ? 'disabled' : '' }}"
                                data-bs-toggle="tab" href="{{ $step != 2 ? '#' : '#documents' }}" role="tab">
                                Documents
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $step == 3 ? 'active' : '' }} fw-bold {{ $step != 3 ? 'disabled' : '' }}"
                                data-bs-toggle="tab" href="{{ $step != 3 ? '#' : '#cre' }}" role="tab">
                                C.R.E
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="font-weight:bold;" class="nav-link"
                                href="/evts">
                                Hiring
                            </a>
                        </li>
                    </ul>
                    <div class="card-body">

                        <div class="row g-4">

                            <div class="mt-4 card">
                                <div class="card-header">
                                    <!-- <h5 class="mb-0 card-title">
                                                Informations
                                                personnelles</h5> -->
                                    <div class="col-lg-3" style="margin-left:3%">
                                        <div style="display: flex; align-items:center">
                                            <label for="origine" class="form-label" style="margin-right:5%">Date</label>
                                            <input type="text" class="form-control form-control-custom @error('origine') is-invalid @enderror"
                                                value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" disabled
                                                style="width:40%; text-align:center" />
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="margin-left:3%">
                                    <div class="row g-5">
                                        <div class="col-lg-1">
                                            <div>
                                                <label for="origine" class="form-label">Aut.</label>
                                                <input type="text" class="form-control form-control-custom  @error('origine') is-invalid @enderror "
                                                    value="{{ Auth::user()->trigramme ?? '--' }}"
                                                    placeholder="auteur" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div>
                                                <label for="origine" class="form-label">Source </label>
                                                <input type="text"
                                                    class="form-control form-control-custom  @error('origine') is-invalid @enderror "
                                                    wire:model='origine'
                                                    placeholder="Entrez la source" />
                                                @error('origine')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-auto">
                                            <div>
                                                <label for="job-category-Input" class="form-label">Civilité
                                                    <span class="text-danger">*</span></label>
                                                <select
                                                    class="form-control form-control-custom  @error('civ_id') is-invalid @enderror "
                                                    wire:model='civ_id'>
                                                    <option value="" selected>Selectionner</option>
                                                    @foreach ($civs as $civ)
                                                    <option value="{{ $civ->id }}">
                                                        {{ $civ->name }}
                                                    </option>
                                                    @endforeach

                                                </select>
                                                @error('civ_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-auto">
                                            <div>
                                                <label for="first_name" class="form-label">Prénom <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control form-control-custom  @error('first_name') is-invalid @enderror "
                                                    wire:model.live='first_name'
                                                    placeholder="Entrez le prénom" />
                                                @error('first_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-auto me-5">
                                            <div>
                                                <label for="last_name" class="form-label">Nom <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control form-control-custom  @error('last_name') is-invalid @enderror"
                                                    wire:model.live='last_name'
                                                    placeholder="Entrez le nom" />

                                                @error('last_name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-auto">
                                            <div>
                                                <label for="cv_status" class="form-label">CV</label>
                                                @php
                                                $cvFile = $candidate->files()->where('file_type', 'cv')->first();
                                                $cvStatus = $cvFile ? ' OK ' : 'N/A';
                                                $cvColor = $cvFile ? 'limegreen' : 'red';
                                                @endphp
                                                <div id="cv_status" class="p-2 text-center" style="background-color: {{ $cvColor }}; color:#ffffff">
                                                    <strong>{{ $cvStatus }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-auto">
                                            <div>
                                                <label for="cre_status" class="form-label">CRE</label>
                                                @php
                                                $creExists = $candidate->cres()->exists();
                                                $creStatus = $creExists ? 'OK' : 'N/A';
                                                $creColor = $creExists ? 'limegreen' : 'red';
                                                @endphp
                                                <div id="cre_status" class="p-2 text-center" style=" background-color: {{ $creColor }};color:#ffffff">
                                                    <strong> {{ $creStatus }} </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mt-4 col-md-2 ">
                                            <div>
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email"
                                                    class="form-control form-control-custom  @error('email') is-invalid @enderror "
                                                    wire:model.live='email'
                                                    placeholder="Entrez l'adresse email" />
                                                @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-4 col-lg-2 ">
                                            <div>
                                                <label for="phone" class="form-label">Téléphone 1 </label>
                                                <input type="text"
                                                    class="form-control form-control-custom  @error('phone') is-invalid @enderror "
                                                    wire:model='phone'
                                                    placeholder="Entrez le numéro de télépone 1" />

                                                @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-4 col-lg-2">
                                            <div>
                                                <label for="disponibility" class="form-label">Disponibilité
                                                </label>
                                                <select
                                                    class="form-control form-control-custom  @error('disponibility_id') is-invalid @enderror "
                                                    wire:model='disponibility_id'>
                                                    <option value="" selected>Selectionner</option>
                                                    @foreach ($disponibilities as $disponibility)
                                                    <option value="{{ $disponibility->id }}">
                                                        {{ $disponibility->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('disponibility_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-4 col-md-2">
                                            <div>
                                                <label for="candidate_statut_id" class="form-label">Statut
                                                </label>
                                                <select
                                                    class="form-control form-control-custom  @error('candidate_statut_id') is-invalid @enderror"
                                                    wire:model='candidate_statut_id'>
                                                    <option value="" selected>Selectionner</option>
                                                    @foreach ($candidateStatuses as $statu)
                                                    <option value="{{ $statu->id }}"
                                                        @if ($action=='update' && $statu->id == $candidate_statut_id) selected @endif>
                                                        {{ $statu->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('candidate_statut_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-4 col-lg-2">
                                            <div>
                                                <label for="next_step_id" class="form-label">Next step </label>
                                                <select
                                                    class="form-control form-control-custom  @error('next_step_id') is-invalid @enderror "
                                                    wire:model='next_step_id'>
                                                    <option value="" selected>Selectionner</option>
                                                    @foreach ($nextSteps as $nextStep)
                                                    <option value="{{ $nextStep->id }}"
                                                        @if ($nextStep->id == $next_step_id) selected @endif>
                                                        {{ $nextStep->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('next_step_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mt-4 col-lg-2">
                                            <div>
                                                <label for="ns_date_id" class="form-label">NsDate </label>
                                                <select
                                                    class="form-control form-control-custom  @error('ns_date_id') is-invalid @enderror "
                                                    wire:model='ns_date_id'>
                                                    <option value="" selected>Selectionner</option>
                                                    @foreach ($nsDates as $nsDate)
                                                    <option value="{{ $nsDate->id }}"
                                                        @if ($nsDate->id == $ns_date_id) selected @endif>
                                                        {{ $nsDate->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('ns_date_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card ">
                                <!-- <div class="card-header">
                                            <h5 class="mb-0 card-title">
                                                Coordonnées</h5>
                                        </div> -->
                                <div class="card-body" style="margin-top:-2%;margin-left:3%">
                                    <div class="row">

                                        <div class="col-lg-2 ">
                                            <div>
                                                <label for="phone_2" class="form-label">Téléphone 2</label>
                                                <input type="text"
                                                    class="form-control
                                    form-control-custom  @error('phone_2') is-invalid @enderror "
                                                    wire:model='phone_2'
                                                    placeholder="Entrez le numéro de télépone 2" />

                                                @error('phone_2')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div>
                                                <label for="vancancy-Input" class="form-label">CP/Dpt </label>
                                                <input type="text"
                                                    class="form-control
                                    form-control-custom  @error('postal_code') is-invalid @enderror "
                                                    min="0" wire:model='postal_code'
                                                    placeholder="CP/DPt" />
                                                @error('postal_code')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div>
                                                <label for="country" class="form-label">Pays </label>
                                                <input type="text"
                                                    class="form-control
                                    form-control-custom  @error('country') is-invalid @enderror "
                                                    min="0" wire:model='country'
                                                    placeholder="Veuillez entrer le pays" />
                                                @error('country')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div>
                                                <label for="region" class="form-label">Région </label>
                                                <input type="text"
                                                    class="form-control
                                    form-control-custom  @error('region') is-invalid @enderror "
                                                    min="0" wire:model='region'
                                                    placeholder="Veuillez  entrer la région" />
                                                @error('region')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div>
                                                <label for="city" class="form-label">Ville </label>
                                                <input type="text"
                                                    class="form-control
                                    form-control-custom  @error('city') is-invalid @enderror "
                                                    min="0" wire:model='city'
                                                    placeholder="Entrez la ville" />
                                                @error('city')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div>
                                                <label for="city" class="form-label">UrlCTC </label>
                                                <input type="text"
                                                    class="form-control
                                    form-control-custom  @error('url_ctc') is-invalid @enderror "
                                                    min="0" wire:model='url_ctc'
                                                    placeholder="Veuillez entrer l'UrlCTC" />
                                                @error('url_ctc')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 card">
                                <div class="card-header" style="margin-top:-2%;">
                                    <h5 class="mb-0 card-title" style="margin-left:3%">
                                        Dernier poste occupé</h5>
                                </div>
                                <div class="card-body" style="margin-left:3%">
                                    <div class="row">
                                        <div class="col-lg-auto">
                                            <div>
                                                <label for="compagny_id" class="form-label">Societé </label>
                                                <input type="text"
                                                    class="form-control
                                    form-control-custom  @error('compagny_id') is-invalid @enderror "
                                                    wire:model='compagny_id'
                                                    placeholder="Veuillez  entrer la société" />

                                                @error('compagny_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div>
                                                <label for="position_id" class="form-label">Poste (Fonction1) <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control form-control-custom @error('position_id') is-invalid @enderror"
                                                    wire:model='position_id'
                                                    placeholder="Veuillez entrer le poste" />
                                                @error('position_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div>
                                                <label for="speciality_id" class="form-label">Spécialité
                                                    (Fonction2)</label>
                                                <select
                                                    class="form-control
                                    form-control-custom  @error('speciality_id') is-invalid @enderror "
                                                    wire:model.live='speciality_id'>
                                                    @if ($specialities)
                                                    @if ($specialities->count() > 0)

                                                    <option value="" selected>Selectionner
                                                    </option>
                                                    @foreach ($specialities as $speciality)
                                                    <option value="{{ $speciality->id }}"
                                                        @if ($speciality->id == $speciality_id) selected @endif>
                                                        {{ $speciality->name }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option value="">Aucune donnée</option>

                                                    @endif
                                                    @else
                                                    <option value="">Veuillez choisir un poste
                                                    </option>
                                                    @endif
                                                </select>
                                                @error('speciality_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3 " style="width:330px">
                                            <div>
                                                <label for="field_id" class="form-label">Domaine
                                                    (Fonction3)</label>
                                                <select
                                                    class="form-control
                                    form-control-custom  @error('field_id') is-invalid @enderror "
                                                    wire:model.live='field_id'>
                                                    @if ($fields)
                                                    @if ($fields->count() > 0)

                                                    <option value="" selected>Selectionner une
                                                        spécialité
                                                    </option>
                                                    @foreach ($fields as $field)
                                                    <option value="{{ $field->id }}"
                                                        @if ($field->id == $field_id) selected @endif>
                                                        {{ $field->name }}
                                                    </option>
                                                    @endforeach
                                                    @else
                                                    <option value="">Aucune donnée</option>

                                                    @endif
                                                    @else
                                                    <option value="">Veuillez choisir une spécialité
                                                    </option>
                                                    @endif
                                                </select>
                                                @error('field_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 card">
                                <!-- <div class="card-header">
                                            <h5 class="mb-0 card-title">
                                                Commentaire et
                                                Documents</h5>
                                        </div> -->
                                <div class="card-body" style="margin-top:-3%;margin-left:3%">
                                    <div class="row">
                                        <div class="col-md-4" style="margin-right:3%">
                                            <!-- Example Textarea -->
                                            <div>
                                                <label for="commentaire" class="form-label">Commentaire
                                                </label>
                                                <textarea wire:model='commentaire' class="form-control form-control-custom " rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="margin-right:3%">
                                            <!-- Example Textarea -->
                                            <div>
                                                <label for="description" class="form-label">Description
                                                </label>
                                                <textarea wire:model='description' class="form-control form-control-custom " rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <!-- Example Textarea -->
                                            <div>
                                                <label for="suivi" class="form-label">Suivi
                                                </label>
                                                <textarea wire:model='suivi' class="form-control form-control-custom " rows="3"></textarea>
                                            </div>
                                        </div>
                                        {{--
                                                <div class="col-md-4">

                                                    <div>
                                                        <label for="cv" class="form-label">Curriculum
                                                            Vitae</label>
                                                        <input wire:model="cv"
                                                            class="form-control form-control-custom  @error('cv') is-invalid @enderror"
                                                            type="file">
                                                    </div>
                                                    @error('cv')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="cover_letter" class="form-label">Lettre de
                                                motivation</label>
                                            <input wire:model="cover_letter"
                                                class="form-control form-control-custom  @error('cover_letter') is-invalid @enderror"
                                                type="file">
                                        </div>
                                        @error('cover_letter')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="evtModal" class="modal-one">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 style="background:yellow;width:18%;padding:7px;text-align:center">CDT_EVTform</h2>
                        </div>
                        <div class="icons-row">
                            <div class="icon-item">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="icon-item">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="icon-item">
                                <i class="fas fa-pen"></i>
                            </div>
                            <div class="icon-item">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <div class="icon-item">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="status-buttons">
                            <button class="status-btn">OCC</button>
                            <button class="status-btn">NRP</button>
                            <button class="status-btn">NRJ</button>
                            <button class="status-btn">WRN</button>
                            <button class="status-btn">NHS</button>
                        </div>

                        <div id="evtForm">
                            <div class="form-row">
                                <div class="form-group date-field">
                                    <label>Date</label>
                                    <input type="date" class="form-control1" value="">
                                </div>
                                <div class="form-group type-field">
                                    <label>Type</label>
                                    <input type="text" class="form-control1">
                                </div>
                                <div class="form-group io-field">
                                    <label>I/O</label>
                                    <input type="text" class="form-control1">
                                </div>
                                <div class="form-group objet-field">
                                    <label>Objet</label>
                                    <input type="text" class="form-control1">
                                </div>
                                <div class="form-group statut-field">
                                    <label>EVTStatus</label>
                                    <input type="text" class="form-control1">
                                </div>
                                <div class="form-group retour-field">
                                    <label>Feed</label>
                                    <input type="text" class="form-control1">
                                </div>
                                <div class="form-group statut-field">
                                    <label>Temper</label>
                                    <input type="text" class="form-control1">
                                </div>
                            </div>

                            <div class="comment-section">
                                <div class="form-group comment-field">
                                    <label>Comment</label>
                                    <!-- <textarea class="form-control2"></textarea> -->
                                    <input type="text" class="form-control1">
                                </div>
                                <div class="right-section">
                                    <div class="next-ech-row">
                                        <div class="form-group next-field">
                                            <label>Next</label>
                                            <input type="text" class="form-control1">
                                        </div>
                                        <div class="form-group ech-field">
                                            <label>Ech</label>
                                            <input type="text" class="form-control1">
                                        </div>
                                        <div class="form-group ech-field">
                                            <label>Priority</label>
                                            <input type="text" class="form-control1">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="comment-section">
                                <div class="form-group retour-field">
                                    <label>Last Comment</label>
                                    <input type="text" class="form-control1">
                                </div>
                                <div class="right-section">
                                    <div class="next-ech-row">
                                        <div class="form-group last-field">
                                            <label>Date Last Com.</label>
                                            <input type="text" class="form-control1">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label>Other Comment</label>
                                    <textarea class="form-control1"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Note1</label>
                                    <textarea class="form-control1"></textarea>
                                </div>
                            </div>

                            <div class="button-group">
                                <div class="button-group-left">
                                    <div class="one">
                                        <button type="button" class="btn btn-evt">EVTlist</button>
                                        <button type="button" class="btn btn-evt"> > New</button>
                                    </div>
                                    <div class="two">
                                        <button type="button" class="btn btn-valid">Valid</button>
                                        <button type="button" class="btn btn-inputmain">Input</button>
                                    </div>
                                    <div class="three">
                                        <button type="button" class="btn btn-erase" onclick="eraseForms()">Erase</button>
                                        <button type="button" class="btn btn-close1" onclick="closeModal()">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>






                <div class="card-footer">
                    <!-- <div class="d-flex justify-content-end">
                        <button wire:loading.remove wire:target="storeCandidateData" type="submit"
                            class="save btn btn-success btn-label right ms-auto nexttab"><i
                                class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                            {{ $action == 'create' ? 'Save' : 'Save' }}</button>

                        <button wire:loading wire:target="storeCandidateData" type="button"
                            class="save btn btn-primary" disabled>
                            <span class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            Saving...
                        </button>
                    </div> -->
                </div>
                </form>


                <!-- <div style="margin-right:30%; margin-top:-4%; margin-bottom:10px;" class="d-flex justify-content-end">
                    <button style="background:black; border:none;" wire:loading.remove wire:target="" type="submit"
                        class="btn btn-success btn-label right ms-auto nexttab"><i
                            class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                        {{ $action == 'create' ? 'Call' : 'Call' }}</button>

                    <button style="background:white; border:1px solid black; color:black;" wire:loading.remove wire:target="" type="submit"
                        class="btn btn-success btn-label right ms-auto nexttab"><i
                            class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                        {{ $action == 'create' ? 'Send Mail' : 'Send Mail' }}</button>

                    <button style="background:#F93827; border:none;" wire:loading.remove wire:target="" type="submit"
                        class="btn btn-success btn-label right ms-auto nexttab" onclick="openModal()"><i
                            class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                        {{ $action == 'create' ? 'New EVT' : 'New EVT' }}</button>

                    <button style="background:#6F61C0; border:none;" wire:loading.remove wire:target="" type="submit"
                        class="btn btn-success btn-label right ms-auto nexttab"><i
                            class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                        {{ $action == 'create' ? 'Link OPP' : 'Link OPP' }}</button>

                    <button style="background:#0D92F4; border:none;" wire:loading.remove wire:target="" type="submit"
                        class="btn btn-success btn-label right ms-auto nexttab"><i
                            class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                        {{ $action == 'create' ? 'Historique' : 'Historique' }}</button>
                </div> -->




            </div>
            <!-- end tab pane -->
            <div class="tab-pane fade {{ $step == 2 ? 'show active' : '' }}" id="documents" role="tabpanel">
                <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 1 ? 'active' : '' }} fw-bold {{ $step != 1 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 1 ? '#info' : '' }}" role="tab">
                            Informations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 2 ? 'active' : '' }} fw-bold {{ $step != 2 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 2 ? '#' : '#documents' }}" role="tab">
                            Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 3 ? 'active' : '' }} fw-bold {{ $step != 3 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 3 ? '#' : '#cre' }}" role="tab">
                            C.R.E
                        </a>
                    </li>
                    <li class="nav-item">
                        <a style="font-weight:bold;" class="nav-link"
                            href="/evts">
                            Hiring
                        </a>
                    </li>
                </ul>
                <div class="col-sm-12">

                    <div>

                        <div class="card-header align-items-center d-flex border-bottom-dashed">
                            <h4 class="mb-0 card-title flex-grow-1">Documents</h4>

                            <div class="d-flex">
                                <div class="p-2 flex-grow-1">

                                    <button type="button" wire:click='goToForm'
                                        class="btn btn-sm btn-label">
                                        <i class="align-middle ri-arrow-left-line label-icon ms-2"></i>Aller
                                        vers le
                                        formulaire</button>
                                </div>
                                <div class="p-2 ">
                                    <button type="button" wire:click="openFileModal()"
                                        data-bs-toggle="modal" data-bs-target="#modal"
                                        class="btn btn-soft-info btn-sm"><i
                                            class="align-bottom ri-upload-2-fill me-1"></i>
                                        Nouveau</button>
                                </div>
                                <div class="p-2">
                                    <button type="button" wire:click='endCreate'
                                        class="btn btn-info btn-sm">
                                        Ignorer et Terminer</button>

                                </div>
                                <div class="p-2">
                                    <button type="button" wire:click='goToCre'
                                        class="btn btn-sm btn-label">
                                        <i class="align-middle ri-arrow-right-line label-icon ms-2"></i>Aller
                                        vers
                                        le CRE</button>

                                </div>
                            </div>
                        </div>


                        <div class="gap-2 vstack">
                            @if ($files)


                            @forelse ($files as $file)
                            <div class="p-2 border border-dashed rounded">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div
                                                class="rounded avatar-title bg-light text-secondary fs-24">
                                                <i class="ri-file-ppt-2-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden flex-grow-1">
                                        <h5 class="mb-1 fs-15"><a href="#"
                                                class="text-body text-truncate d-block">{{ $file->name ?? '---' }}</a>
                                        </h5>
                                        <p
                                            class="mb-0 fw-medium badge rounded-pill bg-primary fs-10">
                                            @if ($file->file_type)
                                            @if ($file->file_type == 'cv')
                                            Curriculum Vitae
                                            @elseif($file->file_type == 'cover letter')
                                            Lettre de motivation
                                            @else
                                            Autre
                                            @endif
                                            @endif
                                        </p>

                                    </div>
                                    <div class="flex-shrink-0 ms-2">
                                        <div class="gap-1 d-flex">

                                            {{-- <a class=""
                                                                href="{{ asset('storage') . '/' . $file->path }}"
                                            download="{{ $file->name }}">
                                            <i class=""></i>
                                            </a> --}}
                                            {{-- <a class="btn btn-icon text-muted btn-sm fs-18"
                                                                wire:click="downloadFile('{{ $file->path }}','{{ $file->name }}')">
                                            <i class="ri-download-2-line"></i>
                                            </a> --}}
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-icon text-muted btn-sm fs-18 dropdown"
                                                    type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ri-more-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu">

                                                    <li>

                                                        <a class="dropdown-item"
                                                            wire:click="openFileModal('{{ $file->id }}')"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal"><i
                                                                class="align-bottom ri-pencil-fill me-2 text-muted"></i>
                                                            Renommer</a>
                                                    </li>
                                                    <li><a wire:click="confirmDeleteFile('{{ $file->name }}', '{{ $file->id }}')"
                                                            class="dropdown-item"><i
                                                                class="align-bottom ri-delete-bin-fill me-2 text-muted"></i>
                                                            Supprimer</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="py-4 mt-4 text-center" id="noresult">
                                <h5 class="mt-4">Aucun document trouvé</h5>
                            </div>
                            @endforelse
                            @else
                            <div class="py-4 mt-4 text-center" id="noresult">
                                <h5 class="mt-4">Aucun document trouvé</h5>
                            </div>
                            @endif

                        </div>


                        <x-modal>
                            <x-slot name="title">
                                {{ $isUpdateFile ? 'Modification du document' : 'Ajout de document' }}
                            </x-slot>
                            <x-slot name="body">
                                <form wire:submit.prevent="storeFile()">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            @if (!$isUpdateFile)
                                            <div class="col-md-12">
                                                <label for="fileType" class="form-label">Type</label>
                                                <select wire:model="fileType"
                                                    class="form-select mb-3  @error('fileType') is-invalid @enderror">
                                                    <option value="" selected>Selectionner</option>
                                                    <option value="cv">Curriculum Vitae</option>
                                                    <option value="cover letter">Lettre de motivation</option>
                                                    <option value="other">Autre</option>
                                                    @error('fileType')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror

                                            </div>
                                            @endif
                                            @if ($isUpdateFile)
                                            <div class="col-md-12">
                                                <label for="name" class="form-label">Nom du document
                                                    <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror "
                                                    wire:model.live='name'
                                                    placeholder="Veuillez entrer le nom du document" />


                                                @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            @endif
                                            @if (!$isUpdateFile)
                                            <div class="col-md-12 ">

                                                <label for="newFile"
                                                    class="form-label ">Documents</label>
                                                <input wire:model="newFile"
                                                    class="form-control mt-4 @error('newFile') is-invalid @enderror"
                                                    type="file">
                                                @error('newFile')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit"
                                            class="btn btn-primary ">{{ $isUpdateFile ? 'Modifier' : 'Ajouter' }}</button>
                                    </div>
                                </form>
                            </x-slot>
                        </x-modal>

                    </div>


                    <!-- end card -->
                </div>
            </div>
            <!-- end tab pane -->
            <div class="tab-pane fade {{ $step == 3 ? 'show active' : '' }}" id="cre" role="tabpanel">
                <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 1 ? 'active' : '' }} fw-bold {{ $step != 1 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 1 ? '#info' : '' }}" role="tab">
                            Informations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 2 ? 'active' : '' }} fw-bold {{ $step != 2 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 2 ? '#' : '#documents' }}" role="tab">
                            Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $step == 3 ? 'active' : '' }} fw-bold {{ $step != 3 ? 'disabled' : '' }}"
                            data-bs-toggle="tab" href="{{ $step != 3 ? '#' : '#cre' }}" role="tab">
                            C.R.E
                        </a>
                    </li>
                    <li class="nav-item">
                        <a style="font-weight:bold;" class="nav-link"
                            href="/evts">
                            Hiring
                        </a>
                    </li>
                </ul>
                <div class="col-sm-12">
                    <form wire:submit.prevent="storeCre()">
                        @csrf
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="p-2 flex-grow-1">
                                    <h5 class="mb-0 card-title ">
                                        Formulaire de creation d'un C.R.E
                                    </h5>
                                </div>
                                <div class="p-2">
                                    <a wire:click='goToDoc' class="btn btn-label"><i
                                            class="align-middle ri-arrow-left-line label-icon ms-2"></i>Aller
                                        vers les documents</a>
                                </div>
                                <div class="p-2">
                                    <button type="submit" class="btn btn-primary">Enregistrer et
                                        terminer</button>
                                </div>
                                <div class="p-2">
                                    <a wire:click='endCreate' class="btn btn-info"></i>Ignorer et Terminer</a>
                                </div>
                            </div>


                        </div>
                        <div class="card-body">


                            <div class="row">
                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response1" class="form-label">1. Statut professionnel :</label>
                                        <textarea wire:model='response1' class="form-control auto-resize" id="response1"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response2" class="form-label">2. Statut personnel :</label>
                                        <textarea wire:model='response2' class="form-control auto-resize" id="response2"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>

                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response3" class="form-label">3. Situation professionnelle :</label>
                                        <textarea wire:model='response3' class="form-control auto-resize" id="response3"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response4" class="form-label">4. Points incontournables :
                                        </label>
                                        <textarea wire:model='response4' class="form-control auto-resize" id="response4"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>

                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response5" class="form-label">5. Savoir-être du candidat :
                                        </label>
                                        <textarea wire:model='response5' class="form-control auto-resize" id="response5"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response6" class="form-label">6. Prise de référence(s) :</label>
                                        <textarea wire:model='response6' class="form-control auto-resize" id="response6"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>

                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response7" class="form-label">7. Prétentions salariales :</label>
                                        <textarea wire:model='response7' class="form-control auto-resize" id="response7"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response8" class="form-label">8. Disponibilités candidat :</label>
                                        <textarea wire:model='response8' class="form-control auto-resize" id="response8"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 col-md-12">
                                    <div>
                                        <label for="response7" class="form-label">9. Résumé du parcours professionnel :</label>
                                        <textarea wire:model='response9' class="form-control auto-resize" id="response9"
                                            style="resize: none; overflow-y: hidden;"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">

                            <div class="d-flex justify-content-between">
                                <button type="button" wire:click='goToForm'
                                    class="btn btn-secondary btn-label nexttab"><i
                                        class="align-middle ri-arrow-left-line label-icon fs-16 ms-2"></i>Aller
                                    vers les documents</button>
                                <button type="submit" wire:click='goToCre'
                                    class="btn btn-success btn-label right ms-auto nexttab">Enregistrer
                                    et Terminer</button>
                            </div>
                        </div>

                    </form>
                    <!-- end card -->
                </div>
                <!--end card-->
            </div>
            <!-- end tab pane -->

            <!-- end tab pane -->
        </div>
    </div>
</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .btn-mcp {
        background-color: #7D0A0A;
        color: white;
    }

    .btn-mcp:hover {
        background-color: #7D0A0A;
        color: white;
    }


    .save {
        background-color: #06D001;
    }

    .btn-evtmain {
        background-color: #F9C0AB;
        color: black;
        margin-left: 10px;
    }

    .btn-evtmain:hover {
        background-color: #F9C0AB;
        color: black;
    }


    .btn-evt {
        background-color: #F9C0AB;
        color: black;
    }

    .btn-evt:hover {
        background-color: #F9C0AB;
        color: black;
    }

    .btn-call {
        background-color: black;
        color: white;
        margin-left: 10px;
    }

    .btn-call:hover {
        background-color: black;
        color: white;

    }

    .btn-sendmail {
        background-color: white;
        color: black;
        margin-left: 10px;
        border: 1px solid black;

    }

    .btn-sendmail:hover {
        background-color: white;
        color: black;
        border: 1px solid black;
    }



    .btn-inputmain {
        background-color: #06D001;
        color: white;
    }

    .btn-inputmain:hover {
        background-color: #06D001;
        color: white;
    }


    .modal-one {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        margin: 5% auto;
        padding: 20px 25px;
        width: 80%;
        max-width: 900px;
        border-radius: 2px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        margin-bottom: 5px;
        margin-left: -12px;
    }

    .modal-header h2 {
        color: #333;
        font-size: 1.4em;
        font-weight: 500;
        margin-right: 10px;
    }

    .icons-row {
        display: flex;
        gap: 25px;
        margin-top: 5px;
        margin-bottom: -20px;
        padding-left: 5px;
    }

    .icon-item {
        font-size: 18px;
        color: #555;
    }

    .divider {
        height: 1px;
        background-color: #ddd;
        margin: 12px 0;
    }

    .status-buttons {
        display: flex;
        gap: 20px;
        margin-top: -5px;
        margin-bottom: 20px;
        font-size: 1rem;
        justify-content: flex-end;
    }

    .status-btn {
        padding: 2px 8px;
        border: none;
        text-decoration: underline;
        background: none;
        cursor: pointer;
        font-weight: 500;
        color: #333;
        font-size: 0.9em;
    }

    .form-row {
        display: flex;
        gap: 15px;
        margin-top: 5px;
        margin-bottom: 15px;
        align-items: flex-start;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .date-field {
        width: 90px;
    }

    .type-field {
        width: 60px;
    }

    .io-field {
        width: 60px;
    }

    .date-field {
        width: 115px;
    }

    .objet-field {
        width: 200px;
    }

    .retour-field {
        width: 200px;
    }

    .statut-field {
        width: 80px;
    }

    .comment-section {
        display: flex;
        gap: 15px;
    }

    .comment-field {
        flex: 1;
        max-width: 60%;
    }

    .right-section {
        flex: 1;
        max-width: 40%;
    }

    .next-ech-row {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
    }

    .next-field,
    .ech-field {
        flex: 1;
    }

    label {
        color: black;
    }

    .form-control1 {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 13px;
        background-color: #f8f8f8;
    }

    .form-control2 {
        width: 100%;
        padding: 6px 8px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 13px;
        background-color: #f8f8f8;
    }

    textarea.form-control1 {
        min-height: 100px;
        resize: vertical;
    }

    textarea.form-control2 {
        min-height: 177px;
        resize: vertical;
    }

    .button-group-main {
        display: flex;
        justify-content: space-between;
        /* margin-top: -55px; */
        margin-bottom: 20px;
        margin-left: 50px;
        padding: 0 20px;
    }

    .button-group-left-main {
        display: flex;
        gap: 40px;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: -30px;
        margin-left: -20px;
        padding: 0 20px;
    }

    .button-group-left {
        display: flex;
        gap: 20px;
    }

    .button-group-right {
        display: flex;
    }

    /* 
    .btn {
        padding: 6px 16px;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        font-weight: 500;
        font-size: 0.9em;
        min-width: 80px;
    } */

    .btn-input {
        background-color: #00c853;
        color: white;
    }

    .btn-input:hover {
        background-color: #00c853;
        color: white;
    }

    .btn-erase {
        background-color: #ff5722;
        color: white;
    }

    .btn-valid {
        background-color: #6F61C0;
        color: white;
    }

    .btn-valid:hover {
        background-color: #6F61C0;
        color: white;
    }

    .btn-validmain {
        background-color: #6F61C0;
        color: white;
        margin-left: 10px;
    }

    .btn-validmain:hover {
        background-color: #6F61C0;
        color: white;
    }

    .btn-erase:hover {
        background-color: #ff5722;
        color: white;
    }

    .btn-historique {
        background-color: #2196f3;
        color: white;
    }

    .btn-historique:hover {
        background-color: #2196f3;
        color: white;
    }

    .btn-close1 {
        background-color: #000080;
        color: white;
    }

    .btn-close1:hover {
        background-color: #000080;
        color: white;
    }


    .evt-button {
        background: #FF77B7;
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .evt-button i {
        font-size: 14px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</div>
@push('page-script')
<script>
    document.querySelector('.date-field input').valueAsDate = new Date();
    document.addEventListener("input", function(event) {
        if (event.target.tagName.toLowerCase() !== "textarea") return;
        autoResize(event.target);
    }, false);

    function autoResize(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = (textarea.scrollHeight) + "px";
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.auto-resize').forEach(function(textarea) {
            autoResize(textarea);
        });

    });

    function openModal() {
        document.getElementById('evtModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('evtModal').style.display = 'none';
    }

    function eraseForm() {
        const modal = document.getElementById('evtForm');
        const inputs = modal.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.value = '';
        });
    }


    window.onclick = function(event) {
        const modal = document.getElementById('evtModal');
        if (event.target === modal) {
            closeModal();
        }
    }

    document.getElementById('evtForm').addEventListener('submit', function(e) {
        e.preventDefault();
    });
</script>
@endpush