<div>

    {{-- créer par MAHAMADOU ALI AdbDOUL RAZAK +226 70147315 --}}
    <!-- start page title -->
    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Manager') ? '' : '',
    'breadcrumbItems' => [['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Views', 'url' => ''] ,['text' => 'CDTvue', 'url' => '/dashboard'] , ['text' => 'CDTlist', 'url' => '/management']],
    ])

    <div class="row">
        <div class="col-md-12">
            <div class="cards">

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
                        <a href="{{ route('trgopplist') }}" class="me-2 text-black {{ request()->routeIs('trgopplist.*') ? 'text-decoration-underline fw-bold' : '' }}">TRG</a> -
                        <a href="{{ route('management') }}" class="mx-2  {{ request()->routeIs('management.*') ? 'text-decoration-underline fw-bold' : '' }}">CDT</a> -
                        <a href="{{ route('opplist') }}" class="mx-2 text-black {{ request()->routeIs('opplist.*') ? 'text-decoration-underline fw-bold' : '' }}">OPP</a> -
                        <a href="{{ route('mcplist') }}" class="mx-2 text-black {{ request()->routeIs('mcplist.*') ? 'text-decoration-underline fw-bold' : '' }}">MCP</a> -
                        <a href="{{ route('ctclist') }}" class="mx-2 text-black {{ request()->routeIs('ctclist.*') ? 'text-decoration-underline fw-bold' : '' }}">CTC</a> -
                        <a href="{{ route('management') }}" class="mx-2 text-black  {{ request()->routeIs('management.*') ? 'text-decoration-underline fw-bold' : '' }}">ANN</a> -
                        <a href="{{ route('cstlist') }}" class="ms-2 text-black {{ request()->routeIs('cstlist.*') ? 'text-decoration-underline fw-bold' : '' }}">CST</a>
                    </div>
                </div>

                <div class="button-group">
                    <div class="button-group-left">
                        <h5 style="margin-left:-22px; background-color:yellow; border-radius:5px; color:black;padding:12px;margin-top:-2px">CDTlist</h5>
                        <div class="mt-1">
                            <!-- <label for="trgcode">OPPcode</label> -->
                            <input style="width:70px; padding:5px;" type="text" placeholder="OPPcode"></input>
                        </div>
                        <div class="mt-1">
                            <!-- <label for="ctc-prenom">Libellé poste</label> -->
                            <input style="width:95px;padding:5px;" type="text" placeholder="Libellé poste"></input>

                        </div>
                        <div class="mt-1">
                            <!-- <label for="ctc-nom">Société</label> -->
                            <input style="width:60px;padding:5px;" type="text" placeholder="Société"></input>

                        </div>
                        <!-- <div class="one">
                            <a href="{{ route('candidates.create') }}">
                                <button type="button" class="btn btn-cdt">CDT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                            </a>
                        </div> -->
                        <!-- <div class="two">
                            <a href="/opplist">
                                <button type="button" class="btn btn-input">OPP <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                            </a>
                            <button id="linkNewOPP" type="button" class="btn btn-input"><i class="fas fa-link"></i></button>
                        </div> -->
                        <div class="one">
                            <a href="/cdtevtlist">
                                <button type="button" class="btn btn-evt">EVT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i> </button>
                            </a>
                            <button type="button" class="btn btn-evt" onclick="openModal()">EVT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                        </div>
                        <div class="two">
                            <a href="/mcplist">
                                <button type="button" class="btn btn-mcp">MCP <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                            </a>
                            <tyleclas id="linkNewCDT" type="button" class="btn btn-mcp"><i class="fas fa-link"></i></button>
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
                            <button type="button" class="btn btn-erase" wire:click="resetForm"><i class="fa-solid fa-eraser fa-lg"></i></button>
                            <button style="background:#4CC9FE;" type="button" class="btn btn-close1"><i class="fa-regular fa-floppy-disk fa-lg"></i></button>
                            <a href="/landing">
                                <button type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                            </a>
                        </div>
                        <div id="exporter">
                            <button id="export-button" onclick="exportSelectedCandidates()" class="btn btn-primary position-relative">
                                <i class="ri-file-download-line me-1"></i>
                                <span class="download-text">Exporter</span>
                                <span wire:loading wire:target="downloadExcel" class="position-absolute top-50 start-50 translate-middle">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="visually-hidden">Exportation...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>


                <div class="d-flex">
                    <div class="me-3">
                        <!-- <button  type="button" class="btn btn-outline-dark" id="selectionButton">
                            <i class="bi bi-check-square-fill"></i> Sélection
                        </button> -->
                    </div>

                    <!-- <div class="me-3">
                            <button type="button" class="btn btn-outline-dark" id="uncheckedButton">
                                <i class="bi bi-check-square"></i> Désélection
                            </button>
                        </div> -->
                    <!-- <div class="flex-grow-1 text-center">
                            <h4 class="card-title fw-bold fs-2">
                                Management
                            </h4>
                        </div> -->
                    <!-- verifier si la personne authentifiée n'est pas manager avant d'afficher le bouton -->
                    @if (!auth()->user()->hasRole('Manager'))
                    <div id="exporter">
                        <!-- <button id="export-button" onclick="exportSelectedCandidates()" class="btn btn-primary position-relative">
                                <i class="ri-file-download-line me-1"></i>
                                <span class="download-text">Exporter</span>
                                <span wire:loading wire:target="downloadExcel" class="position-absolute top-50 start-50 translate-middle">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="visually-hidden">Exportation...</span>
                                </span>
                            </button> -->
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-12 mt-4 mb-3">
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



            <div class="card-body">
                <div class="table-responsive">
                    <table
                        class="table table-striped table-bordered table-hover table-hover-primary align-middle table-nowrap mb-0">
                        <thead style="background-color: yellow;" class="text-black sticky-top">
                            <tr>
                                <th scope="col"><input type="checkbox" id="select-all-checkbox" class="candidate-checkbox"
                                        style="display:none;" wire:model="selectAll"></th>
                                <th scope="col" wire:click="sortBy('updated_at')">
                                    Date MAJ
                                </th>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($candidates as $index => $candidate)
                            <tr data-id="{{ $candidate->id }}"
                                class="{{ $selectedCandidateId == $candidate->id ? 'table-info' : ($index % 2 == 0 ? '' : 'cdtnonactiveontable') }}"
                                wire:dblclick.prevent="selectCandidate('{{ $candidate->id }}', '{{ $candidates->currentPage() }}')">
                                <td class="checkbox-cell">
                                    <input type="checkbox" class="candidate-checkbox"
                                        style="display:none;pointer-events: none;">
                                </td>

                             

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

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

    <!-- end row -->
    <div class="row g-0 text-center text-sm-start align-items-center mb-4">
        <!-- end col -->
        {{ $candidates->links() }}
    </div><!-- end row -->

    <div class="modal fade" id="cdtModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered cdt-modal-dialog">
            <div class="modal-content cdt-modal-content">
                <div class="cdt-modal-header">
                    <span>Enter CDT code:</span>
                    <button type="button" class="cdt-close-btn" data-bs-dismiss="modal">×</button>
                </div>
                <div class="cdt-modal-body">
                    <div class="cdt-input-group">
                        <input type="text" class="cdt-input" id="cdtCode" value="">
                        <button class="cdt-ok-btn" id="okButton">OK</button>
                    </div>
                    <div class="cdt-message"></div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .large-checkbox {
            width: 20px;
            height: 30px;
            cursor: pointer;
            margin-top: 3px;
            margin-left: 10px;
        }

        .btn-danger {
            background-color: red;
        }

        .btn-mcp {
            background-color: #7D0A0A;
            color: white;
        }

        .btn-erase {
            background-color: #ff5722;
            color: white;
        }

        .btn-erase:hover {
            background-color: #ff5722;
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
            margin-top: 1%;
            /* margin-bottom: 1%; */
            padding: 0 20px;
        }

        .button-group-left {
            display: flex;
            gap: 15px;
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
    </style>
</div>
@push('page-script')
<script>
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
</div>
