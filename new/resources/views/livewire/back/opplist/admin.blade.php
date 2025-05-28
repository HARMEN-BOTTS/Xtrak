<div>
    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Manager') ? '' : '',
    'breadcrumbItems' => [['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Views', 'url' => ''] ,['text' => 'CDTvue', 'url' => '/dashboard'] , ['text' => 'CDT_OPPlist', 'url' => '/opplist']],
    ])

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex">
                <div class="p-1 flex-grow-1">

                    <div style="margin-top: -1%;margin-left:-10px;" class="p-2 mb-4 d-flex justify-content-between">
                        <div>
                        </div>
                         <div>
                            <a href="{{ route('trgdashboard') }}" class="me-2 text-black {{ request()->routeIs('trgdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">TRG</a> -
                            <a href="{{ route('dashboard') }}" class="mx-2 text-black {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CDT</a> -
                            <a href="{{ route('oppdashboard') }}" class="mx-2 text-black {{ request()->routeIs('oppdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">OPP</a> -
                            <a href="{{ route('mcpdashboard') }}" class="mx-2 text-black {{ request()->routeIs('mcpdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">MCP</a> -
                            <a href="{{ route('ctcdashboard') }}" class="mx-2 text-black {{ request()->routeIs('ctcdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CTC</a> -
                            <a href="{{ route('dashboard') }}" class="mx-2 text-black  {{ request()->routeIs('dashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">ANN</a> -
                            <a href="{{ route('cstdashboard') }}" class="ms-2 text-black {{ request()->routeIs('cstdashboard.*') ? 'text-decoration-underline fw-bold' : '' }}">CST</a>
                        </div>
                    </div>


                    <div class="button-group-main">
                        <div class="button-group-left-main">
                            <h5 style="margin-left:-22px; background-color:yellow; border-radius:5px; color:black;padding:12px;margin-top:-2px">CDT_OPPlist</h5>
                            
                            @if($links->count() == 1)
                            @foreach($links as $link)
                            <div class="mt-1">
                                <input style="width:90px; padding:5px;" type="text" placeholder="{{ $link->candidate->code_cdt ?? '--' }}"></input>
                            </div>
                            <div class="mt-1">
                                <input style="width:120px;padding:5px;" type="text" placeholder="{{ $link->candidate->first_name ?? '--' }}{{ " " }}{{ $link->candidate->last_name ?? '--' }}"></input>
                            </div>
                            @endforeach
                            @else 
                            <div class="mt-2">
                                <h5>ALL OPEN STATUS CDTS</h5>
                            </div>
                            @endif
                            
                            <a href="/opportunity">
                                <button style="background:#6F61C0;color:white;" type="button" class="btn btn-close1"><i class="fas fa-link"></i></button>
                            </a>
                            <div class="one">
                                <a href="/oppcdtlist">
                                    <button type="button" class="btn btn-inputmain">CDT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                </a>
                            </div>
                            <div class="one">
                                <a href="/oppcstlist">
                                    <button type="button" class="btn btn-cst">CST <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                </a>
                                <button type="button" class="btn btn-cst" onclick="openModal()"><i class="fas fa-link"></i></button>
                            </div>
                            <div class="one">
                                <a href="/opplist">
                                    <button type="button" class="btn btn-evt">EVT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i> </button>
                                </a>
                                <button type="button" class="btn btn-evt" onclick="openModal()">EVT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                            </div>
                            <div class="three">
                                <button wire:click="deleteSelected()" id="delete-button-container" style="background:#F93827;" class="btn btn-danger">
                                    <i class="fa-regular fa-trash-can fa-lg"></i>
                                </button>
                                <button style="background:#4CC9FE;" type="button" class="btn btn-close1"><i class="fa-regular fa-floppy-disk fa-lg"></i></button>
                                <a href="/landing">
                                    <button type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                                </a>
                            </div>
                        </div>
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
                        <th scope="col">CodeTRG</th>
                        <th class="select-statut" scope="col">Statut</th>
                       
                        <th scope="col">Denomination</th>
                        <th scope="col" style="width:100px">Effacer</th>
                    </tr>
                </thead> -->
                <tbody>
                    <tr>
                        <td style="width:10px;">
                            <input id="selectionButton" type="checkbox" class="large-checkbox">
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
                    @if (!auth()->user()->hasRole('Manager'))
                    @endif
                </div>
            </div>
            <div style="margin-top:-2%;" class="card-body">


                @if (session()->has('message'))
                <div style="width:23%;" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif


                <div class="table-responsive">
                    <table
                        class="table table-striped table-bordered table-hover table-hover-primary align-middle table-nowrap mb-0">
                        <thead style="background:#6F61C0;" class="text-white sticky-top">
                            <tr>
                                <th style="width:2%;" scope="col"><input type="checkbox" id="select-all-checkbox" class="candidate-checkbox"
                                        style="display:none;" wire:model="selectAll"></th>

                                <th class="date_col" scope="col" wire:click="sortBy('updated_at')">
                                    OPPdate
                                </th>
                                <th class="ref_col" scope="col">OPPcode</th>
