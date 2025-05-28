<div>
    @include('components.breadcrumb', [
    'title' => 'Nouvelle saisie',
    'breadcrumbItems' => [
    ['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Forms', 'url' => ''] ,['text' => 'TRGform', 'url' => '/trgform']
    ],
    ])

    <div class="row">
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
        <div>
            @if (session()->has('message'))
            <div style="margin-top:-2%;" class="d-flex justify-content-left">
                <div class="alert alert-success alert-dismissible fade show " role="alert" id="successAlert">
                    {{ session()->get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            <div class="modal-content">
                
                <div>
                    <form wire:submit.prevent="updateForm">

                        <div class="button-group">
                            <div class="button-group-left">
                                <h5 style="background-color:#DBDBDB; border-radius:5px; color:black;padding:12px;margin-top:-2px">TRGform</h5>
                                <a href="/trgform">
                                    <button style="background:#DBDBDB;color:black;" type="button" class="btn btn-close1">TRG <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                                </a>
                                <div class="two">
                                    <a href="/ctclist">
                                        <button type="button" class="btn btn-input">CTC <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                    </a>
                                    <button id="linkNewCDT" type="button" class="btn btn-input"><i class="fas fa-link"></i></button>
                                </div>
                                <div class="two">
                                    <a href="/opplist">
                                        <button type="button" class="btn btn-valid">OPP <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i></button>
                                    </a>
                                    <button id="linkNewOPP" type="button" class="btn btn-valid"><i class="fas fa-link"></i></button>
                                </div>
                                <div class="one">
                                    <a href="/trgevtlist">
                                        <button type="button" class="btn btn-evt">EVT <i style="margin-left:5px;" class="fa-regular fa-file-lines"></i> </button>
                                    </a>
                                    <button type="button" class="btn btn-evt" onclick="openModal()">EVT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button>
                                </div>
                                <div class="one">
                                    <a href="">
                                        <button type="button" class="btn"><i class="fa-regular fa-envelope fa-2x"></i></button>
                                    </a>
                                    <button style="color:red;" type="button" class="btn" onclick="openModal()"><i class="fa-solid fa-phone fa-2x"></i></button>
                                </div>
                                <div class="three">
                                    <button type="button" class="btn btn-erase" wire:click="resetForm"><i class="fa-solid fa-eraser fa-lg"></i></button>
                                    <button style="background:red;" wire:click="" class="btn btn-danger" id="delete-button-container">
                                        <i class="fa-regular fa-trash-can fa-lg"></i>
                                    </button>
                                    <button type="submit" class="btn btn-save"><i class="fa-regular fa-floppy-disk fa-lg"></i></button>
                                    <a href="/landing">
                                        <button type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group date-field">
                                <label>Date</label>
                                <input type="date" class="form-control1" wire:model="formData.candidate.creation_date">
                            </div>
                            <div class="form-group type-field">
                                <label>Auth</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.auth">
                            </div>
                            <div class="form-group objet-field">
                                <label>Company</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.company">
                            </div>
                            <div class="form-group date-field">
                                <label>Std</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.standard_phone">
                            </div>
                            <div class="form-group date-field">
                                <label>Url</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.website_url">
                            </div>
                            <div class="form-group date-field">
                                <label>TRGcode</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.trg_code" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group objet-field">
                                <label>Address1</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.address">
                            </div>
                            <div class="form-group objet-field">
                                <label>Address2</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.address_one">
                            </div>
                            <div class="form-group date-field">
                                <label>CP/Dpt</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.postal_code_department">
                            </div>
                            <div class="form-group date-field">
                                <label>Area</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.region">
                            </div>
                            <div class="form-group date-field">
                                <label>Town</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.town">
                            </div>
                            <div class="form-group date-field">
                                <label>Country</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.country">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group date-field">
                                <label>CA (K)</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.ca_k">
                            </div>
                            <div class="form-group date-field">
                                <label>Staff</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.employees">
                            </div>
                            <div class="form-group date-field">
                                <label>Activity</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.activity">
                            </div>
                            <div class="form-group date-field">
                                <label>Type</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.type">
                            </div>
                            <div class="form-group objet-field">
                                <label>SIRET</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.siret">
                            </div>
                            <div class="form-group objet-field">
                                <label>RCS</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.rcs">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group date-field">
                                <label>Filiation</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.filiation">
                            </div>
                            <div class="form-group date-field">
                                <label>OF</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.off">
                            </div>
                            <div class="form-group date-field">
                                <label>Form</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.legal_form">
                            </div>
                            <div class="form-group objet-field">
                                <label>VAT#</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.vat_number">
                            </div>
                            <div class="form-group objet-field">
                                <label>TRG Status</label>
                                <input type="text" class="form-control1" wire:model="formData.candidate.trg_status">
                            </div>
                        </div>

                        <div class="comment-section">
                            <div class="form-group comment-field">
                                <label>Remark(s)</label>
                                <textarea class="form-control2" wire:model="formData.candidate.remarks"></textarea>
                            </div>
                            <div class="form-group comment-field">
                                <label>Note(s)</label>
                                <textarea class="form-control2" wire:model="formData.candidate.notes"></textarea>
                            </div>
                            <div class="right-section">
                                <div class="next-ech-row">
                                    <div class="form-group next-field">
                                        <label>LM Sent.</label>
                                        <input type="text" class="form-control1" wire:model="formData.candidate.last_modification_date">
                                    </div>
                                    <div class="form-group ech-field">
                                        <label>Prio.</label>
                                        <input type="text" class="form-control1" wire:model="formData.candidate.priority">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="modal fade" id="cdtModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered cdt-modal-dialog">
                                <div class="modal-content cdt-modal-content">
                                    <div class="cdt-modal-header">
                                        <span>Enter CTC code:</span>
                                        <button type="button" class="cdt-close-btn" data-bs-dismiss="modal">×</button>
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



                        <div class="button-group">
                            <div class="button-group-left">
                                <!-- <a href="/trgform">
                                    <button style="background:#999;color:white;" type="button" class="btn btn-evt">New TRG</button>
                                </a>
                                <div class="one"> <button type="button" class="btn btn-evt">EVTlist</button>
                                    <button type="button" class="btn btn-evt"> > New</button>
                                </div>
                                <div class="two">
                                    <button onclick="coming()" type="button" class="btn btn-input">CTClist</button>
                                    <button id="linkNewCDT" type="button" class="btn btn-input"> > New</button>
                                </div> -->
                                <!-- <div class="three">
                                    <button type="button" class="btn btn-erase" wire:click="cancelEdit">Cancel</button>
                                    <button type="submit" class="btn btn-update">Update</button>
                                </div> -->
                                <!-- <a href="/landing">
                                    <button type="button" class="btn btn-close1">Close</button>
                                </a> -->
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>

    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
    <style>
        .modal-content {
            background: none;
            border-radius: 8px;
            width: 300px;
        }

        .modal {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px 25px;
            width: 100%;
            max-width: 1500px;
            border-radius: 2px;

        }

        .btn-save {
            background-color: #00CCDD;
            color: white;
        }

        .btn-save:hover {
            background-color: #00CCDD;
            color: white;
        }

        .modal-header {
            margin-bottom: 5px;
            margin-left: -12px;
            text-align: center;
        }

        .modal-header h2 {
            color: #333;
            font-size: 1.4em;
            font-weight: 500;
            /* margin-right: 10px; */
            text-align: center;
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
            width: 170px;
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
            /* flex: 1; */
            width: 80px;
        }

        label {
            color: black;
            margin-left: 2px;
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
            min-height: 60px;
            resize: vertical;
        }

        textarea.form-control2 {
            min-height: 67px;
            resize: vertical;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 1%;
            margin-bottom: 1%;
            margin-left: -2%;
            padding: 0 20px;
        }

        .button-group-left {
            display: flex;
            gap: 30px;
        }

        .button-group-right {
            display: flex;
        }

        .btn-input {
            background-color: #00c853;
            color: black;
        }

        .btn-inputmain {
            background-color: green;
            color: white;
        }

        .btn-update {
            background-color: #00c853;
            color: white;
        }

        .btn-update:hover {
            background-color: #00c853;
            color: white;
        }

        .btn-inputmain:hover {
            background-color: green;
            color: white;
        }

        .btn-input:hover {
            background-color: #00c853;
            color: black;
        }

        .btn-erase {
            background-color: #ff5722;
            color: white;
        }

        .btn-valid {
            background-color: #6F61C0;
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
    </style>
    <script>
        function confirm() {
            alert("Form Submitted Succefully ✅");
        }

        function coming() {
            alert("CTClist Coming Soon 🛑");
        }

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
    </script>
</div>
