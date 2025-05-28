<div>
    @include('components.breadcrumb', [
    'title' => auth()->user()->hasRole('Manager') ? 'Espace manager' : 'Espace administrateur',
    'breadcrumbItems' => [['text' => 'OPPvue', 'url' => '#']],
    ])

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex">
                <div class="p-1 flex-grow-1">
                    <h4><strong>OPPvue</strong></h4>
                    <span class="font-size-20 me-5">
                        Période : <strong> {{ $opportunities->total() }} {{ $opportunities->total() > 1 ? 'mois' : 'moi' }} </strong>
                    </span>
                    <span class="font-size-20 me-5">
                        Total OPP en cours : <strong> {{ $opportunities->total() }} </strong>
                    </span>
                    <span class="font-size-20 ms-5">
                        N cdt Présentés : <strong> {{ $certifiedCandidatesCount }} </strong>
                    </span>
                    <span class="font-size-20 ms-5">
                        N cdt en cours : <strong> {{ $uncertifiedCandidatesCount }} </strong>
                    </span>
                    <span class="font-size-20 ms-5">
                        N cdt embauchés : <strong> {{ $uncertifiedCandidatesCount }} </strong>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-4 mb-3">
            <div class="table-responsive">
                <h5 class="mb-2">Filtrage</h5>
                <table class="table table-bordered border-secondary table-nowrap">
                    <thead>
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
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input id="selectionButton" type="checkbox" wire:model.live='select' class="large-checkbox" id="searchCheckbox">
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
                                <select class="form-control w-md" wire:model.live='cvFileExists'>
                                    <option value="" selected>Selectionner</option>
                                    <option value="1">Opened</option>
                                    <option value="0">Closed</option>
                                    <option value="1">Filled</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Veuillez entrer la valeur" wire:model.live='position'>
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Remarque(s)" wire:model.live='remarks'>
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
                        <!-- <div class="me-3">
                            <button type="button" class="btn btn-outline-dark" id="selectionButton">
                                <i class="bi bi-check-square-fill"></i> Sélection
                            </button>
                        </div> -->
                        <div>
                            <button wire:click="" class="btn btn-danger" id="delete-button-container" style="display: none;">
                                <i class="bi bi-trash-fill"></i>Supprimer
                            </button>
                        </div>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            class="table table-striped table-bordered table-hover table-hover-primary align-middle table-nowrap mb-0">
                            <thead class="bg-secondary text-white sticky-top">
                                <tr>
                                    <th scope="col"><input type="checkbox" id="select-all-checkbox" class="candidate-checkbox"
                                            style="display:none;" wire:model="selectAll"></th>
                                    <th class="date_col" scope="col" wire:click="sortBy('updated_at')">
                                        Date
                                    </th>
                                    <th class="ref_col" scope="col">Référence</th>
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
                                @forelse ($opportunities as $index => $opportunity)
                                <tr data-id="{{ $opportunity->id }}"
                                    class="{{ $selectedCandidateId == $opportunity->id ? 'table-info' : ($index % 2 == 0 ? '' : 'cdtnonactiveontable') }}"
                                    wire:dblclick.prevent="selectCandidate('{{ $opportunity->id }}', '{{ $opportunities->currentPage() }}')">
                                    <td class="checkbox-cell">
                                        <input type="checkbox" class="candidate-checkbox" value="{{ $opportunity->id }}"
                                            style="display:none;pointer-events: none;" wire:model="checkboxes.{{ $opportunity->id }}">
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($opportunity->date_opp)->format('d/m/y') ?? '--' }}</td>
                                    <td>{{ $opportunity->oppcode ?? '--' }}</td>
                                    <td>{{ $opportunity->job_title?? '--' }}</td>
                                    <td>{{ $opportunity->company_name ?? '--' }}</td>
                                    <td>{{ $opportunity->cp_dpt?? '--' }}</td>
                                    <td>{{ $opportunity->city_name?? '--' }}</td>
                                    <td>{{ $opportunity->opp_statut ?? '--' }}</td>
                                    <td>{{ $opportunity->remarks ?? '--' }}</td>
                                    <td>{{ $opportunity-> town?? '--' }}</td>
                                    <td>{{ $opportunity->annual_gross_salary ?? '--' }}</td>
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
        <div class="row g-0 text-center text-sm-start align-items-center mb-2">
            <!-- end col -->
            {{ $opportunities->links() }}
        </div><!-- end row -->


        <div class="modal-overlay" style="display: none;" id="customModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered cdt-modal-dialog">
                <div class="modal-content cdt-modal-content">
                    <div class="cdt-modal-header">
                        <span>Enter CDT code:</span>
                        <button id="closeModal" type="button" class="cdt-close-btn" data-bs-dismiss="modal">×</button>
                    </div>
                    <div class="cdt-modal-body">
                        <div class="cdt-input-group">
                            <input type="text" class="cdt-input" id="cdtCode" value="ADTGFHU">
                            <button class="cdt-ok-btn" id="okButton">OK</button>
                        </div>
                        <div class="cdt-message">("message")</div>
                    </div>
                </div>
            </div>
        </div>



        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <a style="margin-left:5%; margin-top:3px;" href="/opportunity/create">
                    <button style="background:#6F61C0; border:none;" wire:loading.remove wire:target="storeCandidateData" type="submit"
                        class="btn btn-success btn-label right ms-auto nexttab"><i
                            class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                        New OPP</button>
                </a>
                <button id="linkNewCDT" style="background:#FFB534; border:none;" type="submit"
                    class="btn btn-success btn-label right ms-auto nexttab"><i
                        class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                    Link CDT</button>

                <button style="background:#FF8383; border:none;" wire:loading.remove wire:target="storeCandidateData" type="submit"
                    class="btn btn-success btn-label right ms-auto nexttab"><i
                        class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                    New EVT</button>

                <button style="background:#3D3BF3; border:none; margin-right:25%;" wire:loading.remove wire:target="storeCandidateData" type="submit"
                    class="btn btn-success btn-label right ms-auto nexttab"><i
                        class="align-middle ri-arrow-right-line label-icon fs-16 ms-2"></i>
                    Save Selec.</button>

                <button id="export-button" onclick="exportSelectedCandidates()" class="btn btn-primary position-relative" style="margin-right:1%;">
                    <i class="ri-file-download-line me-1"></i>
                    <span class="download-text">Exporter</span>
                    <span wire:loading wire:target="downloadExcel" class="position-absolute top-50 start-50 translate-middle">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Exportation...</span>
                    </span>
                </button>
            </div>

        </div>

        <style>
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
                z-index: 1;
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