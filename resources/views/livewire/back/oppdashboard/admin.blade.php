<div>
    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Manager') ? '' : '',
    'breadcrumbItems' => [['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Views', 'url' => ''] ,['text' => 'OPPvue', 'url' => '/oppdashboard']],
    ])

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex">
                <div class="p-1 flex-grow-1">

                    <div style="margin-top: -1%;margin-left:-10px;" class="p-2 mb-3 d-flex justify-content-between">
                        <div>
                            <span class="font-size-20 me-5">
                                Période : <strong> Last 7 days </strong>
                            </span>
                            <span class="font-size-20 me-3">
                                Total OPP en cours : <strong> {{ $data->total() }}</strong>
                            </span>
                            <span class="font-size-20  me-3">
                                N cdt Présentés : <strong> {{ $presentedCount }} </strong>
                            </span>
                            <span class="font-size-20  me-3">
                                N cdt en cours : <strong> {{ $inprogressCount }} </strong>
                            </span>
                            <span class="font-size-20  me-3">
                                N cdt embauchés : <strong> {{ $hiredCount }} </strong>
                            </span>
                        </div>
                        <div>
                            <a href="{{ route('trgdashboard') }}" class="me-2 text-black {{ request()->routeIs('trgdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">TRG</a> -
                            <a href="{{ route('dashboard') }}" class="mx-2 text-black {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CDT</a> -
                            <a href="{{ route('oppdashboard') }}" class="mx-2 {{ request()->routeIs('oppdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">OPP</a> -
                            <a href="{{ route('mcpdashboard') }}" class="mx-2 text-black {{ request()->routeIs('mcpdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">MCP</a> -
                            <a href="{{ route('ctcdashboard') }}" class="mx-2 text-black {{ request()->routeIs('ctcdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CTC</a> -
                            <a href="{{ route('dashboard') }}" class="mx-2 text-black  {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">ANN</a> -
                            <a href="{{ route('cstdashboard') }}" class="ms-2 text-black {{ request()->routeIs('cstdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CST</a>
                        </div>
                    </div>









                    <div class="button-group-main">
                        <div class="button-group-left-main">
                            <h5 style="margin-left:-22px; background-color:#6F61C0; border-radius:5px; color:white;padding:12px;margin-top:-2px">OPPvue</h5>
                            <a href="/opportunity">
                                <button style="background:#6F61C0;color:white;" type="button" class="btn btn-close1">OPP<i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                            </a>


                            <div class="one">
                                <button type="button" class="btn btn-inputmain"
                                    id="cdtlistButton"
                                    wire:click="showLinkedDataCDT"
                                    onclick="if (this.classList.contains('disabled')) { alert('Please select a row to see the list.'); return false; }"
                                    style="display: block; color: black; background-color:yellow; opacity: 1;">
                                    CDT<i style="margin-left: 5px;" class="fa-regular fa-file-lines"></i>
                                </button>
                            </div>

                            <div class="one">
                                <button type="button" class="btn btn-inputmain" wire:click="openCdtModal">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>



                            <div class="one">
                                <button type="button" class="btn btn-evt" wire:click="showEventList()">EVT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i> </button>
                                <button type="button" class="btn btn-evt" wire:click="openEventModal()">EVT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                            </div>



                            <div class="one">
                                <button type="button" class="btn btn-cst"
                                    id="cstlistButton"
                                    wire:click="showLinkedDataCST"
                                    onclick="if (this.classList.contains('disabled')) { alert('Please select a row to see the list.'); return false; }"
                                    style="display: block; color: black; background-color: #15F5BA; opacity: 1;">
                                    CST<i style="margin-left: 5px;" class="fa-regular fa-file-lines"></i>
                                </button>
                            </div>

                            <div class="one">
                                <button type="button" class="btn btn-cst" wire:click="openCstModal">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>


                            <div class="one">
                                <button type="button" class="btn btn-mcp"
                                    id="mcplistButton"
                                    wire:click="showLinkedData"
                                    onclick="if (this.classList.contains('disabled')) { alert('Please select a row to see the list.'); return false; }"
                                    style="display: block; color: white; background-color: #7D0A0A; opacity: 1;">
                                    MCP<i style="margin-left: 5px;" class="fa-regular fa-file-lines"></i>
                                </button>
                            </div>

                            <div class="one">
                                <button type="button" class="btn btn-mcp" wire:click="openMcpModal">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>





                            <div class="two">
                                <button type="button" class="btn btn-danger" wire:click="deleteSelected()"
                                    {{ empty($selectedRows) ? '' : '' }}>
                                    <i class="fa-regular fa-trash-can fa-lg"></i>
                                    <!-- <span class="badge bg-light text-dark ms-1">{{ count($selectedRows) }}</span> -->
                                </button>
                                <button style="background:#4CC9FE;" type="button" class="btn btn-close1"><i class="fa-regular fa-floppy-disk fa-lg"></i></button>
                                <a href="/landing">
                                    <button type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                                </a>
                            </div>


                            @if (auth()->user()->hasRole('Administrateur'))
                            <div class="">
                                <button style="background:#0065F8;color:white;" type="button" class="btn btn-close1" wire:click="openImportModal">
                                    Import<i style="margin-left:5px;" class="fa-regular fa-square-plus"></i>
                                </button>
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






                </div>
            </div>
        </div>

        <div class="col-md-12 mt-1 mb-3">
            <div class="table-responsive">
                <!-- <h5 class="mb-2">Filtrage</h5> -->
                <table class="table table-bordered border-secondary table-nowrap">
                    <!-- <thead>
                        <tr class="text-center">
                            <th class="select-filter" cope="col">Select</th>
                            <th scope="col">Recherche</th>
                            <th scope="col">CodeOPP</th>
                            <th scope="col">Libellé poste</th>
                            <th scope="col">Société</th>
                            <th class="select-statut" scope="col">Statut</th>
                            <th class="select-cpdpt" scope="col">CP/Dpt</th>
                            <th scope="col">Remarque(s)</th>
                            <th scope="col" style="width:100px">Effacer</th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <tr>
                            <td style="width:10px;">
                                <input id="selectionButton" type="checkbox" class="large-checkbox" wire:click="toggleSelectionMode">
                            </td>

                            <td>
                                <input type="text" class="form-control" placeholder="Rechercher" wire:model.live='search'>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="CodeOPP" wire:model.live='codeopp'>

                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder=" Libellé poste" wire:model.live='libelle'>

                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Société..." wire:model.live='company'>

                            </td>
                            <td>
                                <select class="form-control w-md" wire:model.live='statut'>
                                    <option value="" selected>Selectionner</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Filled">Filled</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="CP/Dpt" wire:model.live='position'>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Remarque(s)" wire:model.live='remarks'>
                            </td>
                            <td style="width:10px;">
                                <button class="btn btn-danger ms-2" wire:click="resetFilters">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- end page title -->

        <div style="margin-top:-2%;" class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <!-- <div class="me-3">
                            <button type="button" class="btn btn-outline-dark" id="selectionButton">
                                <i class="bi bi-check-square-fill"></i> Sélection
                            </button>
                        </div> -->
                        <!-- <div>
                            <button wire:click="" class="btn btn-danger" id="delete-button-container" style="display: none;">
                                <i class="bi bi-trash-fill"></i>Supprimer
                            </button>
                        </div> -->
                        <!-- <div class="me-3">
                            <button type="button" class="btn btn-outline-dark" id ="uncheckedButton">
                            <i class="bi bi-check-square"></i> Désélection
                            </button>
                        </div> -->
                        <!-- <div class="flex-grow-1 text-center">
                            <h4 class="card-title fw-bold fs-2">
                                OPPvue
                            </h4>
                        </div> -->
                        <!-- verifier si la personne authentifiée n'est pas manager avant d'afficher le bouton -->
                        @if (!auth()->user()->hasRole('Manager'))
                        <!-- <div id="exporter">
                            <button id="export-button" onclick="exportSelectedCandidates()" class="btn btn-primary position-relative">
                                <i class="ri-file-download-line me-1"></i>
                                <span class="download-text">Exporter</span>
                                <span wire:loading wire:target="downloadExcel" class="position-absolute top-50 start-50 translate-middle">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="visually-hidden">Exportation...</span>
                                </span>
                            </button>
                        </div> -->
                        @endif
                    </div>
                </div>
                <div style="margin-top:-2%;" class="card-body">



                    @if (session()->has('message'))
                    <div style="width:28%;" class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif


                    <!-- Message area to the left of the pagination search -->
                    @if ($pageMessage)
                    <div style="margin-top:-1%;margin-bottom:1%;" class="d-flex align-items-center">
                        <small style="font-size:15px;" class="{{ $pageMessageType == 'error' ? 'text-danger' : 'text-success' }}">
                            {{ $pageMessage }}
                        </small>
                    </div>
                    @endif



                    <div class="table-responsive">
                        <table
                            class="table table-striped table-bordered table-hover table-hover-primary align-middle table-nowrap mb-0">
                            <thead style="background:#6F61C0;" class="text-white sticky-top">
                                <tr>
                                    <th scope="col">
                                        @if($showCheckboxes)
                                        <input type="checkbox" id="select-all-checkbox"
                                            wire:model="selectAll"
                                            wire:click="$refresh">
                                        @endif
                                    </th>
                                    <th class="date_col" scope="col" wire:click="sortBy('updated_at')">
                                        Date
                                    </th>
                                    <th style="width:auto" class="ref_col" scope="col">OPPcode</th>
                                    <th class="libe_col" scope="col">LibelléPoste</th>
                                    <th class="soci_col" scope="col" wire:click="sortBy('first_name')">
                                        Société
                                    </th>
                                    <th class="cpdpt_col" scope="col">CP/Dpt</th>
                                    <th class="ville_col" scope="col">Ville</th>
                                    <th class="statut_col" scope="col">Statut</th>
                                    <th class="remark_col" scope="col">Remarque(s)</th>
                                    <th class="cdt_col" scope="col">CDTs</th>
                                    <th class="reg_col" scope="col">Règlt.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data) && (is_array($data) || is_object($data)) && count($data) > 0)
                                @foreach($data as $item)
                                <tr wire:key="row-{{ $item->id }}"
                                    wire:click="toggleSelect({{ $item->id }})"
                                    wire:dblclick="editRow({{ $item->id }})"
                                    class="{{ in_array($item->id, $selectedRows) ? 'select-row' : '' }}"
                                    style="cursor: pointer;">
                                    <td class="checkbox-cell" onclick="event.stopPropagation()">
                                        @if($showCheckboxes)
                                        <input type="checkbox"
                                            value="{{ $item->id }}"
                                            wire:click="toggleSelect({{ $item->id }})"
                                            {{ in_array((string)$item->id, $selectedRows) ? 'checked' : '' }}>
                                        @endif
                                    </td>
                                    <td>{{ $item->opportunity_date }}</td>
                                    <td>{{ $item->opp_code }}</td>
                                    <td>{{ $item->job_titles }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->postal_code_1 }}</td>
                                    <td>{{ $item->site_city }}</td>
                                    <td>{{ $item->opportunity_status }}</td>
                                    <td>{{ $item->remarks }}</td>
                                    <td>{{ $item->trg_code }}</td>
                                    <td>{{ $item->total_paid }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="16" class="text-center">No data available</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3 d-flex justify-content-end position-relative">
                            <div class="pagination-search">
                                <div class="d-flex align-items-center">
                                    <div class="input-group" style="width:180px;">
                                        <input type="number" class="form-control" wire:model="pageNumberInput" min="1" placeholder="Page">
                                        <span class="input-group-text">of {{ $totalPages }}</span>
                                        <button class="btn btn-primary" type="button" wire:click="goToPage">Go</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!--         <div class="modal-overlay" style="display: none;" id="customModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered cdt-modal-dialog">
                <div class="modal-content cdt-modal-content">
                    <div class="cdt-modal-header">
                        <span>Enter CDT code:</span>
                        <button id="closeModal" type="button" class="cdt-close-btn" data-bs-dismiss="modal">×</button>
                    </div>
                    <div class="cdt-modal-body">
                        <div class="cdt-input-group">
                            <input type="text" class="cdt-input" id="cdtCode" value="">
                            <button type="button" class="cdt-ok-btn" id="okButton">OK</button>
                        </div>
                        <div class="cdt-message"></div>
                    </div>
                </div>
            </div>
        </div> -->

        <div style="margin-top:-60%;" class="modal fade" id="cdtLinkModal" tabindex="-1" aria-labelledby="cdtLinkModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-sm">
                <div class="modal-content bg-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cdtLinkModalLabel">Link CDT</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeCdtModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cdtCode">Enter CDT Code</label>
                            <input type="text" class="form-control" id="cdtCode" wire:model.defer="cdtCode">
                        </div>
                        @if (session()->has('linkmessage'))
                        <div style="width:100%;" class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('linkmessage') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if($cdtLinkError)
                        <div class="alert alert-danger mt-2">
                            {{ $cdtLinkError }}
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click="closeCdtModal">Close</button>
                        <button type="button" class="btn btn-success" wire:click="linkCdt">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top:-60%;" class="modal fade" id="cstLinkModal" tabindex="-1" aria-labelledby="cstLinkModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-sm">
                <div class="modal-content bg-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cstLinkModalLabel">Link CST</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeCstModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cstCode">Enter CST Code</label>
                            <input type="text" class="form-control" id="cstCode" wire:model.defer="cstCode">
                        </div>
                        @if (session()->has('linkmessage'))
                        <div style="width:100%;" class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('linkmessage') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if($cstLinkError)
                        <div class="alert alert-danger mt-2">
                            {{ $cstLinkError }}
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click="closeCstModal">Close</button>
                        <button type="button" class="btn btn-success" wire:click="linkCst">OK</button>
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


        <div id="evtModal" class="modal1" style="display: {{ $showEventModal ? 'block' : 'none' }};">
            <div class="modal-content1">
                <div class="modal-header1">
                    <h2 style="border-radius:5px;background:#6F61C0;width:18%;padding:7px;text-align:center;color:white">OPP_EVTform</h2>
                    <div class="form-group objet-field">
                        <input type="text" class="form-control1" wire:model="eventFormData.opp_code">
                    </div>
                    <div class="form-group objet-field">
                        <input type="text" class="form-control1" wire:model="eventFormData.job_titles">
                    </div>
                    <div class="form-group objet-field">
                        <input type="text" class="form-control1" wire:model="eventFormData.name">
                    </div>
                    <a href="/oppdashboard">
                        <h2 style="border-radius:5px;background:#6F61C0;width:100%;padding:7px;text-align:center;color:white">OPP_Vue</h2>
                    </a>
                </div>


                <div id="evtForm">

                    <div class="form-row">
                        <div class="form-group date-field">
                            <label>Date</label>
                            <input type="date" class="form-control1" wire:model="eventFormData.event_date">
                        </div>
                        <div class="form-group type-field">
                            <label>Type</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.type">
                        </div>
                        <div class="form-group io-field">
                            <label>I/O</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.io">
                        </div>
                        <div class="form-group objet-field">
                            <label>Objet</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.object">
                        </div>
                        <div class="form-group retour-field">
                            <label>Feedback</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.feedback">
                        </div>
                        <div class="form-group retour-field">
                            <label>Statut</label>
                            <input type="text" class="form-control1" wire:model="eventFormData.status">
                        </div>
                    </div>



                    <div class="comment-section">
                        <div class="form-group comment-field">
                            <label>Comment</label>
                            <textarea style="height:175px;" type="text" class="form-control1" wire:model="eventFormData.comment"></textarea>
                        </div>
                        <div class="right-section">
                            <div class="next-ech-row">
                                <div class="form-group next-field">
                                    <label>Next</label>
                                    <input type="text" class="form-control1" wire:model="eventFormData.next1">
                                </div>
                                <div class="form-group ech-field">
                                    <label>Term</label>
                                    <input type="text" class="form-control1" wire:model="eventFormData.term">
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Note1</label>
                                <textarea class="form-control1" wire:model="eventFormData.note1"></textarea>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:15px;" class="button-group">
                        <div class="button-group-left">
                            <div class="one">
                                <button type="button" class="btn btn-evt" wire:click="showEventList()">EVTlist</button>
                                <a href="/oppdashboard">
                                    <button type="button" class="btn btn-evt"> > New</button>
                                </a>
                            </div>
                            <div class="two">
                                <button type="button" class="btn btn-input" wire:click="saveEvent()">Save</button>
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

            .select-row {
                background-color: #37AFE1 !important;
            }

            .button-group-main {
                display: flex;
                justify-content: space-between;
                margin-top: 5px;
                margin-bottom: 2px;
                padding: 0 20px;
            }

            .button-group-left-main {
                display: flex;
                gap: 3px;
            }

            .btn-danger {
                background-color: red;
            }

            .btn-cst {
                background-color: #15F5BA;
                color: black;
            }

            .btn-cst:hover {
                background-color: #15F5BA;
                color: black;
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

            .btn-inputmain {
                background-color: yellow;
                color: black;
                margin-left: 10px;
            }

            .btn-inputmain:hover {
                background-color: yellow;
                color: black;
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


            .large-checkbox {
                width: 20px;
                height: 30px;
                cursor: pointer;
                margin-top: 3px;
                margin-left: 5px;
            }

            .select-filter {
                width: 10px;
            }

            .select-statut {
                width: 125px;
            }

            .select-cpdpt {
                width: 100px;
            }

            .card-footer {
                margin-top: -5px;
                margin-bottom: 10px;
            }

            .date_col {
                width: 70px;
            }

            .ref_col {
                width: 70px;
            }

            .cdt_col {
                width: 70px;
            }

            .reg_col {
                width: 70px;
            }

            .soci_col {
                width: 150px;
            }

            .modal-overlay {
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

            .modal-content {
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
                width: 100%;
                max-width: 900px;
                border-radius: 2px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }


            .modal-header1 {
                display: flex;
                gap: 10px;
                margin-bottom: 8px;
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
                margin-top: 10px;
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

            .last-field {
                width: 300px;
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


            .button-group-left {
                display: flex;
                gap: 25px;
            }

            .button-group-right {
                display: flex;
            }

            .btn-input {
                background-color: #06D001;
                color: white;
            }

            .btn-input:hover {
                background-color: #06D001;
                color: white;
            }

            .btn-erase {
                background-color: #ff5722;
                color: white;
            }

            .btn-valid {
                background-color: #69247C;
                color: white;
            }

            .btn-valid:hover {
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
    @push('page-script')
    <script>
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



        document.addEventListener('livewire:load', function() {
            Livewire.on('hide-mcplist-button', function() {
                document.getElementById('mcplistButton').style.display = 'none';
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('hide-cstlist-button', function() {
                document.getElementById('cstlistButton').style.display = 'none';
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('hide-cdtlist-button', function() {
                document.getElementById('cdtlistButton').style.display = 'none';
            });
        });



        document.addEventListener('livewire:initialized', function() {
            Livewire.on('open-cdt-modal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('cdtLinkModal'));
                myModal.show();
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

        document.addEventListener('livewire:initialized', function() {
            Livewire.on('open-cst-modal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('cstLinkModal'));
                myModal.show();
            });
        });

        document.addEventListener('livewire:initialized', function() {
            Livewire.on('open-mcp-modal', () => {
                var myModal = new bootstrap.Modal(document.getElementById('mcpLinkModal'));
                myModal.show();
            });
        });


        // document.getElementById("linkNewCDT").addEventListener("click", function() {
        //     document.getElementById("customModal").style.display = "flex";
        // });

        document.getElementById("closeModal").addEventListener("click", function() {
            document.getElementById("customModal").style.display = "none";
        });

        document.getElementById("okButton").addEventListener("click", function() {
            document.getElementById("customModal").style.display = "none";
        });


        let currentlyVisibleCertificateIndex = null;

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
    </script>
    @endpush
</div>