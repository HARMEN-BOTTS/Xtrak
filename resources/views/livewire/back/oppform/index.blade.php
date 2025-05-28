<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
    'title' => 'Nouvelle saisie',
    'breadcrumbItems' => [
    ['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Forms', 'url' => ''] ,['text' => 'OPPform', 'url' => '/opportunity']
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
                <div class="tab-content text-muted">
                    <div class="tab-pane fade  {{ $step == 1 ? 'show active' : '' }}" id="info" role="tabpanel">
                        <form wire:submit.prevent="save">
                            @csrf
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="p-2 flex-grow-1">
                                        <!-- <h2 class="mb-0 card-head">
                                            {{ $action == 'create' ? "FormOPP" : "FormOPP" }}
                                        </h2> -->


                                        <div class="button-group">
                                            <div class="button-group-left">
                                                <h5 style="margin-left:-22px; background-color:#6F61C0; border-radius:5px; color:white;padding:12px;margin-top:-2px">OPPform</h5>
                                                <a href="/opportunity">
                                                    <button style="background:#6F61C0;color:white;" type="button" class="btn btn-close1">OPP<i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                                                </a>
                                                <div class="two">
                                                    <a href="/oppcstlist">
                                                        <button type="button" class="btn btn-cst">CST <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                                    </a>
                                                    <button type="button" class="btn btn-cst"><i class="fas fa-link"></i></button>
                                                </div>
                                                <div class="one">
                                                    <a href="/oppcdtlist">
                                                        <button type="button" class="btn btn-cdt">CDT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i> </button>
                                                    </a>
                                                    <button type="button" class="btn btn-cdt"><i class="fas fa-link"></i></button>
                                                </div>
                                                <div class="one">
                                                    <a href="">
                                                        <button type="button" class="btn btn-evt">EVT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i> </button>
                                                    </a>
                                                    <button type="button" class="btn btn-evt" onclick="openModal()">EVT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                                                </div>
                                                <div class="three">
                                                    <button type="button" class="btn btn-erase" wire:click="resetForm"><i class="fa-solid fa-eraser fa-lg"></i></button>
                                                    <a href="/opportunity">
                                                        <button style="background-color:red;color:white;" type="button" class="btn"><i class="fa-regular fa-trash-can fa-lg"></i></button>
                                                    </a>
                                                    <button type="submit" class="btn btn-valid"><i class="fa-regular fa-floppy-disk fa-lg"></i></button>
                                                    <a href="/landing">
                                                        <button type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ $step == 1 ? 'active' : '' }} fw-bold {{ $step != 1 ? 'enabled' : '' }}"
                                        data-bs-toggle="tab" href="{{ $step != 1 ? '#info' : '' }}" role="tab">
                                        Description
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $step == 0 ? 'active' : '' }} fw-bold {{ $step != 0 ? 'enabled' : '' }}"
                                        data-bs-toggle="tab" href="{{ $step != 1 ? '#job' : '' }}" role="tab">
                                        F.P.
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link {{ $step == 2 ? 'active' : '' }} fw-bold {{ $step != 2 ? 'enabled' : '' }}"
                                        href="/management">
                                        CDTlist
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link {{ $step == 4 ? 'active' : '' }} fw-bold {{ $step != 4 ? 'enabled' : '' }}"
                                        href="/evts">
                                        Hiring
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a wire:click="goToCre" class="nav-link {{ $step == 3 ? 'active' : '' }} fw-bold {{ $step != 3 ? 'enabled' : '' }}"
                                        data-bs-toggle="tab" href="{{ $step != 3 ? '#' : '#invoicement' }}" role="tab">
                                        Invoicing
                                    </a>
                                </li>

                            </ul>
                            <div class="card-body">

                                @if (session()->has('message'))
                                <div style="margin-top:-1%;" class="d-flex justify-content-left">
                                    <div style="font-weight:bold;" class="alert alert-success alert-dismissible fade show " role="alert" id="successAlert">
                                        {{ session()->get('message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                                @endif

                                <div class="row g-4">

                                    <div class="mt-2 card">
                                        <div class="card-body" style="margin-top: 1%;">
                                            <div class="row g-2">
                                                <div class="col-lg-2">
                                                    <div>
                                                        <label class="form-label">Date</label>
                                                        <input
                                                            type="date"
                                                            class="form-control form-control-custom-1 @error('opportunity_date') is-invalid @enderror"
                                                            wire:model="opportunity_date"
                                                            value="{{ old('opportunity_date') ?? now()->format('Y-m-d') }}"
                                                            placeholder="Select a date" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div>
                                                        <label class="form-label">OPPCode</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('opp_code') is-invalid @enderror "
                                                            wire:model='opp_code'
                                                            readonly
                                                            placeholder="Auto Generated" />
                                                        @error('opp_code')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div>
                                                        <label class="form-label">Aut.</label>
                                                        <input type="text" class="form-control form-control-custom-1  @error('origine') is-invalid @enderror "
                                                            value="{{ Auth::user()->trigramme ?? '--' }}"
                                                            wire:model="auth"
                                                            placeholder="auteur" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div>
                                                        <label class="form-label">TRGCode</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('trg_code') is-invalid @enderror "
                                                            wire:model='trg_code'
                                                            placeholder="TRGCode" />
                                                        @error('trg_code')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-auto">
                                                    <div>
                                                        <label class="form-label">Dénomination sociale<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('name') is-invalid @enderror "
                                                            wire:model='name'
                                                            placeholder="Dénomination sociale" />
                                                        @error('name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div>
                                                        <label class="form-label">CP<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('postal_code_1') is-invalid @enderror "
                                                            wire:model='postal_code_1'
                                                            placeholder="CP" />
                                                        @error('postal_code_1')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div>
                                                        <label class="form-label">Ville<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('site_city') is-invalid @enderror"
                                                            wire:model.live='site_city'
                                                            placeholder="Ville" />

                                                        @error('site_city')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="card-header" style="margin-top:1%;">
                                                    <h5 class="mb-0 card-title">
                                                        Contact de référence</h5>
                                                </div>
                                                <div class="mt-2 col-md-2">
                                                    <div>
                                                        <label class="form-label">CTC Code</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('ctc1_code') is-invalid @enderror "
                                                            wire:model='ctc1_code'
                                                            placeholder="CTCcode" />
                                                        @error('ctc1_code')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mt-2 col-md-2">
                                                    <div>
                                                        <label class="form-label">Civ</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('civs') is-invalid @enderror "
                                                            wire:model='civs'
                                                            placeholder="Civ" />
                                                        @error('civs')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>




                                                <div class="mt-2 col-lg-2 ">
                                                    <div>
                                                        <label for="ctc1_first_name" class="form-label">Prénom<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('ctc1_first_name') is-invalid @enderror "
                                                            wire:model='ctc1_first_name'
                                                            placeholder="Prénom" />

                                                        @error('ctc1_first_name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mt-2 col-lg-2 ">
                                                    <div>
                                                        <label for="ctc1_last_name" class="form-label">Nom<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('ctc1_last_name') is-invalid @enderror "
                                                            wire:model='ctc1_last_name'
                                                            placeholder="Nom" />

                                                        @error('ctc1_last_name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mt-2 col-lg-2 ">
                                                    <div>
                                                        <label class="form-label">Fonction<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('position') is-invalid @enderror "
                                                            wire:model='position'
                                                            placeholder="Fonction" />

                                                        @error('position')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mt-2 col-lg-2 ">
                                                    <div>
                                                        <label class="form-label">Remarque(s)</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1  @error('remarks') is-invalid @enderror "
                                                            wire:model='remarks'
                                                            placeholder="Remarkque(s)" />

                                                        @error('remarks')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" style="margin-top:-3%;">
                                            <h5 class="mb-0 card-title">
                                                Poste and Location</h5>
                                        </div>
                                        <div class="card-body" style="margin-top:-1%;">
                                            <div class="row">
                                                <div class="col-lg-2 ">
                                                    <div>
                                                        <label for="job_titles" class="form-label">Job title<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control
                                    form-control-custom-1  @error('job_titles') is-invalid @enderror "
                                                            min="0" wire:model='job_titles'
                                                            placeholder="Job title" />
                                                        @error('job_titles')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Speciality</label>
                                                        <input type="text"
                                                            class="form-control
                                    form-control-custom-1  @error('specificities') is-invalid @enderror "
                                                            min="0" wire:model='specificities'
                                                            placeholder="Speciality" />
                                                        @error('specificities')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Domain</label>
                                                        <input type="text"
                                                            class="form-control
                                    form-control-custom-1  @error('domain') is-invalid @enderror "
                                                            min="0" wire:model='domain'
                                                            placeholder="Domain" />
                                                        @error('domain')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">CP/DPT<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control
                                    form-control-custom-1  @error('postal_code') is-invalid @enderror "
                                                            min="0" wire:model='postal_code'
                                                            placeholder="CP/DPT" />
                                                        @error('postal_code')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Town<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control
                                    form-control-custom-1  @error('town') is-invalid @enderror "
                                                            min="0" wire:model='town'
                                                            placeholder="Town" />
                                                        @error('town')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Country<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control
                                    form-control-custom-1  @error('country') is-invalid @enderror "
                                                            min="0" wire:model='country' />
                                                        @error('country')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 card">
                                        <div class="card-header" style="margin-top:-2%;">
                                            <h5 class="mb-0 card-title">
                                                Attendus</h5>
                                        </div>
                                        <div class="card-body" style="margin-top:-1%;">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div>
                                                        <label class="form-label">Expérience<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control
                                    form-control-custom-1  @error('experience') is-invalid @enderror "
                                                            wire:model='experience'
                                                            placeholder="Exp" />

                                                        @error('experience')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div>
                                                        <label class="form-label">Scolarité</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('schooling') is-invalid @enderror"
                                                            wire:model='schooling'
                                                            placeholder="Scolarité" />
                                                        @error('schooling')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div>
                                                        <label class="form-label">Horaires</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('schedules') is-invalid @enderror"
                                                            wire:model='schedules'
                                                            placeholder="Hor" />
                                                        @error('schedules')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div>
                                                        <label class="form-label">Mobilité</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('mobility') is-invalid @enderror"
                                                            wire:model='mobility'
                                                            placeholder="Mobilité" />
                                                        @error('mobility')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div>
                                                        <label class="form-label">Permis</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('permission') is-invalid @enderror"
                                                            wire:model='permission'
                                                            placeholder="Per" />
                                                        @error('permission')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div>
                                                        <label class="form-label">Type</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('type') is-invalid @enderror"
                                                            wire:model='type'
                                                            placeholder="Type" />
                                                        @error('type')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div>
                                                        <label class="form-label">Véhiculé</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('vehicle') is-invalid @enderror"
                                                            wire:model='vehicle'
                                                            placeholder="Véhiculé" />
                                                        @error('vehicle')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div>
                                                        <label class="form-label">Job offer letter
                                                        </label>
                                                        <input
                                                            type="date"
                                                            wire:model='job_offer_date'
                                                            class="form-control form-control-custom-1 @error('job_offer_date') is-invalid @enderror"
                                                            value="{{ old('job_offer_date') ?? now()->format('Y-m-d') }}"
                                                            placeholder="Select a date" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 card">
                                        <div class="card-header" style="margin-top:-3%;">
                                            <h5 class="mb-0 card-title">
                                                Compétences</h5>
                                        </div>
                                        <div class="card-body" style="margin-top:-1%;">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Skill 1</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('skill_one') is-invalid @enderror"
                                                            wire:model='skill_one'
                                                            placeholder="Skill 1" />
                                                        @error('skill_one')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Skill 2</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('skill_two') is-invalid @enderror"
                                                            wire:model='skill_two'
                                                            placeholder="Skill 2" />
                                                        @error('skill_two')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Skill 3</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('skill_three') is-invalid @enderror"
                                                            wire:model='skill_three'
                                                            placeholder="Skill 3" />
                                                        @error('skill_three')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Autres</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('other_one') is-invalid @enderror"
                                                            wire:model='other_one'
                                                            placeholder="Autres" />
                                                        @error('other_one')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Remarque(s)</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('remarks_two') is-invalid @enderror"
                                                            wire:model='remarks_two'
                                                            placeholder="Remarque(s)" />
                                                        @error('remarks_two')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Onboarding term</label>
                                                        <input type="date"
                                                            class="form-control form-control-custom-1 @error('job_start_date') is-invalid @enderror"
                                                            wire:model='job_start_date'
                                                            placeholder="Onboarding term" />
                                                        @error('job_start_date')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="invo">
                                                        <label class="mt-3 form-label">Invoicement date</label>
                                                        <input type="date"
                                                            class="form-control form-control-custom-1 @error('invoice_date') is-invalid @enderror"
                                                            wire:model='invoice_date'
                                                            placeholder="Invoicement date" />
                                                        @error('invoice_date')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mt-4 card">
                                        <div class="card-header" style="margin-top:-3%;">
                                            <h5 class="mb-0 card-title">Package</h5>
                                        </div>
                                        <div class="card-body" style="margin-top:-1%;">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Brut annuel<span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('gross_salary') is-invalid @enderror"
                                                            wire:model='gross_salary'
                                                            placeholder="Brut annuel" />
                                                        @error('gross_salary')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Avantage 1</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('bonus_1') is-invalid @enderror"
                                                            wire:model='bonus_1'
                                                            placeholder="Avantage 1" />
                                                        @error('bonus_1')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Avantage 2</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('bonus_2') is-invalid @enderror"
                                                            wire:model='bonus_2'
                                                            placeholder="Avantage 2" />
                                                        @error('bonus_2')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Avantage 3</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('bonus_3') is-invalid @enderror"
                                                            wire:model='bonus_3'
                                                            placeholder="Avantage 3" />
                                                        @error('bonus_3')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <label class="form-label">Autres</label>
                                                        <input type="text"
                                                            class="form-control form-control-custom-1 @error('other_two') is-invalid @enderror"
                                                            wire:model='other_two'
                                                            placeholder="Autres" />
                                                        @error('other_two')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div>
                                                        <label class="form-label">Date emb.
                                                        </label>
                                                        <input
                                                            type="date"
                                                            class="form-control form-control-custom-1 @error('date_emb') is-invalid @enderror"
                                                            name="date_emb"
                                                            value="{{ old('date_emb') ?? now()->format('Y-m-d') }}"
                                                            placeholder="Select a date" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="cdtModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered cdt-modal-dialog">
                                    <div class="modal-content cdt-modal-content">
                                        <div class="cdt-modal-header">
                                            <span>Enter CDT code:</span>
                                            <button type="button" class="cdt-close-btn" data-bs-dismiss="modal">×</button>
                                        </div>
                                        <div class="cdt-modal-body">
                                            <div class="cdt-input-group">
                                                <input type="text" class="cdt-input" id="cdtCode" value="ADTGFHU">
                                                <button type="button" class="cdt-ok-btn" id="okButton">OK</button>
                                            </div>
                                            <div class="cdt-message">("message CDT")</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- <div class="card-footer" style="margin-top: -3%;">
                        <div class="d-flex justify-content-end">
                            <button style="background:green; border:none;" wire:loading.remove wire:target="storeCandidateData" type="submit"
                                class="btn btn-success btn-label right ms-auto nexttab"><i
                                    class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                                {{ $action == 'create' ? 'Facturation' : 'Facturation' }}</button>
                                <button style="background:green; border:none;" wire:loading.remove wire:target="storeCandidateData" type="submit"
                                class="btn btn-success btn-label right ms-auto nexttab"><i
                                    class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                                {{ $action == 'create' ? 'Facturation' : 'Facturation' }}</button>
                            <button wire:loading wire:target="storeCandidateData" type="button"
                                class="btn btn-primary" disabled>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Enregistrement...
                            </button>
                        </div>
                    </div> -->



                    </div>

                    </form>


                    <!-- end tab pane -->



                    <div class="tab-pane fade {{ $step == 2 ? 'show active' : '' }}" id="management" role="tabpanel">
                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 1 ? 'active' : '' }} fw-bold {{ $step != 1 ? 'enabled' : '' }}"
                                    data-bs-toggle="tab" href="{{ $step != 1 ? '#info' : '' }}" role="tab">
                                    Description
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 2 ? 'active' : '' }} fw-bold {{ $step != 2 ? 'enabled' : '' }}"
                                    href="/management">
                                    CDTlist
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 4 ? 'active' : '' }} fw-bold {{ $step != 4 ? 'enabled' : '' }}"
                                    href="/evts">
                                    Hiring
                                </a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="goToCre" class="nav-link {{ $step == 3 ? 'active' : '' }} fw-bold {{ $step != 3 ? 'enabled' : '' }}"
                                    data-bs-toggle="tab" href="{{ $step != 3 ? '#' : '#invoicement' }}" role="tab">
                                    Facturation
                                </a>
                            </li>

                        </ul>
                        <div class="col-sm-12">

                            <div>

                                <div class="card-header align-items-center d-flex border-bottom-dashed">
                                    <div class="recruitment-container">
                                        <div class="table-container">
                                            <table class="recruitment-table">
                                                <thead>
                                                    <tr>
                                                        <th class="with-border">Date</th>
                                                        <th class="with-border">CodeCDT</th>
                                                        <th class="with-border">Civ.</th>
                                                        <th class="with-border">Prénom</th>
                                                        <th class="with-border">Nom</th>
                                                        <th class="with-border">Fonction</th>
                                                        <th class="with-border">Dispo.</th>
                                                        <th class="with-border">Délai</th>
                                                        <th class="with-border">Statut</th>
                                                        <th class="with-border">Next step</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="with-border">10/10/24</td>
                                                        <td class="with-border">GRTHKUX</td>
                                                        <td class="with-border">MME</td>
                                                        <td class="with-border">Aurélie</td>
                                                        <td class="with-border">MONFION</td>
                                                        <td class="with-border">Resp. Sureté Nucléaire</td>
                                                        <td class="with-border">Préavis négo.</td>
                                                        <td class="with-border">3 mois</td>
                                                        <td class="with-border">
                                                            <select class="status-select">
                                                                <option>Linké</option>
                                                                <option>Validé</option>
                                                                <option>Présenté</option>
                                                                <option>RV tél OK</option>
                                                                <option>RV phys. prévu</option>
                                                                <option>Prom. acceptée</option>
                                                            </select>
                                                        </td>
                                                        <td class="with-border">
                                                            <select class="status-select">
                                                                <option>A valider</option>
                                                                <option>Présenter</option>
                                                                <option>RV tél prévu</option>
                                                                <option>RV phy prévu</option>
                                                                <option>Non retenu</option>
                                                                <option>Promesse emb.</option>
                                                                <option>Non retenu</option>
                                                                <option>Embauché</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="with-border">09/10/24</td>
                                                        <td class="with-border">ADTGFHU</td>
                                                        <td class="with-border">M</td>
                                                        <td class="with-border">Chboub</td>
                                                        <td class="with-border">SCHBOUBA</td>
                                                        <td class="with-border">Chef d'équipe</td>
                                                        <td class="with-border">Immédiate</td>
                                                        <td class="with-border">1 mois</td>
                                                        <td class="with-border">
                                                            <select class="status-select">
                                                                <option>Validé</option>
                                                                <option>Linké</option>
                                                                <option>Présenté</option>
                                                                <option>RV tél OK</option>
                                                                <option>RV phys. prévu</option>
                                                                <option>Prom. acceptée</option>
                                                            </select>
                                                        </td>
                                                        <td class="with-border">
                                                            <select class="status-select">
                                                                <option>Présenter</option>
                                                                <option>A valider</option>
                                                                <option>RV tél prévu</option>
                                                                <option>RV phy prévu</option>
                                                                <option>Non retenu</option>
                                                                <option>Promesse emb.</option>
                                                                <option>Non retenu</option>
                                                                <option>Embauché</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border">
                                                            <select class="status-select">
                                                                <!-- <option>Select</option>  -->
                                                            </select>
                                                        </td>
                                                        <td class="with-border">
                                                            <select class="status-select">
                                                                <!-- <option>Select</option> -->
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border"></td>
                                                        <td class="with-border">
                                                            <select class="status-select">
                                                                <!-- <option>Select</option> -->
                                                            </select>
                                                        </td>
                                                        <td class="with-border">
                                                            <select class="status-select">
                                                                <!-- <option>Select</option> -->
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="button-container">
                                            <button class="link-btn" id="linkNewCDT">LINK NEW CDT</button>
                                            <button class="unlink-btn" id="unlinkBtn" style="display:none;">UNLINK</button>
                                        </div>
                                    </div>


                                    <div id="editModal" class="modal-row">
                                        <div class="modal-content-row">
                                            <span class="close-row">&times;</span>
                                            <h3>Edit Row</h3>
                                            <form id="editForm">
                                                <label>Date :</label>
                                                <input type="text" id="editDate"><br>
                                                <label>CodeCDT :</label>
                                                <input type="text" id="editCode"><br>
                                                <label>Civ :</label>
                                                <input type="email" id="editCiv"><br>
                                                <label>Prénom :</label>
                                                <input type="text" id="editfirst"><br>
                                                <label>Nom :</label>
                                                <input type="text" id="editlast"><br>
                                                <label>Fonction :</label>
                                                <input type="text" id="editfunc"><br>
                                                <label>Dispo :</label>
                                                <input type="text" id="editdispo"><br>
                                                <label>Délai :</label>
                                                <input type="text" id="editdetail"><br>
                                                <!-- <label>Statut :</label>
                                            <input type="text" id="editstatut"><br>
                                            <label>Next Step :</label>
                                            <input type="text" id="editnext"><br> -->
                                                <button type="button" id="saveBtn">Save</button>
                                                <button type="button" id="cancelBtn">Cancel</button>
                                            </form>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="cstModal" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered cdt-modal-dialog">
                                            <div class="modal-content cdt-modal-content">
                                                <div class="cdt-modal-header">
                                                    <span>Enter CST code:</span>
                                                    <button type="button" class="cdt-close-btn" data-bs-dismiss="modal">×</button>
                                                </div>
                                                <div class="cdt-modal-body">
                                                    <div class="cdt-input-group">
                                                        <input type="text" class="cdt-input" id="cstCode" value="ADTGFHU">
                                                        <button type="button" class="cdt-ok-btn" id="okButtonCST">OK</button>
                                                    </div>
                                                    <div class="cdt-message">("message CST")</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>






                            </div>

                            <!-- end card -->
                        </div>
                    </div>
                    <!-- end tab pane -->
                    <div class="tab-pane fade {{ $step == 3 ? 'show active' : '' }}" id="invoicement" role="tabpanel">
                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 1 ? 'active' : '' }} fw-bold {{ $step != 1 ? 'enabled' : '' }}"
                                    data-bs-toggle="tab" href="{{ $step != 1 ? '#info' : '' }}" role="tab">
                                    Description
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 2 ? 'active' : '' }} fw-bold {{ $step != 2 ? 'enabled' : '' }}"
                                    href="/management">
                                    CDTlist
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $step == 4 ? 'active' : '' }} fw-bold {{ $step != 4 ? 'enabled' : '' }}"
                                    href="/evts">
                                    Hiring
                                </a>
                            </li>
                            <li class="nav-item">
                                <a wire:click="goToCre" class="nav-link {{ $step == 3 ? 'active' : '' }} fw-bold {{ $step != 3 ? 'enabled' : '' }}"
                                    data-bs-toggle="tab" href="{{ $step != 3 ? '#' : '#invoicement' }}" role="tab">
                                    Facturation
                                </a>
                            </li>

                        </ul>
                        <div class="col-sm-12">
                            <form wire:submit.prevent="storeCre()">
                                @csrf
                                <div class="card-header">
                                    <div class="form-container">
                                        <!-- Contact Section -->
                                        <div class="section">
                                            <div class="section-title">Accountancy Contact</div>
                                            <div class="contact-grid">
                                                <div class="field-group">
                                                    <label class="field-label">CTCcode</label>
                                                    <input type="text" class="field-input field-readonly" value="EFDGTHY" readonly>
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Title</label>
                                                    <select class="field-select">
                                                        <option>Mme</option>
                                                        <option>Mlle</option>
                                                        <option>M.</option>
                                                    </select>
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">First name</label>
                                                    <input type="text" class="field-input" value="Laura">
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Last name</label>
                                                    <input type="text" class="field-input" value="Faure">
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Position</label>
                                                    <input type="text" class="field-input" value="Accountant">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="main-layout">
                                            <!-- Left Column -->
                                            <div class="left-column">
                                                <!-- Calculation Section -->
                                                <div class="section">
                                                    <div class="section-title">Calc. Reference Base</div>
                                                    <div class="calc-grid">
                                                        <div class="field-group">
                                                            <label class="field-label">Gross sal.</label>
                                                            <input type="text" class="field-input currency-input" value="150.236" id="grossSal">
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Advant. 1</label>
                                                            <input type="text" class="field-input currency-input" value="12.000" id="advant1">
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Advant. 2</label>
                                                            <input type="text" class="field-input currency-input" value="15.500" id="advant2">
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Advant. 3</label>
                                                            <input type="text" class="field-input currency-input" value="7.500" id="advant3">
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Total base<span class="required">*</span></label>
                                                            <input type="text" class="field-input currency-input field-readonly" id="totalBase" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="calc-grid">
                                                        <div class="field-group">
                                                            <label class="field-label">Base hono.</label>
                                                            <input type="text" class="field-input field-readonly" id="baseHono" readonly>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Warant. ext.</label>
                                                            <input type="text" class="field-input field-readonly" id="warantExt" readonly>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Total HT</label>
                                                            <input type="text" class="field-input field-readonly" id="totalHT" readonly>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">VAT</label>
                                                            <select class="field-select vat-select">
                                                                <option>20%</option>
                                                            </select>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Total TTC<span class="required">*</span></label>
                                                            <input type="text" class="field-input field-readonly" id="totalTTC" readonly>
                                                        </div>
                                                    </div>

                                                    <!-- Invoice Details -->
                                                    <div class="payment-schedule">
                                                        <div class="calc-grid">
                                                            <div class="field-group">
                                                                <label class="field-label">Inv. date</label>
                                                                <input type="text" class="field-input" value="31/08/24">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Inv. ref.</label>
                                                                <input type="text" class="field-input" value="874452">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Sent on:</label>
                                                                <input type="text" class="field-input" value="31/08/24">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Remark(s)</label>
                                                                <input type="text" class="field-input" value="---">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Payment Schedule -->
                                                    <div class="payment-schedule">
                                                        <div class="payment-row">
                                                            <div class="field-group">
                                                                <label class="field-label">Due date 1</label>
                                                                <input type="text" class="field-input" value="10/09/24">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Amount 1</label>
                                                                <input type="text" class="field-input currency-input" value="xxx">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Paid 1</label>
                                                                <input type="text" class="field-input currency-input" value="xxx">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">PayDate 1</label>
                                                                <input type="text" class="field-input" value="10/09/24">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Balance 1</label>
                                                                <input type="text" class="field-input currency-input field-readonly" value="0" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="payment-row">
                                                            <div class="field-group">
                                                                <label class="field-label">Due date 2</label>
                                                                <input type="text" class="field-input" value="12/11/24">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Amount 2</label>
                                                                <input type="text" class="field-input currency-input" value="xxx">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Paid 2</label>
                                                                <input type="text" class="field-input currency-input" value="xxx">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">PayDate 2</label>
                                                                <input type="text" class="field-input" value="12/11/24">
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Balance 2</label>
                                                                <input type="text" class="field-input currency-input field-readonly" value="0" readonly>
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Total bal.:</label>
                                                                <input type="text" class="field-input currency-input field-readonly" value="0" readonly>
                                                            </div>
                                                            <div class="field-group">
                                                                <label class="field-label">Paym. status</label>
                                                                <input type="text" class="field-input field-readonly status-paid" value="PAID" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="right-column">
                                                <div class="section">
                                                    <div class="section-title">Fees</div>
                                                    <div class="fees-grid">
                                                        <div class="field-group">
                                                            <label class="field-label">Type</label>
                                                            <select class="field-select" id="feeType" onchange="handleFeeTypeChange()">
                                                                <option value="%">%</option>
                                                                <option value="Fee">Fee</option>
                                                            </select>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Exec.</label>
                                                            <input type="text" class="field-input" value="25.0" id="execFee">
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Non-exec.</label>
                                                            <input type="text" class="field-input field-readonly" value="---" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="fees-grid">
                                                        <div class="field-group">
                                                            <label class="field-label">Warant ext.</label>
                                                            <select class="field-select">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">%</label>
                                                            <input type="text" class="field-input" value="5.0">
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">VAT</label>
                                                            <select class="field-select">
                                                                <option>20%</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="fees-grid">
                                                        <div class="field-group">
                                                            <label class="field-label">CST</label>
                                                            <input type="text" class="field-input field-readonly" value="(TXT)" readonly>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">%</label>
                                                            <input type="text" class="field-input" value="5.0">
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Total HT</label>
                                                            <input type="text" class="field-input currency-input field-readonly" value="2.779" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="right-grid">
                                                        <div class="field-group">
                                                            <label class="field-label">Invoicement term</label>
                                                            <select class="field-select">
                                                                <option>Promesse d'emb.</option>
                                                            </select>
                                                        </div>
                                                        <div class="field-group">
                                                            <label class="field-label">Payment term</label>
                                                            <select class="field-select">
                                                                <option>10 JN DF, DF=DPE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="right-grid">
                                                        <div class="field-group">
                                                            <label class="field-label">Note(s)</label>
                                                            <textarea class="field-input notes-field">---</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="button-group">
                                                <div class="button-group-left">
                                                    <div class="one">
                                                        <button type="button" class="btn btn-evt">EVTlist</button>
                                                        <button type="button" class="btn btn-evt"> > New</button>
                                                    </div>
                                                    <div class="three">
                                                        <button type="button" class="btn btn-erase" onclick="eraseForms()">Erase</button>
                                                        <button type="button" class="btn btn-valid">Valid</button>
                                                        <a href="/landing">
                                                            <button type="button" class="btn btn-close1">Close</button>
                                                        </a>
                                                    </div>
                                                </div>
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
        .btn-cst {
            background-color: #15F5BA;
            color: black;
        }

        .btn-cst:hover {
            background-color: #15F5BA;
            color: black;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2%;
            padding: 0 20px;
        }

        .button-group-left {
            display: flex;
            gap: 60px;
        }

        .btn-close1 {
            background-color: #000080;
            color: white;
        }

        .btn-close1:hover {
            background-color: #000080;
            color: white;
        }

        .btn-cdt {
            background-color: #FFEB00;
            color: black;
        }

        .btn-cdt:hover {
            background-color: #FFEB00;
            color: black;
        }

        .btn-list {
            background-color: blue;
            color: white;
        }

        .btn-list:hover {
            background-color: blue;
            color: white;
        }

        .btn-inputmain {
            background-color: #4635B1;
            color: white;
        }

        .btn-inputmain:hover {
            background-color: #4635B1;
            color: white;
        }

        .btn-erase {
            background-color: #ff5722;
            color: white;
        }

        .btn-valid {
            background-color: #00CCDD;
            color: white;
        }

        .btn-evt {
            background-color: #F9C0AB;
            color: black;
        }

        .btn-evt:hover {
            background-color: #F9C0AB;
            color: black;
        }

        .btn-valid:hover {
            background-color: #00CCDD;
            color: white;
        }

        .btn-erase:hover {
            background-color: #ff5722;
            color: white;
        }

        .card-head {
            font-size: 1.8rem;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        :root {
            --primary-color: #2563eb;
            --primary-light: #e0e7ff;
            /* --border-color: #e2e8f0; */
            --border-color: #98D8EF;
            --text-color: #334155;
            --text-light: #64748b;
            --background-light: #f8fafc;
            --success-color: #22c55e;
            --input-focus: #e0e7ff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        body {
            color: var(--text-color);
            background-color: #f9fafb;
            line-height: 1.5;
        }

        .form-container {
            max-width: 1200px;
            padding: 0 1rem;
        }

        .main-layout {
            display: grid;
            grid-template-columns: 70% 30%;
            gap: 1.5rem;
        }

        .section {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.3s ease;
        }

        .section:hover {
            box-shadow: var(--shadow-md);
        }

        .section-title {
            color: var(--text-color);
            font-size: 0.925rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 0.8fr 0.6fr 1fr 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background-color: var(--background-light);
        }

        .calc-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background-color: var(--background-light);
        }


        .field-group {
            margin-bottom: 0.75rem;
        }

        .field-label {
            display: block;
            color: var(--text-light);
            font-size: 0.813rem;
            font-weight: 500;
            margin-bottom: 0.375rem;
        }


        .field-input {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-color);
            background-color: white;
            transition: all 0.2s ease;
        }

        .field-input:hover {
            border-color: var(--primary-color);
        }

        .field-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--input-focus);
        }


        .field-select {
            width: 100%;
            padding: 0.625rem 2rem 0.625rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            background-color: white;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.25rem;
            appearance: none;
            transition: all 0.2s ease;
        }

        .field-select:hover {
            border-color: var(--primary-color);
        }

        .field-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--input-focus);
        }

        .field-readonly {
            /* background-color: var(--background-light); */
            cursor: not-allowed;
            color: var(--text-light);
        }

        .field-readonly:hover {
            border-color: var(--border-color);
        }

        .currency-input {
            position: relative;
        }

        .currency-input::after {
            content: '€';
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .payment-schedule {
            display: grid;
            gap: 1rem;
        }

        .payment-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background-color: var(--background-light);
        }


        .fees-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background-color: var(--background-light);
        }

        .right-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            background-color: var(--background-light);
        }

        .status-paid {
            color: var(--success-color);
            font-weight: 600;
        }

        .required {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        .notes-field {
            min-width: 17rem;
            min-height: 5rem;
            resize: vertical;

        }

        .manual-note {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-top: 0.25rem;
        }

        .field-group:hover .field-label {
            color: var(--primary-color);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section {
            animation: fadeIn 0.3s ease-out;
        }

        @media (max-width: 1024px) {
            .main-layout {
                grid-template-columns: 1fr;
            }

            .contact-grid,
            .calc-grid,
            .payment-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .fees-grid,
            .right-grid {
                grid-template-columns: 1fr;
            }
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--background-light);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--text-light);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        :focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }


        ::placeholder {
            color: var(--text-light);
            opacity: 0.7;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* input[type="number"] {
        -moz-appearance: textfield;
    } */

        .field-input:disabled,
        .field-select:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .field-input.error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .field-input.success {
            border-color: var(--success-color);
        }

        .form-control-custom-1 {
            background-color: #f8fafc !important;
            border: 1px solid #37afe1;
            border-radius: none;
        }

        .recruitment-container {
            width: 100%;
            padding: 15px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 15px;
        }

        .recruitment-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
        }

        .recruitment-table th {
            padding: 12px 15px;
            text-align: left;
            background: #D8D9DA;
            color: #495057;
            font-weight: 500;
            font-size: 14px;
            border-bottom: 1px solid #dee2e6;
        }

        .recruitment-table td {
            padding: 12px 15px;
            font-size: 14px;
            color: #495057;
            background: white;
        }

        .with-border {
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }

        .recruitment-table tr:nth-child(even) td {
            background: #f8f9fa;
        }

        .recruitment-table tr:hover td {
            background-color: #f1f3f5;
        }

        .status-select {
            width: 100%;
            padding: 4px 8px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 14px;
            color: #495057;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 15px;
        }

        .link-btn {
            background-color: #ffc107;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            color: #000;
            font-weight: 500;
            cursor: pointer;
        }

        .unlink-btn {
            background-color: #dc3545;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            cursor: pointer;
        }

        .cdt-modal-dialog {
            max-width: 300px;
        }

        .cdt-modal-content {
            border: 1px solid #999;
            border-radius: 0;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            background: #f0f0f0;
        }

        .cdt-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 8px;
            background: linear-gradient(to bottom, #fff, #e4e4e4);
            /* border-bottom: 1px solid #999; */
        }

        .cdt-modal-header span {
            font-size: 15px;
            color: #000;
        }

        .cdt-close-btn {
            background: red;
            border: none;
            font-size: 18px;
            line-height: 1;
            padding: 0 4px;
            cursor: pointer;
            color: white;
        }

        .cdt-modal-body {
            padding: 10px;
            background: #f0f0f0;
        }

        .cdt-input-group {
            display: flex;
            gap: 4px;
            margin-bottom: 6px;
        }

        .cdt-input {
            flex-grow: 1;
            padding: 3px 6px;
            border: 1px solid #999;
            font-size: 13px;
        }

        .cdt-ok-btn {
            background: #118B50;
            border: 1px solid #999;
            padding: 2px 8px;
            cursor: pointer;
            font-size: 13px;
            color: white;
        }

        .cdt-message {
            font-size: 15px;
            color: #666;
            padding: 2px 0;
        }


        .recruitment-table tbody tr.selected {
            background-color: lightblue;
            cursor: pointer;
        }

        .recruitment-table tbody tr {
            background-color: lightblue;
            cursor: pointer;
        }

        .unlink-btn {
            margin-top: 10px;
            background-color: red;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
        }

        .modal-row {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content-row {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 40%;
            max-width: 500px;
            max-height: 70vh;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .close-row {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-row:hover,
        .close-row:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content-row form label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .modal-content-row form input[type="text"],
        .modal-content-row form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .modal-content-row form input[type="text"]:focus,
        .modal-content-row form input[type="email"]:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        #saveBtn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }

        #saveBtn:hover {
            background-color: #45a049;
        }

        #cancelBtn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        #cancelBtn:hover {
            background-color: #d32f2f;
        }

        @media (max-width: 768px) {
            .modal-content-row {
                width: 90%;
                padding: 15px;
            }

            .modal-content-row form input[type="text"],
            .modal-content-row form input[type="email"] {
                font-size: 13px;
            }

            #saveBtn,
            #cancelBtn {
                font-size: 13px;
                padding: 8px 15px;
            }
        }
    </style>