<!--                                 <th class="ref_col" scope="col">CDT First Name</th> -->
                                <th class="libe_col" scope="col">Job description</th>
                                <th class="soci_col" scope="col" wire:click="sortBy('first_name')">
                                    TRGcode
                                </th>
                                <th class="cpdpt_col" scope="col">Compan name</th>
                                <th class="statut_col" scope="col">OPPstatus</th>
                                <th class="date_col" scope="col">Link Date</th>
                                <th class="date_col" scope="col">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if($links->count() > 0)
                            @foreach($links as $link)
                            <tr
                                wire:key="row-{{ $link->id }}"
                                wire:click="toggleSelect({{ $link->id }})"
                                wire:dblclick="editRow({{ $link->id }})"
                                class="{{ in_array($link->id, $selectedRows) ? 'select-row' : '' }}"
                                style="cursor: pointer;">
                                <td class="checkbox-cell">
                                    <input type="checkbox" class="candidate-checkbox"
                                        style="display:none;pointer-events: none;">
                                </td>

                                <td>{{ $link->opportunity->opportunity_date ?? '--'}}</td>
                                <td>{{ $link->opportunity->opp_code ?? '--'}}</td>
<!--                                 <td>{{ $link->candidate->first_name ?? '--'}}</td> -->
                                <td>{{ $link->opportunity->job_titles ?? '--'}}</td>
                                <td>{{ $link->opportunity->trg_code ?? '--' }}</td>
                                <td>{{ $link->opportunity->name ?? '--'}}</td>
                                <td>{{ $link->opportunity->opportunity_status ?? '--' }}</td>
                                <td>{{ $link->created_at->format('d/m/y') }}</td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-danger"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to remove this link ⚠')) { @this.deleteCdtLink({{ $link->id }}); }">
                                        <i class="fas fa-unlink"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="20" class="text-center">No linked data available</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        {{ $links->links() }}
    </div>


    <div class="modal-overlay" style="display: none;" id="customModal" tabindex="-1">
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
    </div>



    <div class="card-footer">
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .btn-cst {
            background-color: #00FF9C;
            color: black;
            margin-left: 10px;
        }

        .select-row {
            background-color: #37AFE1 !important;
        }

        .btn-cst:hover {
            background-color: #00FF9C;
            color: black;
        }

        .button-group-main {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            margin-bottom: 10px;
            padding: 0 20px;
        }

        .button-group-left-main {
            display: flex;
            gap: 20px;
        }

        .btn-danger {
            background-color: red;
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
            margin-left: 10px;
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
    </style>

</div>
@push('page-script')
<script>
    document.getElementById("linkNewCDT").addEventListener("click", function() {
        document.getElementById("customModal").style.display = "flex";
    });

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
            deleteButtonContainer.style.display = '';
        } else {
            deleteButtonContainer.style.display = '';
        }
    }
    //function to toggle the buttons
    function toggleButtons() {
        var anyChecked = Array.from(document.querySelectorAll('.candidate-checkbox')).some(c => c.checked);
        var deleteButtonContainer = document.getElementById('delete-button-container');
        var exporter = document.getElementById('exporter');

        if (anyChecked) {
            deleteButtonContainer.style.display = '';
            // exporter.style.display = 'none';
        } else {
            deleteButtonContainer.style.display = '';
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
