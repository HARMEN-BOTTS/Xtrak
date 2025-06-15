<div>

    {{-- créer par MAHAMADOU ALI AdbDOUL RAZAK +226 70147315 --}}
    <!-- start page title -->
    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Manager') ? '' : '',
    'breadcrumbItems' => [['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Views', 'url' => ''] ,['text' => 'CDTvue', 'url' => '/dashboard']],
    ])

    <div class="row">
        <div class="col-md-15">
            <div class="d-flex">
                <div class="p-2 flex-grow-1">
                    <div style="margin-top: -1%;margin-left:-10px;" class="p-2 mb-4 d-flex justify-content-between">
                        <div>
                            <span class="font-size-14 me-5">
                                Total candidats: <strong> {{ $candidates->total() }} {{ $candidates->total() > 1 ? 'candidats' : 'candidat' }} </strong>
                            </span>
                            <span class="font-size-14 ms-10">
                                Total candidats certifiés: <strong> {{ $certifiedCandidatesCount }} </strong>
                            </span>
                            <span class="font-size-14 ms-5">
                                Total candidats en attente: <strong> {{ $uncertifiedCandidatesCount }} </strong>
                            </span>
                        </div>
                        <div>
                            <a href="{{ route('trgdashboard') }}" class="me-2 text-black {{ request()->routeIs('trgdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">TRG</a> -
                            <a href="{{ route('dashboard') }}" class="mx-2  {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CDT</a> -
                            <a href="{{ route('oppdashboard') }}" class="mx-2 text-black {{ request()->routeIs('oppdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">OPP</a> -
                            <a href="{{ route('mcpdashboard') }}" class="mx-2 text-black {{ request()->routeIs('mcpdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">MCP</a> -
                            <a href="{{ route('ctcdashboard') }}" class="mx-2 text-black {{ request()->routeIs('ctcdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CTC</a> -
                            <a href="{{ route('dashboard') }}" class="mx-2 text-black  {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">ANN</a> -
                            <a href="{{ route('cstdashboard') }}" class="ms-2 text-black {{ request()->routeIs('cstdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CST</a>
                        </div>
                    </div>

                    <div class="button-group">
                        <div class="button-group-left">
                            <h5 style="margin-left:-22px; background-color:yellow; border-radius:5px; color:black;padding:12px;margin-top:-2px">CDTvue</h5>
                            <div class="one">
                                <a href="{{ route('candidates.create') }}">
                                    <button type="button" class="btn btn-cdt">CDT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                                </a>
                            </div>

                            <!--                             <div class="two">
                                <a href="/opplist">
                                    <button type="button" class="btn btn-input">OPP <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                </a>
                                <button type="button" class="btn btn-input" wire:click="openOppModal"><i class="fas fa-link"></i></button>
                            </div> -->


                            <div class="one">
                                <button type="button" class="btn btn-input"
                                    id="opplistButton"
                                    wire:click="showLinkedDataOPP"
                                    onclick="if (this.classList.contains('disabled')) { alert('Please select a row to see the list.'); return false; }"
                                    style="display: block; color: white; background-color:#6F61C0; opacity: 1;">
                                    OPP <i style="margin-left: 5px;" class="fa-regular fa-file-lines"></i>
                                </button>
                            </div>

                            <div class="one">
                                <button type="button" class="btn btn-input" wire:click="openOppModal">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>


                            <div class="one">
                                <button type="button" class="btn btn-evt" wire:click="showEventList()">EVT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i> </button>
                                <button type="button" class="btn btn-evt" wire:click="openEventModal()">EVT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                            </div>


                            <!--                             <div class="two">
                                <a href="/cdtmcplist">
                                    <button type="button" class="btn btn-mcp">MCP <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                </a>
                                <button type="button" class="btn btn-mcp" wire:click="openMcpModal"><i class="fas fa-link"></i></button>
                            </div> -->

                            <div class="one">
                                <button type="button" class="btn btn-mcp"
                                    id="mcplistButton"
                                    wire:click="showLinkedData"
                                    onclick="if (this.classList.contains('disabled')) { alert('Please select a row to see the list.'); return false; }"
                                    style="display: block; color: white; background-color: #7D0A0A; opacity: 1;">
                                    MCP <i style="margin-left: 5px;" class="fa-regular fa-file-lines"></i>
                                </button>
                            </div>

                            <div class="one">
                                <button type="button" class="btn btn-mcp" wire:click="openMcpModal">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>


                            <div class="one">
                                <a href="">
                                    <button type="button" class="btn"><i class="fa-regular fa-envelope fa-2x"></i></button>
                                </a>
                                <button style="color:red;" type="button" class="btn" onclick="openModal()"><i class="fa-solid fa-phone fa-2x"></i></button>
                            </div>
                            <div class="three">
                                <button style="background:red;" wire:click="" class="btn btn-danger" id="delete-button-container">
                                    <i class="fa-regular fa-trash-can fa-lg"></i>
                                </button>
                            </div>
                            <div class="four">
                                <!--                                 <button type="button" class="btn btn-erase" wire:click="resetForm"><i class="fa-solid fa-eraser fa-lg"></i></button> -->
                                <button style="background:#4CC9FE;" type="button" class="btn btn-close1"><i class="fa-regular fa-floppy-disk fa-lg"></i></button>
                                <a href="/landing">
                                    <button type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                                </a>
                            </div>

                            @if (auth()->user()->hasRole('Administrateur'))
                            <div class="">
                                <!-- <button style="background:#0065F8;color:white;" type="button" class="btn btn-close1" wire:click="openImportModal">
                                    Import<i style="margin-left:5px;" class="fa-regular fa-square-plus"></i>
                                </button> -->
                                <!-- <button style="background:#FF7601;color:white;" type="button" class="btn btn-close1" wire:click="exportData">
                                    Export<i style="margin-left:5px;" class="fa-regular fa-square-plus"></i>
                                </button> -->
                                <button style="background:#FF7601;color:white;" type="button" class="btn btn-close1" wire:click="exportData" wire:loading.attr="disabled" wire:target="exportData">
                                    <span wire:loading.remove wire:target="exportData">Export<i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></span>
                                    <span wire:loading wire:target="exportData">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Exporting...</span>
                                        </div>
                                    </span>
                                </button>
                            </div>
                            @endif



                        </div>
                    </div>






                    <!-- <a href="{{ route('candidates.create') }}" class="btn "><i class="ri-add-line align-bottom me-1"></i>
                        Saisir des candidats via formulaire</a>

                    <a href="{{ route('import.candidat') }}" class="btn ms-5"><i
                            class="ri-add-line align-bottom me-1"></i>
                        Uploader une base de candidats</a> -->
                </div>

            </div>

        </div>

        <div class="col-md-12 mt-2 mb-1">
            <div class="table-responsive">
                <!-- <h5 class="mb-0">Filtrage</h5> -->
                <table class="table table-bordered border-secondary table-nowrap">
                    <tbody>
                        <tr>
                            <td>
                                <input id="selectionButton" type="checkbox" class="large-checkbox">
                            </td>

                            <td>
                                <input type="text" class="form-control" placeholder="Rechercher" wire:model.live='search'>
                            </td>
                            <!-- <td>
                                <input type="text" class="form-control" placeholder="Select" wire:model.live='search'>
                               
                            </td> -->

                            <td>
                                <select class="form-control" wire:model.live='users_id'>
                                    <option value="" class="bg-secondary text-white" selected>
                                        Auteur
                                    </option>
                                    <option value="" selected>Tous</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}"> {{ $user->trigramme }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <!-- <td>
                                    <select class="form-control w-md" wire:model.live='nbPaginate'>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30" selected>30</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </td> -->

                            <td>
                                <input type="text" class="form-control" placeholder="Prenom" wire:model.live='first_name'>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Nom" wire:model.live='last_name'>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Fonction..." wire:model.live='position'>
                            </td>

                            <td>
                                <input type="text" class="form-control" placeholder="CP/Dpt" wire:model.live='cp'>
                            </td>

                            <td>
                                <select class="form-control" wire:model.live='candidate_state_id'>
                                    <option value="" class="bg-secondary text-white" selected>
                                        Selectionner
                                    </option>
                                    <option value="" selected>Etat</option>
                                    @foreach ($candidateStates as $candidateState)
                                    <option value="{{ $candidateState->id }}"> {{ $candidateState->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control" wire:model.live='candidate_statut_id'>
                                    <option value="" selected> Statut</option>
                                    @foreach ($candidateStatuses as $candidateStatus)
                                    <option value="{{ $candidateStatus->id }}" selected>
                                        {{ $candidateStatus->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </td>
                            <!-- <td>
                                    <input type="text" class="form-control" placeholder="Société..." wire:model.live='company'>

                                </td> -->
                            <td>
                                <input type="text" class="form-control" placeholder="Dispo." wire:model.live='disponibility'>

                            </td>

                            <td>
                                <select class="form-control" wire:model.live='cvFileExists'>
                                    <option value="" selected>CV</option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" wire:model.live='creFileExists'>
                                    <option value="" selected>CRE</option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-danger ms-4" wire:click="resetFilters">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- end page title -->

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="me-3">
                            <!-- <button style="display:none;" type="button" class="btn btn-outline-dark" id="selectionButton">
                                <i class="bi bi-check-square-fill"></i> Sélection
                            </button> -->
                        </div>

                        <!-- <div class="me-3">
                            <button type="button" class="btn btn-outline-dark" id ="uncheckedButton">
                            <i class="bi bi-check-square"></i> Désélection
                            </button>
                        </div> -->
                        <!-- <div class="flex-grow-1 text-center">
                            <h4 class="card-title fw-bold fs-2">
                                CDTvue
                            </h4>
                        </div> -->
                        <!-- verifier si la personne authentifiée n'est pas manager avant d'afficher le bouton -->
                        @if (!auth()->user()->hasRole('Manager'))

                        @endif
                    </div>
                </div>
                <div style="margin-top:-3%" class="card-body">

                    @if (session()->has('message'))
                    <div style="width:28%;" class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Messages positioned to the left of the search bar -->
                    <div class="mb-2 me-3">
                        @if(session()->has('success'))
                        <div class="text-success">{{ session('success') }}</div>
                        @elseif(session()->has('error'))
                        <div class="text-danger">{{ session('error') }}</div>
                        @elseif(!empty($this->currentPageMessage))
                        <div class="text-muted">{{ $this->currentPageMessage }}</div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table
                            class="table table-striped table-bordered table-hover table-hover-primary align-middle table-nowrap mb-0">
                            <thead class="t-color text-black sticky-top">
                                <tr>
                                    <th scope="col"><input type="checkbox" id="select-all-checkbox" class="candidate-checkbox"
                                            style="display:none;" wire:model="selectAll"></th>
                                    <th scope="col" wire:click="sortBy('updated_at')">
                                        Date MAJ
                                    </th>
                                    <th style="width:auto" scope="col">CDTcode</th>
                                    <th scope="col">Aut</th>
                                    <th scope="col">Civ</th>
                                    <th scope="col" wire:click="sortBy('first_name')">
                                        Prénom
                                    </th>
                                    <th scope="col" wire:click="sortBy('last_name')">
                                        Nom
                                    </th>
                                    <th scope="col">Fonction</th>
                                    <!-- <th scope="col">Société</th> -->
                                    <th scope="col">Tél</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">CP/Dpt</th>
                                    <!-- <th scope="col">Ville</th>
                                    <th scope="col">Pays</th> -->
                                    <th scope="col">Etat</th>

                                    <th scope="col">Disponibilité</th>
                                    <!-- <th scope="col">Etat</th> -->
                                    <th scope="col">Next step</th>
                                    <!-- <th scope="col">NSdate</th> -->
                                    <th scope="col">CV</th>
                                    <th scope="col">CRE</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Commentaire</th>
                                    <th scope="col">Description</th>
                                    <!-- <th scope="col">Suivi</th> -->
                                    <!-- <th scope="col">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($candidates as $index => $candidate)
                                <tr data-id="{{ $candidate->id }}"
                                    class="{{ $selectedCandidateId == $candidate->id ? 'table-info' : ($index % 2 == 0 ? '' : 'cdtnonactiveontable') }}"
                                    wire:click.prevent="selectRow('{{ $candidate->id }}')"
                                    wire:dblclick.prevent="selectCandidate('{{ $candidate->id }}', '{{ $candidates->currentPage() }}')">
                                    <td class="checkbox-cell">
                                        <input type="checkbox" class="candidate-checkbox" value="{{ $candidate->id }}"
                                            style="display:none;pointer-events: none;" wire:model="checkboxes.{{ $candidate->id }}">
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($candidate->updated_at)->format('d/m/y') ?? '--' }}</td>
                                    <td>{{ $candidate->code_cdt ?? '--' }}</td>
                                    <td>{{ $candidate->auteur->trigramme ?? '--' }}</td>
                                    <td>{{ $candidate->civ->name ?? '--' }}</td>
                                    <td>{{ $candidate->first_name ?? '--' }}</td>
                                    <td id="Lcol">{{ $candidate->last_name ?? '--' }}</td>
                                    <td id="Lcol">{{ $candidate->position->name ?? '--' }}</td>
                                    <!-- <td>{{ $candidate->compagny->name ?? '--' }}</td> -->
                                    <td>{{ $candidate->phone ?? '--' }}</td>
                                    <td>{{ $candidate->email ?? '--' }}</td>
                                    <td>{{ $candidate->postal_code ?? '--' }}</td>
                                    <!-- <td>{{ $candidate->city ?? '--' }}</td>
                                    <td>{{ $candidate->country ?? '--' }}</td> -->
                                    @if($candidate->candidateState->name == 'Certifié')
                                    <td id="colState">
                                        <span class="badge rounded-pill bg-success" id="certificate-{{ $index }}" onclick="toggleCertificate({{$index}})">
                                            <span id="hidden-certificate-{{ $index }}">Certifié</span>
                                            <span id="visible-certificate-{{ $index }}" style="display: none;">{{ $candidate->certificate }}</span>
                                        </span>
                                        <div id="message-{{ $index }}" class="copy-message" style="display: none;"></div>
                                    </td>
                                    @else
                                    <td>
                                        {{ $candidate->candidateState->name }}
                                    </td>
                                    @endif

                                    <td>{{ $candidate->disponibility->name ?? '--' }}</td>
                                    <!-- <td>{{ $candidate->candidateState->name ?? '--' }}</td> -->
                                    <td>{{ $candidate->nextStep->name ?? '--' }}</td>
                                    <!-- <td>{{ $candidate->nsDate->name ?? '--' }}</td> -->
                                    <td>
                                        @if ($candidate->files()->exists())
                                        @php
                                        $cvFile = $candidate->files()->where('file_type', 'cv')->first();
                                        @endphp

                                        @if ($cvFile)
                                        <a class="text-body" href="#"
                                            wire:click.prevent="selectCandidateGoToCv('{{ $candidate->id }}', '{{ $candidates->currentPage() }}')">OK</a>
                                        @else
                                        n/a
                                        @endif
                                        @else
                                        n/a
                                        @endif

                                    </td>
                                    <td>
                                        @if ($candidate->cres()->exists())
                                        <a class="text-body " href="#"
                                            wire:click.prevent="selectCandidateGoToCre('{{ $candidate->id }}', '{{ $candidates->currentPage() }}')">{{ $candidate->cres()->exists() ? 'OK' : '--' }}</a>
                                        @else
                                        n/a
                                        @endif


                                    </td>
                                    <td>{{ $candidate->candidateStatut->name ?? '--' }}</td>
                                    <td>{{ $candidate->commentaire ?? '--' }}</td>
                                    <td>{{ $candidate->description ?? '--' }}</td>
                                    <!-- <td>{{ $candidate->suivi ?? '--' }}</td> -->
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="50" class="text-center">
                                        <h5 class="mt-4">Aucun résultat trouvé</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

        </div>

        <!-- <div style="margin-top:-1%;" class="d-flex justify-content-end position-relative mb-2" id="exporter">
            <button id="export-button" onclick="exportSelectedCandidates()" class="btn btn-primary position-relative">
                <i class="ri-file-download-line me-1"></i>
                <span class="download-text">Exporter</span>
                <span wire:loading wire:target="downloadExcel" class="position-absolute top-50 start-50 translate-middle">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="visually-hidden">Exportation...</span>
                </span>
            </button>
        </div> -->
        <div class="mb-2 d-flex justify-content-end position-relative">
            <!-- Pagination search at the right corner -->
            <div class="pagination-search">
                <div class="d-flex align-items-center">
                    <div class="input-group" style="width:190px;">
                        <input type="number" id="page-number-input" class="form-control" placeholder="Page" min="1" max="{{ $this->totalPages }}">
                        <span class="input-group-text bg-light">of {{ $this->totalPages }}</span>
                        <button class="btn btn-primary" id="go-to-page-btn" type="button">Go</button>
                    </div>
                </div>
            </div>
        </div>



        <div style="margin-top:-60%;" class="modal fade" id="oppLinkModal" tabindex="-1" aria-labelledby="oppLinkModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-sm">
                <div class="modal-content bg-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="oppLinkModalLabel">Link OPP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeOppModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="oppCode">Enter OPP Code</label>
                            <input type="text" class="form-control" id="oppCode" wire:model.defer="oppCode">
                        </div>
                        @if (session()->has('linkmessage'))
                        <div style="width:100%;" class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('linkmessage') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if($oppLinkError)
                        <div class="alert alert-danger mt-2">
                            {{ $oppLinkError }}
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click="closeOppModal">Close</button>
                        <button type="button" class="btn btn-success" wire:click="linkOpp">OK</button>
                    </div>
                </div>
            </div>
        </div>


        <div style="margin-top:-60%;" class="modal fade" id="mcpLinkModal" tabindex="-1" aria-labelledby="mcpLinkModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-sm">
                <div class="modal-content bg-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mcpLinkModalLabel">Link MCP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeMcpModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mcpCode">Enter MCP Code</label>
                            <input type="text" class="form-control" id="mcpCode" wire:model.defer="mcpCode">
                        </div>
                        @if (session()->has('linkmessage'))
                        <div style="width:100%;" class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('linkmessage') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if($mcpLinkError)
                        <div class="alert alert-danger mt-2">
                            {{ $mcpLinkError }}
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click="closeMcpModal">Close</button>
                        <button type="button" class="btn btn-success" wire:click="linkMcp">OK</button>
                    </div>
                </div>
            </div>
        </div>



        <div style="margin-top:-60%;" class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-sm">
                <div class="modal-content bg-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Excel File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeImportModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="importData">
                            <div class="mb-3">
                                <label for="importFile" class="form-label">Select Excel File</label>
                                <input type="file" class="form-control" id="importFile" wire:model="importFile" accept=".xlsx,.xls,.csv">
                                @error('importFile')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    <strong>Supported formats:</strong> .xlsx, .xls, .csv<br>
                                    <strong>Maximum file size:</strong> 10MB<br>
                                    <!-- <strong>Required columns:</strong> first_name, last_name<br>
                                    <strong>Optional columns:</strong> date_ctc, company_ctc, civ, function_ctc, std_ctc, ext_ctc, ld, cell, mail, ctc_code, trg_code, remarks, notes -->
                                </small>
                            </div>

                            <div wire:loading wire:target="importFile" class="text-center mb-3">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="ms-2">Processing file...</span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeImportModal">Cancel</button>
                        <button type="button" class="btn btn-success" wire:click="importData" wire:loading.attr="disabled" wire:target="importData">
                            <span wire:loading.remove wire:target="importData">Upload</span>
                            <span wire:loading wire:target="importData">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Importing...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div id="evtModal" class="modal1" style="display: {{ $showEventModal ? 'block' : 'none' }};">
            <div class="modal-content1">
                <div class="modal-header1">
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
                            <input type="date" class="form-control1" wire:model="eventFormData.event_date" value="">
                        </div>
                        <div class="form-group type-field">
                            <label>Type</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.type" value="">
                        </div>
                        <div class="form-group io-field">
                            <label>I/O</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.io" value="">
                        </div>
                        <div class="form-group objet-field">
                            <label>Objet</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.object" value="">
                        </div>
                        <div class="form-group statut-field">
                            <label>EVTStatus</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.status" value="">
                        </div>
                        <div class="form-group retour-field">
                            <label>Feed</label>
                            <input type="text" wire:model="eventFormData.feed" class="form-control1">
                        </div>
                        <div class="form-group statut-field">
                            <label>Temper</label>
                            <input type="text" wire:model="eventFormData.temper" class="form-control1">
                        </div>
                    </div>

                    <div class="comment-section">
                        <div class="form-group comment-field">
                            <label>Comment</label>
                            <!-- <textarea class="form-control2"></textarea> -->
                            <input type="text" wire:model="eventFormData.comment" class="form-control1">
                        </div>
                        <div class="right-section">
                            <div class="next-ech-row">
                                <div class="form-group next-field">
                                    <label>Next</label>
                                    <input type="text" wire:model="eventFormData.next" class="form-control1">
                                </div>
                                <div class="form-group ech-field">
                                    <label>Ech</label>
                                    <input type="text" wire:model="eventFormData.ech" class="form-control1">
                                </div>
                                <div class="form-group ech-field">
                                    <label>Priority</label>
                                    <input type="text" wire:model="eventFormData.priority" class="form-control1">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="comment-section">
                        <div class="form-group retour-field">
                            <label>Last Comment</label>
                            <input type="text" wire:model="eventFormData.last_comment" class="form-control1">
                        </div>
                        <div class="right-section">
                            <div class="next-ech-row">
                                <div class="form-group last-field">
                                    <label>Date Last Com.</label>
                                    <input type="date" wire:model="eventFormData.date_last_comment" class="form-control1">
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>Other Comment</label>
                            <textarea wire:model="eventFormData.other_comment" class="form-control1"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Note1</label>
                            <textarea wire:model="eventFormData.note1" class="form-control1"></textarea>
                        </div>
                    </div>

                    <div class="button-group">
                        <div class="button-group-left">
                            <div class="one">
                                <button type="button" class="btn btn-evt" wire:click="showEventList()">EVTlist</button>
                                <a href="/dashboard">
                                    <button type="button" class="btn btn-evt"> > New</button>
                                </a>
                            </div>
                            <div class="two">
                                <!-- <button type="button" class="btn btn-valid">Valid</button> -->
                                <button type="button" class="btn btn-inputmain" wire:click="saveEvent()">Save</button>
                            </div>
                            <div class="three">
                                <button type="button" class="btn btn-erase" wire:click="resetEventForm">Erase</button>
                                <button type="button" class="btn btn-close1" wire:click="closeEventModal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
    @push('page-script')
    <script>
        let currentlyVisibleCertificateIndex = null;

        document.addEventListener('livewire:initialized', () => {
            // Listen for modal events
            Livewire.on('open-import-modal', () => {
                const importModal = new bootstrap.Modal(document.getElementById('importModal'));
                importModal.show();
            });

            Livewire.on('closeModal', (data) => {
                const modal = bootstrap.Modal.getInstance(document.getElementById(data.modalId));
                if (modal) {
                    modal.hide();
                }
            });

            // Handle file input change
            document.getElementById('importFile').addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    const maxSize = 10 * 1024 * 1024; // 10MB

                    if (file.size > maxSize) {
                        alert('File size exceeds 10MB limit');
                        e.target.value = '';
                        return;
                    }

                    const allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel',
                        'text/csv'
                    ];

                    if (!allowedTypes.includes(file.type)) {
                        alert('Please select a valid Excel or CSV file');
                        e.target.value = '';
                        return;
                    }
                }
            });
        });


        document.addEventListener('livewire:initialized', () => {
            Livewire.on('closeModal', ({
                modalId
            }) => {
                const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                if (modal) {
                    modal.hide();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const pageInput = document.getElementById('page-number-input');
            const goToPageBtn = document.getElementById('go-to-page-btn');

            if (pageInput && goToPageBtn) {
                goToPageBtn.addEventListener('click', function() {
                    goToPage();
                });

                pageInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        goToPage();
                    }
                });
            }

            function goToPage() {
                const pageNumber = parseInt(pageInput.value);
                if (pageNumber && pageNumber > 0) {
                    @this.call('gotoPage', pageNumber);
                } else {
                    alert('Please enter a valid page number');
                }
            }

            // Listen for Livewire updates to clear flash messages after a delay
            document.addEventListener('livewire:update', function() {
                setTimeout(function() {
                    const flashMessages = document.querySelectorAll('.text-success, .text-danger');
                    flashMessages.forEach(function(message) {
                        message.style.transition = 'opacity 1s';
                        message.style.opacity = '0';
                        setTimeout(function() {
                            message.style.display = 'none';
                        }, 1000);
                    });
                }, 3000);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
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
        });

        function toggleCertificate(index) {
            var hiddenCertificate = document.getElementById('hidden-certificate-' + index);
            var visibleCertificate = document.getElementById('visible-certificate-' + index);
            var messageDiv = document.getElementById('message-' + index);

            if (currentlyVisibleCertificateIndex !== null && currentlyVisibleCertificateIndex !== index) {
                var previousHiddenCertificate = document.getElementById('hidden-certificate-' + currentlyVisibleCertificateIndex);
                var previousVisibleCertificate = document.getElementById('visible-certificate-' + currentlyVisibleCertificateIndex);
                var previousMessageDiv = document.getElementById('message-' + currentlyVisibleCertificateIndex);

                previousHiddenCertificate.style.display = "inline";
                previousVisibleCertificate.style.display = "none";
                previousMessageDiv.style.display = "none";
            }

            if (hiddenCertificate.style.display === "none") {
                hiddenCertificate.style.display = "inline";
                visibleCertificate.style.display = "none";
                messageDiv.style.display = "none";
                currentlyVisibleCertificateIndex = null;
            } else {
                hiddenCertificate.style.display = "none";
                visibleCertificate.style.display = "inline";
                currentlyVisibleCertificateIndex = index;

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
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('open-opp-modal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('oppLinkModal'));
                myModal.show();
            });
        });

        document.addEventListener('livewire:initialized', function() {
            Livewire.on('open-mcp-modal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('mcpLinkModal'));
                myModal.show();
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            var selectionButton = document.getElementById('selectionButton');
            selectionButton.addEventListener('click', toggleCheckboxes);
            // uncheckedButton.addEventListener('click', deleteAllCheckboxes) 
            let selectedCandidateIds = [];
            let candidateId;
            const doubleClickDelay = 300;
            var clickTimeout;

            // Scroll to the row with the table-info class if available
            let selectedRow = document.querySelector('.table-info');
            if (selectedRow) {
                selectedRow.scrollIntoView({
                    block: 'nearest'
                });
            }

            // MAJ selection apres export
            Livewire.on('exportCompleted', () => {
                document.querySelectorAll('.candidate-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });

                toggleButtons();
                updateSelectionButtonAndSelectAllCheckbox();
            });

            document.querySelectorAll('tr[data-id]').forEach(function(row) {
                var candidateId = row.getAttribute('data-id');

                //making checkbox clickable
                var checkbox = row.querySelector('.candidate-checkbox');
                checkbox.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent the row click event from firing
                });

                row.addEventListener('click', function() {
                    clearTimeout(clickTimeout); // Clear previous timeout

                    clickTimeout = setTimeout(function() {
                        var checkbox = row.querySelector('.candidate-checkbox');
                        if (checkbox && checkbox.style.display === 'block') {
                            // If checkboxes are visible, just toggle the checkbox and remove 'table-info' class from all rows
                            checkbox.checked = !checkbox.checked;
                            document.querySelectorAll('tr[data-id]').forEach(function(otherRow) {
                                otherRow.classList.remove('table-info');
                            });
                        } else {
                            // If the clicked row already has the 'table-info' class, remove it, otherwise add it
                            if (row.classList.contains('table-info')) {
                                row.classList.remove('table-info');
                                if (checkbox) { // Check if the checkbox exists
                                    checkbox.checked = false;
                                }
                            } else {
                                // Remove 'table-info' class and uncheck all other rows
                                document.querySelectorAll('tr[data-id]').forEach(function(otherRow) {
                                    otherRow.classList.remove('table-info');
                                    var otherCheckbox = otherRow.querySelector('.candidate-checkbox');
                                    if (otherCheckbox) { // Check if the checkbox exists
                                        otherCheckbox.checked = false;
                                    }
                                });

                                // Add 'table-info' class and check the clicked row
                                row.classList.add('table-info');
                                if (checkbox) { // Check if the checkbox exists
                                    checkbox.checked = true;
                                }
                            }
                        }

                        // Check if any checkbox is checked and toggle the buttons
                        toggleButtons();
                        deleteSelectedCandidates();
                        updateSelectAllCheckbox();

                        // Update selection button and select-all checkbox
                        updateSelectionButtonAndSelectAllCheckbox();

                    }, doubleClickDelay);
                });
                var checkbox = row.querySelector('.candidate-checkbox');
                checkbox.addEventListener('change', function(e) {
                    // Check if any checkbox is checked and toggle the buttons
                    toggleButtons();
                    deleteSelectedCandidates();
                });
            });

            // check & uncheck all checkboxes
            document.getElementById('select-all-checkbox').addEventListener('change', function(e) {
                var isChecked = e.target.checked;
                document.querySelectorAll('.candidate-checkbox').forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                    checkbox.style.display = isChecked ? 'block' : 'none';
                });
                toggleButtons();
                deleteSelectedCandidates();
            });
            // Select all checkboxes functionality
            document.getElementById('select-all-checkbox').addEventListener('change', function() {
                var isChecked = this.checked;
                document.querySelectorAll('.candidate-checkbox').forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                    checkbox.style.display = 'block'; // Keep checkboxes visible
                });
                toggleButtons();
                updateSelectionButtonAndSelectAllCheckbox();
            });

        });

        /*************************************************************************************/
        // Toggle selection checkboxes
        function toggleCheckboxes() {
            let areCheckboxesVisible = Array.from(document.querySelectorAll('.candidate-checkbox')).some(c => c.style.display === 'block');
            document.querySelectorAll('.candidate-checkbox').forEach(function(checkbox) {
                checkbox.style.display = areCheckboxesVisible ? 'none' : 'block';
                if (areCheckboxesVisible) checkbox.checked = false; // Uncheck all checkboxes if toggling to hide
            });

            // Update selection button text
            const selectionButton = document.getElementById('selectionButton');
            if (areCheckboxesVisible) {
                selectionButton.innerHTML = '<i class="bi bi-check-square-fill"></i> Sélection';
                document.getElementById('select-all-checkbox').style.display = 'none';
                document.getElementById('select-all-checkbox').checked = false;
            } else {
                selectionButton.innerHTML = '<i class="bi bi-check-square"></i> Désélection';
                document.getElementById('select-all-checkbox').style.display = 'block';
            }

            // Update delete button visibility
            updateDeleteButtonVisibility();
        }
        // Update delete button visibility
        function updateDeleteButtonVisibility() {
            var deleteButtonContainer = document.getElementById('delete-button-container');
            let isAnyCheckboxChecked = Array.from(document.querySelectorAll('.candidate-checkbox')).some(c => c.checked && c.style.display === 'block');
            if (isAnyCheckboxChecked) {
                deleteButtonContainer.style.display = 'block';
            } else {
                deleteButtonContainer.style.display = 'none';
            }
        }
        //function to toggle the buttons
        function toggleButtons() {
            var anyChecked = Array.from(document.querySelectorAll('.candidate-checkbox')).some(c => c.checked);
            var deleteButtonContainer = document.getElementById('delete-button-container');
            var exporter = document.getElementById('exporter');

            if (anyChecked) {
                deleteButtonContainer.style.display = 'block';
                // exporter.style.display = 'none';
            } else {
                deleteButtonContainer.style.display = 'none';
                // exporter.style.display = 'block';
            }
        }

        function deleteSelectedCandidates() {
            let selectedCandidateIds = Array.from(document.querySelectorAll('.candidate-checkbox:checked'))
                .map(checkbox => checkbox.closest('tr').getAttribute('data-id'))
                .filter(id => id !== null && id !== '');
            console.log(selectedCandidateIds);

            let deleteButtonContainer = document.getElementById('delete-button-container');
            if (deleteButtonContainer) {
                deleteButtonContainer.setAttribute('wire:click', `confirmDeleteChecked('${selectedCandidateIds.join(',')}')`);
                deleteButtonContainer.style.cursor = 'pointer';
            }
        }

        function updateSelectionButtonAndSelectAllCheckbox() {
            let isAnyCheckboxVisible = false;
            document.querySelectorAll('.candidate-checkbox').forEach(function(checkbox) {
                // Check if at least one checkbox is visible
                if (checkbox.style.display === 'block') {
                    isAnyCheckboxVisible = true;
                }
            });

            // Update selection button text
            const selectionButton = document.getElementById('selectionButton');
            if (isAnyCheckboxVisible) {
                selectionButton.innerHTML = '<i class="bi bi-check-square"></i> Désélection';
                // Show the select-all checkbox
                document.getElementById('select-all-checkbox').style.display = 'block';
            } else {
                selectionButton.innerHTML = '<i class="bi bi-check-square-fill"></i> Sélection';
                // Hide the select-all checkbox
                document.getElementById('select-all-checkbox').style.display = 'none';

            }
        }


        // **************unchecked all checkbox***************
        function deleteAllCheckboxes() {
            document.querySelectorAll('.candidate-checkbox').forEach(function(checkbox) {
                checkbox.checked = false;
            });
            // update delete button visibility
            toggleButtons();
        }
        // *********************************************************************
        function updateSelectAllCheckbox() {
            var allChecked = Array.from(document.querySelectorAll('.candidate-checkbox')).every(c => c.checked);
            var anyVisible = Array.from(document.querySelectorAll('.candidate-checkbox')).some(c => c.style.display === 'block');
            document.getElementById('select-all-checkbox').checked = allChecked;

            // Update select-all checkbox visibility
            document.getElementById('select-all-checkbox').style.display = anyVisible ? 'block' : 'none';
        }

        //filtrage
        document.addEventListener('DOMContentLoaded', function() {
            const filterInputs = document.querySelectorAll('input[wire:model.live], select[wire:model.live]');

            filterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    sessionStorage.setItem(input.getAttribute('wire:model.live'), input.value);
                });
            });

            // Charger les valeurs des filtres depuis le stockage de session
            filterInputs.forEach(input => {
                const storedValue = sessionStorage.getItem(input.getAttribute('wire:model.live'));
                if (storedValue !== null) {
                    input.value = storedValue;
                    input.dispatchEvent(new Event('change'));
                }
            });
        });
        /***********************************************************************************************/
        function exportSelectedCandidates() {
            let selectedCandidateIds = Array.from(document.querySelectorAll('.candidate-checkbox:checked'))
                .map(checkbox => checkbox.closest('tr').getAttribute('data-id'))
                .filter(id => id !== null && id !== '');

            // Appeler la méthode Livewire avec les IDs sélectionnés
            @this.call('downloadExcel', selectedCandidateIds);
        }
    </script>
    @endpush
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .large-checkbox {
            width: 20px;
            height: 30px;
            cursor: pointer;
            margin-top: 3px;
            margin-left: 10px;
        }

        .btn-erase {
            background-color: #ff5722;
            color: white;
        }

        .btn-erase:hover {
            background-color: #ff5722;
            color: white;
        }

        .btn-mcp {
            background-color: #7D0A0A;
            color: white;
        }

        .t-color {
            background-color: yellow;
        }

        .btn-mcp:hover {
            background-color: #7D0A0A;
            color: white;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: -1%;
            margin-left: -8px;
            padding: 0 20px;
        }

        .button-group-left {
            display: flex;
            gap: 4px;
        }

        .btn-evt {
            background-color: #F9C0AB;
            color: black;
            margin-left: 10px;
        }

        .btn-evt:hover {
            background-color: #F9C0AB;
            color: black;
        }

        .btn-cdt {
            background-color: yellow;
            color: black;
            margin-left: 10px;
        }

        .btn-cdt:hover {
            background-color: yellow;
            color: black;
        }

        .btn-save {
            background-color: #4CC9FE;
            color: black;
            margin-left: 10px;
        }

        .btn-save:hover {
            background-color: #4CC9FE;
            color: black;
        }



        .btn-input {
            background-color: #6F61C0;
            color: white;
            margin-left: 10px;
        }

        .btn-input:hover {
            background-color: #6F61C0;
            color: white;
        }
        

         .btn-inputmain {
            background-color: #06D001;
            color: white;
            margin-left: 10px;
        }

        .btn-inputmain:hover {
            background-color: #06D001;
            color: white;
        }

        .btn-close1 {
            background-color: #000080;
            color: white;
            margin-left: 10px;
        }

        .btn-close1:hover {
            background-color: #000080;
            color: white;
        }


        .cdt-modal-dialog {
            max-width: 300px;
        }

        .cdt-modal-content {
            padding: 0;
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

        .modal-overlay1 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1050;
        }

        .modal-content1 {
            background: none;
            border-radius: 8px;
            width: 300px;
            text-align: left;
        }

        .modal-content1 {
            background: none;
            border-radius: 8px;
            width: 300px;
            text-align: left;
        }

        .modal1 {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
        }

        .modal-content1 {
            position: relative;
            background-color: #fff;
            margin: 5% auto;
            padding: 20px 25px;
            width: 80%;
            max-width: 900px;
            border-radius: 2px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .modal-header1 {
            margin-bottom: 5px;
            margin-left: -12px;
        }

        .modal-header1 h2 {
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
            gap: 20px;
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
</div>