</div>
@push('page-script')
<script>
    setTimeout(function() {
        var successAlert = document.getElementById('successAlert');
        if (successAlert) {
            successAlert.style.display = 'none';
        }
    }, 5000);

    document.addEventListener("input", function(event) {
        if (event.target.tagName.toLowerCase() !== "textarea") return;
        autoResize(event.target);
    }, false);

    function autoResize(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = (textarea.scrollHeight) + "px";
    }

    function confirm() {
        alert("Form Submitted Successfully ✅")
    }

    function coming() {
        alert("CSTlist Coming Soon 🛑")
    }


    function handleFeeTypeChange() {
        const feeType = document.getElementById('feeType').value;
        const execFeeInput = document.getElementById('execFee');

        if (feeType === '%') {
            execFeeInput.type = 'text';
            execFeeInput.value = parseFloat(execFeeInput.value).toFixed(1);
        } else if (feeType === 'Fee') {
            execFeeInput.type = 'number';
            execFeeInput.value = parseInt(execFeeInput.value) || 0;
        }
    }



    document.addEventListener("DOMContentLoaded", function() {

        const rows = document.querySelectorAll(".recruitment-table tbody tr");
        const unlinkBtn = document.getElementById("unlinkBtn");
        const modal = document.getElementById("editModal");
        const closeBtn = document.querySelector(".close-row");
        const saveBtn = document.getElementById("saveBtn");
        const cancelBtn = document.getElementById("cancelBtn");

        const editDate = document.getElementById("editDate");
        const editCode = document.getElementById("editCode");
        const editCiv = document.getElementById("editCiv");
        const editfirst = document.getElementById("editfirst");
        const editlast = document.getElementById("editlast");
        const editfunc = document.getElementById("editfunc");
        const editdispo = document.getElementById("editdispo");
        const editdetail = document.getElementById("editdetail");
        // const editstatut = document.getElementById("editstatut");
        // const editnext = document.getElementById("editnext");


        let selectedRow = null;

        rows.forEach(row => {
            row.addEventListener("dblclick", () => {
                selectedRow = row;
                const cells = row.querySelectorAll("td");
                editDate.value = cells[0].innerText;
                editCode.value = cells[1].innerText;
                editCiv.value = cells[2].innerText;
                editfirst.value = cells[3].innerText;
                editlast.value = cells[4].innerText;
                editfunc.value = cells[5].innerText;
                editdispo.value = cells[6].innerText;
                editdetail.value = cells[7].innerText;
                // editstatut.value = cells[8].innerText;
                // editnext.value = cells[9].innerText;

                modal.style.display = "block";
            });
        });

        closeBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        cancelBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        saveBtn.addEventListener("click", () => {
            if (selectedRow) {
                const cells = selectedRow.querySelectorAll("td");
                cells[1].innerText = editName.value;
                cells[2].innerText = editEmail.value;
                cells[3].innerText = editRole.value;
            }

            modal.style.display = "none";
        });

        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });

        rows.forEach((row) => {
            row.addEventListener("click", () => {

                if (selectedRow) {
                    selectedRow.classList.remove("selected");
                }
                if (selectedRow === row) {
                    selectedRow = null;
                    unlinkBtn.style.display = "none";
                } else {
                    row.classList.add("selected");
                    selectedRow = row;
                    unlinkBtn.style.display = "block";
                }
            });
        });

        const linkNewCDT = document.getElementById('linkNewCDT');
        const cdtModal = new bootstrap.Modal(document.getElementById('cdtModal'));
        const okButton = document.getElementById('okButton');
        const cdtCodeInput = document.getElementById('cdtCode');

        linkNewCDT.addEventListener('click', function() {
            cdtModal.show();
        });

        okButton.addEventListener('click', function() {
            const code = cdtCodeInput.value.trim();
            if (code) {
                console.log('CDT Code submitted:', code);
                cdtModal.hide();
                cdtCodeInput.value = '';
            }
        });


        const newCST = document.getElementById('newCST');
        const cstModal = new bootstrap.Modal(document.getElementById('cstModal'));
        const okButtonCST = document.getElementById('okButtonCST');
        const cstCodeInput = document.getElementById('cstCode');

        newCST.addEventListener('click', function() {
            cstModal.show();
        });

        okButtonCST.addEventListener('click', function() {
            const code = cstCodeInput.value.trim();
            if (code) {
                console.log('CST Code submitted:', code);
                cstModal.hide();
                cstCodeInput.value = '';
            }
        });

        const tableRows = document.querySelectorAll('.recruitment-table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('dblclick', function() {
                console.log('Row double-clicked:', this);
            });
        });


        document.querySelectorAll('.auto-resize').forEach(function(textarea) {
            autoResize(textarea);
        });

        var triggerTabList = [].slice.call(document.querySelectorAll('a[data-bs-toggle="tab"]'))
        triggerTabList.forEach(function(triggerEl) {
            new bootstrap.Tab(triggerEl)
        })

        var tabEl = document.querySelector('a[data-bs-toggle="tab"]')
        tabEl.addEventListener('shown.bs.tab', function(event) {
            event.target
            event.relatedTarget
        })
    });
</script>
@endpush