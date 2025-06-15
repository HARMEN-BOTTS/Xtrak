<div>
    @include('components.breadcrumb', [
    'title' => 'Nouvelle saisie',
    'breadcrumbItems' => [
    ['text' => 'ADM', 'url' => ''] ,['text' => 'Landing', 'url' => '/landing'] ,['text' => 'Forms', 'url' => ''] ,['text' => 'MCPform', 'url' => '/mcpform']
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
                <div style="font-weight:bold;" class="alert alert-success alert-dismissible fade show " role="alert" id="successAlert">
                    {{ session()->get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            </div>
            @endif
            <div class="modal-content w-100 mb-1">
                <!-- <div class="modal-header">
                    <h2>{{ $isEditing ? 'Edit MCP Form' : 'MCPform' }}</h2>
                </div> -->

                <div class="container py-4">
                    <form wire:submit.prevent="save">

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h5 class="text-white bg-danger px-3 py-2 rounded">MCP Form</h5>
                            <div>
                                <a href="/mcpform" class="btn btn-outline-primary me-2">MCP <i class="fa-regular fa-square-plus ms-1"></i></a>
                                <button  type="button" class="btn btn-opp">OPP<i class="fas fa-link"></i></button>
                                <button  type="button" class="btn btn-trg">TRG<i class="fas fa-link"></i></button>
                                <a href="/mcpevtlist" class="btn btn-outline-info me-2">EVT <i class="fa-regular fa-file-lines ms-1"></i></a>
                                <!-- <button type="button" class="btn btn-evt" onclick="openModal()">EVT <i style="margin-left:5px;" class="fa-regular fa-square-plus"></i></button> -->
                                <button type="button" class="btn btn-outline-danger me-2" wire:click="resetForm"><i class="fa-solid fa-eraser"></i></button>
                                <button type="button" style="background:red;" class="btn btn-danger"><i class="fa-regular fa-trash-can fa-lg"></i></button>
                                <button type="submit" class="btn btn-success me-2"><i class="fa-regular fa-floppy-disk"></i></button>
                                <button onclick="history.back()" type="button" class="btn btn-close1"><i class="fas fa-times fa-lg"></i></button>
                                <a href="/mcpdashboard">
                                    <button style="border-radius: 50%;" type="button" class="btn btn-close1"><i class="fa-solid fa-arrow-left"></i></button>
                                </a>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Basic Info -->
                            <div class="col-md-3">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" wire:model="date_mcp">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">MCP code</label>
                                <input type="text" class="form-control" wire:model="mcp_code" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Designation</label>
                                <input type="text" class="form-control" wire:model="designation">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Object</label>
                                <input type="text" class="form-control" wire:model="object">
                            </div>

                            <!-- Additional Details -->
                            <div class="col-md-3">
                                <label class="form-label">OPPcode</label>
                                <input type="text" class="form-control" wire:model="tag_source">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tool</label>
                                <select class="form-select" wire:model="tool">
                                    <option value="">Select Tool</option>
                                    <option value="MCM">MCM</option>
                                    <option value="Outlook Direct">Outlook Direct</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">From (sender Email)</label>
                                <select class="form-select" wire:model="from" wire:change="fetchPasscode">
                                    <option value="">Select Email</option>
                                    @foreach($mailOptions as $mail)
                                    <option value="{{ $mail->email }}">{{ $mail->email }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Email Pass Code Info -->
                            <div class="col-md-6" hidden>
                                <label class="form-label">Passcode</label>
                                <input type="text" class="form-control" wire:model="passcode" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control" wire:model="subject">
                            </div>
                            <div class="col-md-4" hidden>
                                <label class="form-label">Message</label>
                                <input type="text" class="form-control" wire:model="message">
                            </div>

                            <!-- File Uploads -->
                            <div class="col-md-4">
                                <label class="form-label">Recipient list (Excel/CSV)</label>
                                <input type="file" class="form-control" wire:model="recip_list_path">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Message (docx/pdf)</label>
                                <input type="file" class="form-control" wire:model="message_doc">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Attachments</label>
                                <input type="file" class="form-control" wire:model="attachments" multiple>
                            </div>

                            <!-- Email Info -->
                            <!-- <div class="col-md-6">
                                <label class="form-label">From (Sender Email)</label>
                                <input type="email" class="form-control" wire:model="from">
                            </div> -->

                            <!-- Schedule Settings -->
                            <div class="col-md-4">
                                <label class="form-label">Launch date</label>
                                <input type="datetime-local" class="form-control" wire:model="launch_date">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Work time (hh:mm)</label>
                                <div class="input-group">
                                    <input type="time" class="form-control" wire:model="work_time_start">
                                    <input type="time" class="form-control" wire:model="work_time_end">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status date</label>
                                <input type="datetime-local" class="form-control" wire:model="status_date">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mail pause time (sec)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" wire:model="pause_min" placeholder="Min">
                                    <input type="number" class="form-control" wire:model="pause_max" placeholder="Max">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Batch Size (min - max)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" wire:model="batch_min" placeholder="Min">
                                    <input type="number" class="form-control" wire:model="batch_max" placeholder="Max">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Batch Pause (min)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" wire:model="" placeholder="Min">
                                    <input type="number" class="form-control" wire:model="" placeholder="Max">
                                </div>
                            </div>

                            <!-- Time Zone & Status -->
                            <div class="col-md-4">
                                <label class="form-label">Timezone</label>
                                <select class="form-select" wire:model="ref_time">
                                    <option value="">Select</option>
                                    <option value="UTC+1">UTC+1</option>
                                    <option value="UTC+2">UTC+2</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Campaign status</label>
                                <select class="form-select" wire:model="status">
                                    <option value="">Select</option>
                                    <option value="Planned">Planned</option>
                                    <option value="Executed">Executed</option>
                                    <option value="Running">Running</option>
                                    <option value="Paused">Paused</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Target type</label>
                                <select class="form-select" wire:model="target_status">
                                    <option value="">Select</option>
                                    <option value="TRG">TRG</option>
                                    <option value="CDT">CDT</option>
                                    <option value="CTC">CTC</option>
                                </select>
                            </div>

                            <!-- Comments -->
                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <input type="text" class="form-control" wire:model="remarks">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" rows="3" wire:model="notes"></textarea>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-info" wire:click="generatePreview">Preview First Email</button>
                                @if($previewMessage)
                                <div class="mt-3 p-3 border bg-light">
                                    <h5>Preview for: {{ $previewRecipientEmail }}</h5>
                                    <div style="border: 1px solid #ddd; padding: 15px; background-color: white; font-family: Arial, sans-serif; line-height: 1.4;">
                                        {!! $previewMessage !!}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Hidden Modal still preserved here -->
                        <div class="modal fade" id="cdtModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span>Enter CTC code:</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="cdtCode">
                                            <button class="btn btn-primary" type="button" id="okButton">OK</button>
                                        </div>
                                        <div class="cdt-message mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <script>

    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .btn-opp {
            background-color: #6F61C0;
            color: white;
        }

        .btn-opp:hover {
            background-color: #6F61C0;
            color: white;
        }

        .btn-mcp {
            background-color: #7D0A0A;
            color: white;
        }

        .btn-mcp:hover {
            background-color: #7D0A0A;
            color: white;
        }

        .btn-trg {
            background-color: #DBDBDB;
            color: black;
        }

        .btn-trg:hover {
            background-color: #DBDBDB;
            color: black;
        }

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
            width: 80%;
            max-width: 1200px;
            border-radius: 2px;

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
            width: 200px;
        }

        .company-field {
            width: 380px;
        }

        .mail-field {
            width: 330px;
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
            margin-left: 20px;
            width: 95%;
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
            margin-bottom: 2%;
            padding: 0 20px;
        }

        .button-group-left {
            display: flex;
            gap: 40px;
        }

        .button-group-right {
            display: flex;
        }

        .btn-input {
            background-color: #06D001;
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
            background-color: #06D001;
            color: white;
        }

        .btn-inputmain:hover {
            background-color: #06D001;
            color: white;
        }

        .btn-input:hover {
            background-color: #06D001;
            color: black;
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
        setTimeout(function() {
            var successAlert = document.getElementById('successAlert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 5000);

        function confirm() {
            alert("Form Submitted Successfully ✅");
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