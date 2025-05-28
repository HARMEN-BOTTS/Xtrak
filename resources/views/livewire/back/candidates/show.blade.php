<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
    'title' => 'Détail du candidat',
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


            <div class="card mt-n8 mx-n4">
                <div class="bg-secondary-subtle">
                    @if (session()->has('success'))
                    <div class="d-flex justify-content-center mt-3">
                        <div class="alert alert-success alert-dismissible fade show " role="alert" id="successAlert">
                            {{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    <div class="card-body pb-0 px-4">
                        <div class="row mb-3">

                            <div class="col-md">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-auto">
                                        <div class="avatar-md">
                                            <div class="avatar-title bg-white rounded-circle">
                                                <img src="{{ asset('assets/images/brands/slack.png') }}" alt=""
                                                    class="avatar-xs">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div>
                                            <h4 class="fw-bold">{{ $candidate->first_name ?? '--' }}
                                                {{ $candidate->last_name ?? '--' }}
                                            </h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div><i class="ri-building-line align-bottom me-1"></i>
                                                    {{ $candidate->compagny->name ?? '--' }}
                                                </div>
                                                <div class="vr"></div>
                                                <div>Date de création : <span
                                                        class="fw-medium">{{ $candidate->created_at->format('d/m/Y') ?? '--' }}
                                                    </span></div>
                                                <div class="vr"></div>
                                                <div>Statut : <span
                                                        class="fw-medium badge rounded-pill bg-primary fs-12">{{ $candidate->candidateStatut->name ?? '--' }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div>Etat : <span
                                                        class="fw-medium badge rounded-pill bg-primary fs-12">{{ $candidate->candidateState->name ?? '--' }}</span>
                                                </div>
                                                <div class="vr"></div>
                                                <div>Certificat : @if ($candidate->certificate)
                                                    <span class="badge rounded-pill bg-success"
                                                        id="certificate-{{ 0 }}"
                                                        onclick="toggleCertificate({{ 0 }})">
                                                        <span
                                                            id="hidden-certificate-{{ 0 }}">••••••••</span>
                                                        <span id="visible-certificate-{{ 0 }}"
                                                            style="display: none;">{{ $candidate->certificate }}</span>
                                                    </span>
                                                    @else
                                                    ---
                                                    @endif

                                                    <div id="message-{{ 0 }}" style="display: none;"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-auto">


                              
                            </div>

                        </div>

                     


                        <form wire:submit.prevent="storeData()">
                            <div class="button-group-main">
                                <div class="button-group-left-main">
                                    <h5 style="margin-left:-70px; background-color:yellow; border-radius:5px; color:black;padding:12px;margin-top:-2px">CDTform</h5>
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
                                        <button style="background:red;" type="button" wire:click="confirmDelete('{{ $candidate->name }}', '{{ $candidate->id }}')" class="btn btn-danger">
                                            <i class="fa-regular fa-trash-can fa-lg"></i>
                                        </button>
                                        <button style="background-color:#00CCDD;color:white;" wire:loading.remove wire:target="storeData" type="submit"
                                            class="btn"><i class="fa-regular fa-floppy-disk fa-lg"></i>
                                        </button>
                                        <button wire:loading wire:target="storeData" type="button"
                                            class="save btn btn-primary" disabled>
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </button>
                                        <a href="/landing">
                                            <button type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                                        </a>
                                        <a href="/dashboard">
                                            <button type="button" class="btn btn-close1"><i class="mdi mdi-arrow-left me-1"></i>Vue</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>




                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active fw-bold" data-bs-toggle="tab" href="#info" role="tab">
                                    Informations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" data-bs-toggle="tab" href="#documents" role="tab">
                                    Documents
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" data-bs-toggle="tab" href="#cre" role="tab">
                                    C.R.E
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" data-bs-toggle="tab" href="#hp" role="tab">
                                    Hiring Process
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content text-muted">
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card mt-4">
                                            <div class="card-header align-items-center d-flex border-bottom-dashed" style="margin-left:3%">
                                                <!-- <h4 class="card-title mb-0 flex-grow-1">Informations</h4> -->
                                                <div class="col-lg-auto">
                                                    <div style="display: flex; align-items:center">
                                                        <label for="origine" class="form-label" style="margin-right:5%;margin-left:8%">Dernière MAJ</label>
                                                        <input type="text" class="form-control form-control-custom @error('origine') is-invalid @enderror"
                                                            value="{{ $candidate->updated_at->format('d-m-Y') }}" disabled
                                                            style="width:40%; text-align:center" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-body" style="margin-top:-2%">

                                                <form wire:submit.prevent="storeData()">
                                                    @csrf

                                                    <div class="card-body">


                                                        <div class="row">
                                                            <div class="card">
                                                                <!-- <div class="card-header">
                                                                    <h5
                                                                        class="card-title
                                                                    mb-0">
                                                                        Informations
                                                                        personnelles</h5>
                                                                </div> -->
                                                                <div class="card-body" style="margin-left:3%">
                                                                    <div class="row g-4">
                                                                        <div class="col-lg-1">
                                                                            <div>
                                                                                <label for="origine"
                                                                                    class="form-label">Aut.</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('origine') is-invalid @enderror "
                                                                                    value=" {{ $candidate->auteur->trigramme ?? '--' }}"
                                                                                    placeholder="auteur" disabled />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <div>
                                                                                <label for="origine"
                                                                                    class="form-label">Source </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('origine') is-invalid @enderror "
                                                                                    wire:model='origine'
                                                                                    placeholder="Source" />
                                                                                @error('origine')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <div>
                                                                                <label for="origine"
                                                                                    class="form-label"> CodeCDT</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('origine') is-invalid @enderror "
                                                                                    value=" {{ $candidate->code_cdt}}"
                                                                                    placeholder="auteur" disabled style="width:100px" />

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-auto">
                                                                            <div>
                                                                                <label for="job-category-Input"
                                                                                    class="form-label">Civilité <span
                                                                                        class="text-danger">*</span></label>
                                                                                <select
                                                                                    class="form-control form-control-custom  @error('civ_id') is-invalid @enderror "
                                                                                    wire:model='civ_id'>
                                                                                    <option value="" selected>
                                                                                        Selectionner</option>
                                                                                    @foreach ($civs as $civ)
                                                                                    <option
                                                                                        value="{{ $civ->id }}">
                                                                                        {{ $civ->name }}
                                                                                    </option>
                                                                                    @endforeach

                                                                                </select>
                                                                                @error('civ_id')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 me-4">
                                                                            <div>
                                                                                <label for="first_name"
                                                                                    class="form-label">Prénom <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('first_name') is-invalid @enderror "
                                                                                    wire:model.live='first_name'
                                                                                    placeholder="Veuillez entrer le prénom" />
                                                                                @error('first_name')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 me-4">
                                                                            <div>
                                                                                <label for="last_name"
                                                                                    class="form-label">Nom <span
                                                                                        class="text-danger">*</span> </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('last_name') is-invalid @enderror"
                                                                                    wire:model.live='last_name'
                                                                                    placeholder="Veuillez entrer le nom" />

                                                                                @error('last_name')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        @php
                                                                        $cvFile = $candidate->files()->where('file_type', 'cv')->first();
                                                                        $cvStatus = $cvFile ? ' OK ' : 'N/A';
                                                                        $cvColor = $cvFile ? 'limegreen' : 'red';
                                                                        @endphp

                                                                        @if ($cvStatus === ' OK ')
                                                                        <a class="col-lg-auto" href="{{ route('candidate.cv', ['candidate' => $candidate->id]) }}" style="display: block; color: inherit; text-decoration: none;">
                                                                            @else
                                                                            <a class="col-lg-auto" href="#documents" style="display: block; color: inherit; text-decoration: none; cursor:pointer;" onclick="handleClickCV()">
                                                                                @endif
                                                                                <div>
                                                                                    <div>
                                                                                        <label for="cv_status" class="form-label">CV</label>
                                                                                        <div id="cv_status" class="p-2 text-center" style="background-color: {{ $cvColor }}; color:#ffffff">
                                                                                            <strong>{{ $cvStatus }}</strong>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </a>

                                                                            @php
                                                                            $creExists = $candidate->cres()->exists();
                                                                            $creStatus = $creExists ? 'OK' : 'N/A';
                                                                            $creColor = $creExists ? 'limegreen' : 'red';
                                                                            @endphp

                                                                            @if ($creStatus === 'OK')
                                                                            <a class="col-lg-auto" href="{{ route('candidate.cre', ['candidate' => $candidate->id]) }}" style="display: block; color: inherit; text-decoration: none; cursor:pointer;" onclick="handleClickCRE()">
                                                                                @else
                                                                                <a class="col-lg-auto" href="{{ route('add.cre', ['candidate' => $candidate, 'action' => 'create']) }}" style="display: block; color: inherit; text-decoration: none; cursor:pointer;" onclick="handleClickCRE()">
                                                                                    @endif
                                                                                    <div>
                                                                                        <div>
                                                                                            <label for="cre_status" class="form-label">CRE</label>
                                                                                            <div id="cre_status" class="p-2 text-center" style="background-color: {{ $creColor }}; color:#ffffff">
                                                                                                <strong>{{ $creStatus }}</strong>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-2 mt-4">
                                                                            <div>
                                                                                <label for="email"
                                                                                    class="form-label">Email <span
                                                                                        class="text-danger">*</span></label>
                                                                                <input type="email"
                                                                                    class="form-control form-control-custom  @error('email') is-invalid @enderror "
                                                                                    wire:model.live='email'
                                                                                    placeholder="Adresse E-mail" />
                                                                                @error('email')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 mt-4">
                                                                            <div>
                                                                                <label for="phone"
                                                                                    class="form-label">Téléphone 1
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('phone') is-invalid @enderror "
                                                                                    wire:model='phone'
                                                                                    placeholder="Téléphone 1" />

                                                                                @error('phone')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 mt-4">
                                                                            <div>
                                                                                <label for="disponibility"
                                                                                    class="form-label">Disponibilité
                                                                                </label>
                                                                                <select
                                                                                    class="form-control form-control-custom  @error('disponibility_id') is-invalid @enderror "
                                                                                    wire:model='disponibility_id'>
                                                                                    <option value="" selected>
                                                                                        Selectionner</option>
                                                                                    @foreach ($disponibilities as $disponibility)
                                                                                    <option
                                                                                        value="{{ $disponibility->id }}">
                                                                                        {{ $disponibility->name }}
                                                                                    </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('disponibility_id')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 mt-4">
                                                                            <div>
                                                                                <label for="candidate_statut_id"
                                                                                    class="form-label">Statut </label>
                                                                                <select
                                                                                    class="form-control form-control-custom  @error('candidate_statut_id') is-invalid @enderror"
                                                                                    wire:model='candidate_statut_id'>
                                                                                    <option value="" selected>
                                                                                        Selectionner</option>
                                                                                    @foreach ($candidateStatuses as $statu)
                                                                                    <option
                                                                                        value="{{ $statu->id }}"
                                                                                        @if ($statu->id == $candidate_statut_id) selected @endif>
                                                                                        {{ $statu->name }}
                                                                                    </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('candidate_statut_id')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 mt-4">
                                                                            <div>
                                                                                <label for="next_step_id"
                                                                                    class="form-label">Next step
                                                                                </label>
                                                                                <select
                                                                                    class="form-control form-control-custom  @error('next_step_id') is-invalid @enderror "
                                                                                    wire:model='next_step_id'>
                                                                                    <option value="" selected>
                                                                                        Selectionner</option>
                                                                                    @foreach ($nextSteps as $nextStep)
                                                                                    <option
                                                                                        value="{{ $nextStep->id }}">
                                                                                        {{ $nextStep->name }}
                                                                                    </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('next_step_id')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 mt-4">
                                                                            <div>
                                                                                <label for="ns_date_id" class="form-label">NsDate </label>
                                                                                <select
                                                                                    class="form-control form-control-custom  @error('ns_date_id') is-invalid @enderror "
                                                                                    wire:model='ns_date_id'>
                                                                                    <option value="" selected>Selectionner</option>
                                                                                    @foreach ($nsDates as $nsDate)
                                                                                    <option value="{{ $nsDate->id }}" @if ($nsDate->id == $ns_date_id )
                                                                                        selected
                                                                                        @endif>
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
                                                                    <h5
                                                                        class="card-title
                                                                    mb-0">
                                                                        Addresse</h5>
                                                                </div> -->
                                                                <div class="card-body" style="margin-top:-2%;margin-left:3%">
                                                                    <div class="row">
                                                                        <div class="col-lg-2 ">
                                                                            <div>
                                                                                <label for="phone_2"
                                                                                    class="form-label">Téléphone
                                                                                    2</label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('phone_2') is-invalid @enderror "
                                                                                    wire:model='phone_2'
                                                                                    placeholder="Télépone 2" />

                                                                                @error('phone_2')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <div>
                                                                                <label for="vancancy-Input"
                                                                                    class="form-label">CP/Dpt </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('postal_code') is-invalid @enderror "
                                                                                    min="0"
                                                                                    wire:model='postal_code'
                                                                                    placeholder="CP" />
                                                                                @error('postal_code')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <div>
                                                                                <label for="city"
                                                                                    class="form-label">Ville </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('city') is-invalid @enderror "
                                                                                    min="0" wire:model='city'
                                                                                    placeholder="Ville" />
                                                                                @error('city')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 ">
                                                                            <div>
                                                                                <label for="country"
                                                                                    class="form-label">Pays </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('country') is-invalid @enderror "
                                                                                    min="0"
                                                                                    wire:model='country'
                                                                                    placeholder="Pays" />
                                                                                @error('country')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            <div>
                                                                                <label for="region"
                                                                                    class="form-label">Région </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('region') is-invalid @enderror "
                                                                                    min="0" wire:model='region'
                                                                                    placeholder="Région" />
                                                                                @error('region')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2" style="width:14%">
                                                                            <div>
                                                                                <label for="urlctc"
                                                                                    class="form-label">UrlCTC </label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom  @error('url_ctc') is-invalid @enderror "
                                                                                    min="0"
                                                                                    wire:model='url_ctc'
                                                                                    placeholder="UrlCTC" />
                                                                                @error('url_ctc')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card">
                                                                <div class="card-header" style="margin-top:-1%">
                                                                    <h5
                                                                        class="card-title
                                                                    mb-0" style="margin-left:3%">
                                                                        Dernier poste occupé</h5>
                                                                </div>
                                                                <div class="card-body" style="margin-left:3%">
                                                                    <div class="row g-5">
                                                                        <div class="col-lg-2">
                                                                            <div>
                                                                                <label for="compagny_id"
                                                                                    class="form-label">Societé </label>
                                                                                <input type="text"
                                                                                    class="form-control  
                                form-control-custom  @error('compagny_id') is-invalid @enderror "
                                                                                    wire:model='compagny_id'
                                                                                    placeholder="Société" />
                                                                                @error('compagny_id')
                                                                                <span
                                                                                    class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-3">
                                                                            <div>
                                                                                <label for="position_id" class="form-label">Poste (Fonction1) <span class="text-danger">*</span></label>
                                                                                <input type="text"
                                                                                    class="form-control form-control-custom @error('position_name') is-invalid @enderror"
                                                                                    wire:model.lazy="position_name"
                                                                                    placeholder="Veuillez entrer le poste" />
                                                                                @error('position_name')
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
                                                                                    <option value="">Choisir un poste</option>
                                                                                    @endif
                                                                                </select>
                                                                                @error('speciality_id')
                                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <div>
                                                                                <label for="field_id" class="form-label">Domaine
                                                                                    (Fonction3)</label>
                                                                                <select
                                                                                    class="form-control  
                                form-control-custom  @error('field_id') is-invalid @enderror "
                                                                                    wire:model.live='field_id'>
                                                                                    @if ($fields)
                                                                                    @if ($fields->count() > 0)

                                                                                    <option value="" selected>Selectionner une spécialité
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
                                                                                    <option value="">Choisir une spécialité</option>
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
                                                            <div class="card mt-4">

                                                                <div class="card-body" style="margin-top:-2%;margin-left:3%">
                                                                    <div class="row g-5">
                                                                        <div class="col-lg-4 me-5">
                                                                            <!-- Example Textarea -->
                                                                            <div>
                                                                                <label for="commentaire"
                                                                                    class="form-label">Commentaire
                                                                                </label>
                                                                                <textarea wire:model='commentaire' class="form-control form-control-custom " rows="3"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 me-5">
                                                                            <!-- Example Textarea -->
                                                                            <div>
                                                                                <label for="description"
                                                                                    class="form-label">Description
                                                                                </label>
                                                                                <textarea wire:model='description' class="form-control form-control-custom " rows="3"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <!-- Example Textarea -->
                                                                            <div>
                                                                                <label for="Suivi"
                                                                                    class="form-label">Suivi
                                                                                </label>
                                                                                <textarea wire:model='suivi' class="form-control form-control-custom " rows="3"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                    <!-- <div class="card-footer" style="margin-top:-3%">
                                                        <div class="d-flex justify-content-end">
                                                            <button wire:loading.remove wire:target="storeData"
                                                                type="submit" class="btn btn-success">
                                                                Enregistrer
                                                            </button>
                                                            <button wire:loading wire:target="storeData"
                                                                type="button" class="btn btn-success" disabled>
                                                                <span class="spinner-border spinner-border-sm"
                                                                    role="status" aria-hidden="true"></span>
                                                                Enregistrement...
                                                            </button>
                                                        </div>
                                                    </div> -->

                                                </form>









                                                <div id="evtModal" class="modal-one">
                                                    <div class="modal-content">
                                                        <div style="display: flex; align-items: center; gap: 13px;margin-bottom:3%;">
                                                            <h5 style="background:yellow;width:15%;padding:7px;text-align:center;margin: 0;">CDT_EVTform</h5>
                                                            <h5 style="margin-left:3%; margin-top:1%;" class="@error('civ_id') is-invalid @enderror">
                                                                @if($civ_id)
                                                                @foreach ($civs as $civ)
                                                                @if($civ->id == $civ_id)
                                                                {{ $civ->name }}
                                                                @endif
                                                                @endforeach
                                                                @else
                                                                -
                                                                @endif
                                                            </h5>
                                                            <h5 class="@error('first_name') is-invalid @enderror" style="margin: 0;">
                                                                {{ $first_name }}
                                                            </h5>
                                                            <h5 class="@error('last_name') is-invalid @enderror" style="margin: 0;">
                                                                {{ $last_name }}
                                                            </h5>
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
                                                                <div class="form-group ech-field">
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





<!--                                                 <div class="button-group-main">
                                                    <div class="button-group-left-main">
                                                        <div class="four">
                                                            <button type="button" class="btn btn-call">Call</button>
                                                            <button type="button" class="btn btn-sendmail">Send Mail</button>
                                                        </div>
                                                        <div class="one">
                                                            <button type="button" class="btn btn-evtmain">EVTlist</button>
                                                            <button type="button" class="btn btn-evtmain" onclick="openModal()"> > New</button>
                                                        </div>
                                                        <div class="two">
                                                            <button type="button" class="btn btn-validmain">OPPlist</button>
                                                            <a href="/opportunity/create">
                                                                <button type="button" class="btn btn-validmain"> > New</button>
                                                            </a>
                                                        </div>
                                                        <div class="three">
                                                            <button type="button" class="btn btn-erase" onclick="eraseForms()">Erase</button>
                                                            <button type="button" class="btn btn-close1" onclick="closeModal()">Close</button>
                                                        </div>
                                                    </div>
                                                </div> -->













                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                        <!-- end card -->
                                    </div>
                                    <!-- ene col -->

                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane fade" id="documents" role="tabpanel">
                                <div class="col-sm-12">

                                    @livewire('back.files.candidate-file', ['candidate' => $candidate])
                                    <!-- end card -->
                                </div>
                            </div>
                            <!-- end tab pane -->
                            <div class="tab-pane fade" id="cre" role="tabpanel">
                                <div class="col-sm-12">
                                    @livewire('back.cres.index', ['candidate' => $candidate])
                                    <!-- end card -->
                                </div>
                                <!--end card-->
                            </div>


                            <div class="tab-pane fade" id="hp" role="tabpanel">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="card">
                                            <div class="interview-form">
                                                <!-- PUSCH CV Section -->
                                                <div class="form-section">
                                                    <div class="section-header">PUSCH CV</div>
                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label>Sent_TRG</label>
                                                            <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Retour</label>
                                                            <select class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="positif">Positif</option>
                                                                <option value="en-cours">En cours</option>
                                                                <option value="negatif">Négatif</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Debrief TRG</label>
                                                            <input type="text" class="form-input wide" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Rém. souhaitée</label>
                                                            <input type="text" class="form-input">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Préf. géo</label>
                                                            <input type="text" class="form-input">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Mobilité</label>
                                                            <select class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="non">Non</option>
                                                                <option value="regionale">Régionale</option>
                                                                <option value="nationale">Nationale</option>
                                                                <option value="internationale">Internationale</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- RV Tél. 1 -->
                                                    <!-- <div class="form-section"> -->
                                                    <div class="section-header">RV Tél. 1</div>
                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label>Prévu</label>
                                                            <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Statut</label>
                                                            <input type="text" class="form-input" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Avec</label>
                                                            <input type="text" class="form-input" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Fonction</label>
                                                            <input type="text" class="form-input">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Comment./Debrief</label>
                                                            <input type="text" class="form-input extra-wide" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Retour</label>
                                                            <select class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="positif">Positif</option>
                                                                <option value="en-cours">En cours</option>
                                                                <option value="negatif">Négatif</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <!-- Visio -->

                                                    <div class="section-header">Visio</div>
                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label>Prévu</label>
                                                            <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Statut</label>
                                                            <input type="text" class="form-input" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Avec</label>
                                                            <input type="text" class="form-input" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Fonction</label>
                                                            <input type="text" class="form-input">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Comment./Debrief</label>
                                                            <input type="text" class="form-input extra-wide">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Retour</label>
                                                            <select class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="positif">Positif</option>
                                                                <option value="en-cours">En cours</option>
                                                                <option value="negatif">Négatif</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- RV PHYSIQUE 1 -->

                                                    <div class="section-header">RV PHYSIQUE 1</div>
                                                    <div class="form-content">
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label>Prévu</label>
                                                                <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Statut</label>
                                                                <input type="text" class="form-input" value="">
                                                            </div>
                                                            <div class="participant-column">
                                                                <label>Avec</label>
                                                                <div class="stacked-inputs">
                                                                    <input type="text" class="form-input" value="">
                                                                    <input type="text" class="form-input" value="">
                                                                    <input type="text" class="form-input" value="">
                                                                </div>
                                                            </div>
                                                            <div class="function-column">
                                                                <label>Fonction</label>
                                                                <div class="stacked-inputs">
                                                                    <input type="text" class="form-input" value="">
                                                                    <input type="text" class="form-input" value="">
                                                                    <input type="text" class="form-input" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Comment./Debrief</label>
                                                                <textarea style="height:160px;" type="text" class="form-input extra-wide"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Retour</label>
                                                                <select class="form-select">
                                                                    <option value="">Select</option>
                                                                    <option value="positif">Positif</option>
                                                                    <option value="en-cours">En cours</option>
                                                                    <option value="negatif">Négatif</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div style="margin-top:-12%;" class="form-row">
                                                            <div class="form-group">
                                                                <label>Lieu</label>
                                                                <input style="width:300px;" type="text" class="form-input">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- RV PHYSIQUE 2 -->

                                                    <div class="section-header">RV PHYSIQUE 2</div>
                                                    <div class="form-content">
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label>Prévu</label>
                                                                <input style="width:auto;" type="date" class="form-input" placeholder="dd/mm/yy">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Statut</label>
                                                                <input type="text" class="form-input" value="">
                                                            </div>
                                                            <div class="participant-column">
                                                                <label>Avec</label>
                                                                <div class="stacked-inputs">
                                                                    <input type="text" class="form-input" value="">
                                                                    <input type="text" class="form-input" value="">
                                                                    <input type="text" class="form-input" value="">
                                                                </div>
                                                            </div>
                                                            <div class="function-column">
                                                                <label>Fonction</label>
                                                                <div class="stacked-inputs">
                                                                    <input type="text" class="form-input" value="">
                                                                    <input type="text" class="form-input" value="">
                                                                    <input type="text" class="form-input" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Comment./Debrief</label>
                                                                <textarea style="height:160px;" type="text" class="form-input extra-wide"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Retour</label>
                                                                <select class="form-select">
                                                                    <option value="">Select</option>
                                                                    <option value="positif">Positif</option>
                                                                    <option value="en-cours">En cours</option>
                                                                    <option value="negatif">Négatif</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div style="margin-top:-12%;" class="form-row">
                                                            <div class="form-group">
                                                                <label>Lieu</label>
                                                                <input style="width:300px;" type="text" class="form-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="button-container">
                                                        <button id="modifyButton" class="modify-btn">Modify</button>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                        <!--end card-->
                                    </div>

                                    <!-- end tab pane -->

                                    <!-- end tab pane -->
                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                    </div>
                    <!-- end card -->
                </div>
            </div>
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

                label {
                    color: black;
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


                .form-control1 {
                    width: 100%;
                    padding: 8px 10px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    font-size: 13px;
                    background-color: #f8f8f8;
                }

                .form-control5 {
                    width: 50%;
                    border: none;
                    padding: 8px 10px;
                    border: 1px solid white;
                    border-radius: 8px;
                    font-size: 20px;
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









                .interview-form {
                    font-family: 'Inter', system-ui, -apple-system, sans-serif;
                    max-width: 1200px;
                    padding: 2rem;
                    color: #1a1a1a;
                }

                .form-section {
                    margin-bottom: 1rem;
                    background: #ffffff;
                    border-radius: 12px;
                    padding: 1.5rem;
                    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
                    transition: box-shadow 0.2s ease-in-out;
                }

                .form-section:hover {
                    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
                }

                .section-header {
                    font-size: 1.125rem;
                    font-weight: 600;
                    margin-bottom: 0.8rem;
                    color: #111827;
                    letter-spacing: -0.025em;
                }

                .form-row {
                    display: flex;
                    align-items: flex-start;
                    gap: 1.5rem;
                    margin-bottom: 1.5rem;
                    flex-wrap: wrap;
                }

                .form-input,
                .form-select {
                    background-color: #f9fafb;
                    border: 1px solid #006BFF;
                    border-radius: 8px;
                    padding: 0.75rem 1rem;
                    font-size: 0.875rem;
                    width: 120px;
                    transition: all 0.2s ease-in-out;
                }

                .form-input:hover,
                .form-select:hover {
                    border-color: #d1d5db;
                }

                .form-input:focus,
                .form-select:focus {
                    outline: none;
                    border-color: #2563eb;
                    box-shadow: 0 0 0 4px rgb(37 99 235 / 0.1);
                }

                .form-input.wide {
                    width: 200px;
                }

                .form-input.extra-wide {
                    width: 300px;
                    /* height: 150px; */
                }

                .form-select {
                    height: 42px;
                    appearance: none;
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
                    background-repeat: no-repeat;
                    background-position: right 0.75rem center;
                    background-size: 1rem;
                    padding-right: 2.5rem;
                }

                .form-input[readonly] {
                    background-color: #f3f4f6;
                    border-color: #e5e7eb;
                    cursor: not-allowed;
                    color: #6b7280;
                }

                .multi-participant {
                    display: grid;
                    grid-template-columns: 200px 300px 1fr auto;
                    gap: 1.5rem;
                    align-items: start;
                }

                .participant-column,
                .function-column {
                    display: flex;
                    flex-direction: column;
                    gap: 0.75rem;
                }

                .stacked-inputs {
                    display: flex;
                    flex-direction: column;
                    gap: 0.75rem;
                    margin-top: -12px;
                }

                .full-width {
                    width: 100%;
                }

                .full-width .form-input {
                    width: 100%;
                }

                /* Base styles for both inputs and selects */
                .form-input,
                .form-select {
                    background-color: #f9fafb;
                    border: 1px solid #006BFF;
                    border-radius: 8px;
                    padding: 0.75rem 1rem;
                    font-size: 0.875rem;
                    width: 120px;
                    transition: all 0.2s ease-in-out;
                }

                .form-select {
                    cursor: pointer;
                    appearance: none;
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23006BFF'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
                    background-repeat: no-repeat;
                    background-position: right 0.75rem center;
                    background-size: 1rem;
                    padding-right: 2.5rem;
                }

                .form-select option {
                    padding: 0.75rem 1rem;
                }

                .form-select option[value="positif"],
                .form-select[data-selected="positif"] {
                    color: #047857;
                    background-color: #ecfdf5;
                }

                .form-select option[value="en-cours"],
                .form-select[data-selected="en-cours"] {
                    color: #b45309;
                    background-color: #fffbeb;
                }

                .form-select option[value="negatif"],
                .form-select[data-selected="negatif"] {
                    color: #b91c1c;
                    background-color: #fef2f2;
                }

                .form-select:focus {
                    outline: none;
                    box-shadow: 0 0 0 2px rgba(0, 107, 255, 0.2);
                }

                /* Modern custom scrollbar */
                .form-select::-webkit-scrollbar {
                    width: 8px;
                }

                .form-select::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 4px;
                }

                .form-select::-webkit-scrollbar-thumb {
                    background: #d1d5db;
                    border-radius: 4px;
                }

                .form-select::-webkit-scrollbar-thumb:hover {
                    background: #9ca3af;
                }

                @media (max-width: 1200px) {
                    .multi-participant {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 1rem;
                    }
                }

                @media (max-width: 768px) {
                    .interview-form {
                        padding: 1rem;
                    }

                    .form-section {
                        padding: 1rem;
                    }

                    .form-row {
                        flex-direction: column;
                        gap: 1rem;
                    }

                    .form-input,
                    .form-select,
                    .form-input.wide,
                    .form-input.extra-wide {
                        width: 100%;
                    }

                    .multi-participant {
                        grid-template-columns: 1fr;
                    }
                }


                @media (prefers-color-scheme: dark) {
                    .interview-form {
                        color: #e5e7eb;
                    }

                    .form-section {
                        background: #1f2937;
                        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.4);
                    }

                    .section-header {
                        color: #f3f4f6;
                    }

                    .form-group label {
                        color: #d1d5db;
                    }

                    .form-input,
                    .form-select {
                        background-color: #374151;
                        border-color: #4b5563;
                        color: #e5e7eb;
                    }

                    .form-input:hover,
                    .form-select:hover {
                        border-color: #6b7280;
                    }

                    .form-input[readonly] {
                        background-color: #1f2937;
                        border-color: #374151;
                        color: #9ca3af;
                    }
                }

                .button-container {
                    display: flex;
                    justify-content: center;
                    margin-top: 5%;
                }

                .modify-btn {
                    padding: 10px 30px;
                    font-size: 16px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }

                .modify-btn:hover {
                    background-color: #45a049;
                }

                .modify-btn.save {
                    background-color: #2196F3;
                }

                .modify-btn.save:hover {
                    background-color: #1976D2;
                }




                .modals {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    z-index: 1000;
                }

                .modal-contents {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background-color: white;
                    padding: 20px;
                    border-radius: 5px;
                    text-align: center;
                    width: 300px;
                    max-width: 90%;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                .modal-buttons {
                    margin-top: 20px;
                }

                .modal-btn {
                    padding: 8px 20px;
                    margin: 0 10px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .modal-btn.confirm {
                    background-color: #4CAF50;
                    color: white;
                }

                .modal-btn.cancel {
                    background-color: #f44336;
                    color: white;
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




            function toggleCertificate(index) {
                var hiddenCertificate = document.getElementById('hidden-certificate-' + index);
                var visibleCertificate = document.getElementById('visible-certificate-' + index);
                var messageDiv = document.getElementById('message-' + index);

                if (hiddenCertificate.style.display === "none") {
                    hiddenCertificate.style.display = "inline";
                    visibleCertificate.style.display = "none";
                    messageDiv.style.display = "none";
                } else {
                    hiddenCertificate.style.display = "none";
                    visibleCertificate.style.display = "inline";


                    navigator.clipboard.writeText(visibleCertificate.textContent).then(function() {
                        messageDiv.textContent = 'Copie réussie !';
                        messageDiv.style.display = "block";
                        setTimeout(function() {
                            messageDiv.style.display = "none";
                        }, 1000);
                    }, function(err) {
                        messageDiv.textContent = 'Erreur lors de la copie : ' + err;
                        messageDiv.style.display = "block";
                        setTimeout(function() {
                            messageDiv.style.display = "none";
                        }, 1000);
                    });
                }
            }
        </script>
        <script>
            setTimeout(function() {
                var successAlert = document.getElementById('successAlert');
                if (successAlert) {
                    successAlert.style.display = 'none';
                }
            }, 3000);

            function handleClickCV() {
                // Get the tab link
                var tabLink = document.querySelector('a[href="#documents"]');

                // Create a new 'click' event
                var clickEvent = new MouseEvent('click', {
                    'view': window,
                    'bubbles': true,
                    'cancelable': false
                });

                // Dispatch the 'click' event on the tab link
                tabLink.dispatchEvent(clickEvent);
            }


            document.body.insertAdjacentHTML('beforeend', `
    <div id="modifyModal" class="modals">
        <div class="modal-contents">
            <h3>Do you want to modify this form?</h3>
            <div class="modal-buttons">
                <button class="modal-btn confirm" id="confirmModify">Yes</button>
                <button class="modal-btn cancel" id="cancelModify">No</button>
            </div>
        </div>
    </div>
`);

            const modifyButton = document.getElementById('modifyButton');
            const modal = document.getElementById('modifyModal');
            const confirmBtn = document.getElementById('confirmModify');
            const cancelBtn = document.getElementById('cancelModify');
            const formInputs = document.querySelectorAll('input, select, textarea');


            modifyButton.addEventListener('click', function() {
                if (this.textContent === 'Modify') {
                    modal.style.display = 'block';
                } else {
                    saveForm();
                }
            });

            confirmBtn.addEventListener('click', function() {
                modal.style.display = 'none';
                modifyButton.textContent = 'Save';
                modifyButton.classList.add('save');

                // formInputs.forEach(input => {
                //     input.disabled = false;
                // });
            });

            cancelBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            function saveForm() {
                modifyButton.textContent = 'Modify';
                modifyButton.classList.remove('save');

                // formInputs.forEach(input => {
                //     input.disabled = true;
                // });
                alert('Form saved successfully ✅');
            }
        </script>
        @endpush
