<?php

namespace App\Livewire\Back\Trgdashboard;

use App\Models\Trgdashboard;
use Livewire\Component;
use Livewire\WithPagination;

// OPP Link 
use App\Models\Oppdashboard;
use App\Models\TrgOppLink;

// CTC Link 
use App\Models\Ctcdashboard;
use App\Models\TrgCtcLink;

// MCP Link 
use App\Models\Mcpdashboard;
use App\Models\TrgMcpLink;

// Event : 
use App\Models\TrgEvent;

// Import/Export related
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TrgdashboardImport;
use App\Exports\TrgdashboardExport;

class Admin extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';
    public $selectAll = false;

    public $datas;
    public $selectedRows = [];
    protected $listeners = ['refreshTable' => '$refresh'];
    public $isEditing = false;
    public $editId = null;
    public $formData = [];

    // OPP Link 
    public $oppCode = '';
    public $showOppModal = false;
    public $oppLinkError = '';

    // Rules for OPP code validation
    protected $rules_opp = [
        'oppCode' => 'required',
    ];


    // CTC Link 
    public $ctcCode = '';
    public $showCtcModal = false;
    public $ctcLinkError = '';

    // Rules for CTC code validation
    protected $rules_ctc = [
        'ctcCode' => 'required',
    ];


    // MCP Link 
    public $mcpCode = '';
    public $showMcpModal = false;
    public $mcpLinkError = '';

    // Rules for MCP code validation
    protected $rules_mcp = [
        'mcpCode' => 'required',
    ];


    // Import/Export properties
    public $showImportModal = false;
    public $importFile;

    // Import validation rules
    protected $rules_import = [
        'importFile' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max
    ];


    // Import/Export Methods
    public function openImportModal()
    {
        $this->showImportModal = true;
        $this->importFile = null;
        $this->dispatch('open-import-modal');
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->importFile = null;
        $this->dispatch('closeModal', modalId: 'importModal');
    }

    public function importData()
    {
        $this->validate($this->rules_import);

        try {
            Excel::import(new TrgdashboardImport, $this->importFile->getRealPath());

            $this->closeImportModal();
            $this->refreshData();
            $this->dispatch('alert', type: 'success', message: "Data imported successfully!");
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: "Import failed: " . $e->getMessage());
        }
    }

    // public function exportData()
    // {
    //     try {
    //         return Excel::download(new CtcdashboardExport, 'ctc_dashboard_' . date('Y-m-d_H-i-s') . '.xlsx');
    //     } catch (\Exception $e) {
    //         $this->dispatch('alert', type: 'error', message: "Export failed: " . $e->getMessage());
    //     }
    // }

    public $isExporting = false;

    public function exportData()
    {
        $this->isExporting = true;

        try {
            return Excel::download(new TrgdashboardExport, 'trg_dashboard_' . date('Y-m-d_H-i-s') . '.xlsx');
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: "Export failed: " . $e->getMessage());
        } finally {
            $this->isExporting = false;
        }
    }



    // Event : 

    public $showEventModal = false;
    public $eventFormData = [];


    public $showCheckboxes = false;

    public function toggleSelectionMode()
    {
        $this->showCheckboxes = !$this->showCheckboxes;
        if (!$this->showCheckboxes) {
            $this->selectedRows = [];
            $this->selectAll = false;
        }
    }

    public function refreshData()
    {
        $this->datas = Trgdashboard::latest()->get();
    }

    public function updatedSelectAll($value)
    {
        // if ($value) {
        //     $this->selectedRows = $this->datas->pluck('id')->map(function ($id) {
        //         return (string) $id;
        //     })->toArray();
        // } else {
        //     $this->selectedRows = [];
        // }


        if (!empty($this->selectedRows)) {
            $linkedDataCount = TrgOppLink::whereIn('trg_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-opplist-button');
            } else {
                $this->dispatch('enable-opplist-button');
            }
        } else {
            $this->dispatch('disable-opplist-button');
        }

        if (!empty($this->selectedRows)) {
            $linkedDataCount = TrgCtcLink::whereIn('trg_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-ctclist-button');
            } else {
                $this->dispatch('enable-ctclist-button');
            }
        } else {
            $this->dispatch('disable-ctclist-button');
        }


        if (!empty($this->selectedRows)) {
            $linkedDataCount = TrgMcpLink::whereIn('trg_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-mcplist-button');
            } else {
                $this->dispatch('enable-mcplist-button');
            }
        } else {
            $this->dispatch('disable-mcplist-button');
        }
    }

    public function toggleSelect($id)
    {
        if (in_array($id, $this->selectedRows)) {
            $this->selectedRows = array_diff($this->selectedRows, [$id]);
        } else {
            $this->selectedRows = [$id];
        }

        if (!empty($this->selectedRows)) {
            $linkedDataCount = TrgOppLink::whereIn('trg_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-opplist-button');
            } else {
                $this->dispatch('enable-opplist-button');
            }
        } else {
            $this->dispatch('disable-opplist-button');
        }

        if (!empty($this->selectedRows)) {
            $linkedDataCount = TrgCtcLink::whereIn('trg_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-ctclist-button');
            } else {
                $this->dispatch('enable-ctclist-button');
            }
        } else {
            $this->dispatch('disable-ctclist-button');
        }


        if (!empty($this->selectedRows)) {
            $linkedDataCount = TrgMcpLink::whereIn('trg_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-mcplist-button');
            } else {
                $this->dispatch('enable-mcplist-button');
            }
        } else {
            $this->dispatch('disable-mcplist-button');
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedRows)) {
            return;
        }

        Trgdashboard::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        // session()->flash('message', 'Data Deleted Successfully 🛑');
        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    }




    public function checkLinkedData()
    {
        if (empty($this->selectedRows)) {
            return false;
        }

        $linkedDataCount = TrgOppLink::whereIn('trg_id', $this->selectedRows)->count();
        return $linkedDataCount > 0;
    }

    public function checkLinkedDataCTC()
    {
        if (empty($this->selectedRows)) {
            return false;
        }

        $linkedDataCount = TrgCtcLink::whereIn('trg_id', $this->selectedRows)->count();
        return $linkedDataCount > 0;
    }

    public function checkLinkedDataMCP()
    {
        if (empty($this->selectedRows)) {
            return false;
        }

        $linkedDataCount = TrgMcpLink::whereIn('trg_id', $this->selectedRows)->count();
        return $linkedDataCount > 0;
    }



    public function showLinkedData()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('trgopplist');
            return;
        }

        $linkedDataCount = TrgOppLink::whereIn('trg_id', $this->selectedRows)->count();

        if ($linkedDataCount === 0) {
            // session()->flash('message', 'No linked data for selected row.');
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-opplist-button');
            return;
        }

        redirect()->route('trgopplist', ['selectedRows' => $this->selectedRows]);
    }



    public function showLinkedDataCTC()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('trgctclist');
            return;
        }

        $linkedDataCount = TrgCtcLink::whereIn('trg_id', $this->selectedRows)->count();

        if ($linkedDataCount === 0) {
            // session()->flash('message', 'No linked data for selected row.');
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-ctclist-button');
            return;
        }

        redirect()->route('trgctclist', ['selectedRows' => $this->selectedRows]);
    }

    public function showLinkedDataMCP()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('trgmcplist');
            return;
        }

        $linkedDataCount = TrgMcpLink::whereIn('trg_id', $this->selectedRows)->count();

        if ($linkedDataCount === 0) {
            // session()->flash('message', 'No linked data for selected row.');
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-mcplist-button');
            return;
        }

        redirect()->route('trgmcplist', ['selectedRows' => $this->selectedRows]);
    }


    // New methods for OPP linking
    public function openOppModal()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('error', 'Please select at least one opportunity to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one target to link");

            return;
        }

        $this->showOppModal = true;
        $this->oppCode = '';
        $this->oppLinkError = '';
        $this->dispatch('open-opp-modal');
    }

    public function closeOppModal()
    {
        $this->showOppModal = false;
        $this->oppCode = '';
        $this->oppLinkError = '';

        $this->dispatch('closeModal', modalId: 'oppLinkModal');
    }

    public function linkOpp()
    {
        $this->validate([
            'oppCode' => 'required',
        ]);

        // Check if any rows are selected
        if (empty($this->selectedRows)) {
            // $this->cstLinkError = 'Please select at least one opportunity to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one target to link");
            return;
        }

        // Find the candidate with the given code
        $candidate = Oppdashboard::where('opp_code', $this->oppCode)->first();

        if (!$candidate) {
            // $this->cstLinkError = 'No data found with this CST code';
            $this->dispatch('alert', type: 'error', message: "No data found with this OPP code");
            $this->oppCode = '';
            $this->closeOppModal();
            $this->dispatch('closeModal', modalId: 'oppLinkModal');
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        foreach ($this->selectedRows as $trgId) {
            // Check if already linked
            $existingLink = TrgOppLink::where('trg_id', $trgId)
                ->where('opp_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            TrgOppLink::create([
                'trg_id' => $trgId,
                'opp_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount target linked successfully $alreadyLinkedCount were already linked.");
            $this->oppCode = '';
            $this->closeOppModal();
            $this->dispatch('closeModal', modalId: 'oppLinkModal');
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount target linked successfully");
            $this->oppCode = '';
            $this->closeOppModal();
            $this->dispatch('closeModal', modalId: 'oppLinkModal');
        } elseif ($alreadyLinkedCount > 0) {
            // $this->cstLinkError = "Selected opportunities are already linked to this CST";
            $this->dispatch('alert', type: 'error', message: "Selected target are already linked to this OPP");
            $this->oppCode = '';
            $this->closeOppModal();
            $this->dispatch('closeModal', modalId: 'oppLinkModal');

            return;
        }

        // Clear inputs and close modal
        $this->oppCode = '';
        $this->closeOppModal();
        $this->dispatch('closeModal', modalId: 'oppLinkModal');
    }



    // New methods for CTC linking
    public function openCtcModal()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('error', 'Please select at least one opportunity to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one target to link");

            return;
        }

        $this->showCtcModal = true;
        $this->ctcCode = '';
        $this->ctcLinkError = '';
        $this->dispatch('open-ctc-modal');
    }

    public function closeCtcModal()
    {
        $this->showCtcModal = false;
        $this->ctcCode = '';
        $this->ctcLinkError = '';

        $this->dispatch('closeModal', modalId: 'ctcLinkModal');
    }

    public function linkCtc()
    {
        $this->validate([
            'ctcCode' => 'required',
        ]);

        // Check if any rows are selected
        if (empty($this->selectedRows)) {
            // $this->cstLinkError = 'Please select at least one opportunity to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one target to link");
            return;
        }

        // Find the candidate with the given code
        $candidate = Ctcdashboard::where('ctc_code', $this->ctcCode)->first();

        if (!$candidate) {
            // $this->cstLinkError = 'No data found with this CST code';
            $this->dispatch('alert', type: 'error', message: "No data found with this CTC code");
            $this->ctcCode = '';
            $this->closeCtcModal();
            $this->dispatch('closeModal', modalId: 'ctcLinkModal');
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        foreach ($this->selectedRows as $trgId) {
            // Check if already linked
            $existingLink = TrgCtcLink::where('trg_id', $trgId)
                ->where('ctc_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            TrgCtcLink::create([
                'trg_id' => $trgId,
                'ctc_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount targets linked successfully $alreadyLinkedCount were already linked.");
            $this->ctcCode = '';
            $this->closeCtcModal();
            $this->dispatch('closeModal', modalId: 'ctcLinkModal');
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount targets linked successfully");
            $this->ctcCode = '';
            $this->closeCtcModal();
            $this->dispatch('closeModal', modalId: 'ctcLinkModal');
        } elseif ($alreadyLinkedCount > 0) {
            // $this->cstLinkError = "Selected opportunities are already linked to this CST";
            $this->dispatch('alert', type: 'error', message: "Selected targets are already linked to this CTC");
            $this->ctcCode = '';
            $this->closeCtcModal();
            $this->dispatch('closeModal', modalId: 'ctcLinkModal');

            return;
        }

        // Clear inputs and close modal
        $this->ctcCode = '';
        $this->closeCtcModal();
        $this->dispatch('closeModal', modalId: 'ctcLinkModal');
    }



    // New methods for MCP linking
    public function openMcpModal()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('error', 'Please select at least one opportunity to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one target to link");

            return;
        }

        $this->showMcpModal = true;
        $this->mcpCode = '';
        $this->mcpLinkError = '';
        $this->dispatch('open-mcp-modal');
    }

    public function closeMcpModal()
    {
        $this->showMcpModal = false;
        $this->mcpCode = '';
        $this->mcpLinkError = '';

        $this->dispatch('closeModal', modalId: 'mcpLinkModal');
    }

    public function linkMcp()
    {
        $this->validate([
            'mcpCode' => 'required',
        ]);

        // Check if any rows are selected
        if (empty($this->selectedRows)) {
            // $this->cstLinkError = 'Please select at least one opportunity to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one target to link");
            return;
        }

        // Find the candidate with the given code
        $candidate = Mcpdashboard::where('mcp_code', $this->mcpCode)->first();

        if (!$candidate) {
            // $this->cstLinkError = 'No data found with this CST code';
            $this->dispatch('alert', type: 'error', message: "No data found with this MCP code");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        foreach ($this->selectedRows as $trgId) {
            // Check if already linked
            $existingLink = TrgMcpLink::where('trg_id', $trgId)
                ->where('mcp_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            TrgMcpLink::create([
                'trg_id' => $trgId,
                'mcp_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount targets linked successfully $alreadyLinkedCount were already linked.");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount targets linked successfully");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        } elseif ($alreadyLinkedCount > 0) {
            // $this->cstLinkError = "Selected opportunities are already linked to this CST";
            $this->dispatch('alert', type: 'error', message: "Selected targets are already linked to this MCP");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');

            return;
        }

        // Clear inputs and close modal
        $this->mcpCode = '';
        $this->closeMcpModal();
        $this->dispatch('closeModal', modalId: 'mcpLinkModal');
    }




    // Event : 


    // Add these methods
    public function openEventModal()
    {
        if (empty($this->selectedRows)) {
            $this->dispatch('alert', type: 'error', message: "Please select at least one row to create event");
            return;
        }

        // Get the first selected row data to populate form
        $selectedItem = Trgdashboard::find($this->selectedRows[0]);

        if ($selectedItem) {
            $this->eventFormData = [
                'trg_id' => $selectedItem->id,
                'trg_code' => $selectedItem->trg_code,
                'company' => $selectedItem->company,
                'ctc_code' => '', // You might need to get this from related data
                'first_name' => $selectedItem->first_name,
                'last_name' => $selectedItem->last_name,
                'position' => $selectedItem->position,
                'event_date' => date('Y-m-d'),
                'type' => '',
                'io' => '',
                'object' => '',
                'status' => '',
                'comment' => '',
                'next' => '',
                'ech' => '',
                'priority' => '',
                'last_comment' => '',
                'date_last_comment' => date('Y-m-d'),
                'other_comment' => '',
                'note1' => '',
                'temper' => '',
                'retour' => ''
            ];
        }

        $this->showEventModal = true;
        $this->dispatch('open-event-modal');
    }

    public function closeEventModal()
    {
        $this->showEventModal = false;
        $this->eventFormData = [];
        $this->dispatch('close-event-modal');
    }

    public function saveEvent()
    {
        // $this->validate([
        //     'eventFormData.event_date' => 'required|date',
        //     'eventFormData.type' => 'required',
        // ]);

        TrgEvent::create([
            'trg_id' => $this->eventFormData['trg_id'],
            'event_date' => $this->eventFormData['event_date'],
            'type' => $this->eventFormData['type'],
            'io' => $this->eventFormData['io'],
            'object' => $this->eventFormData['object'],
            'status' => $this->eventFormData['status'],
            'comment' => $this->eventFormData['comment'],
            'next' => $this->eventFormData['next'],
            'ech' => $this->eventFormData['ech'],
            'priority' => $this->eventFormData['priority'],
            'last_comment' => $this->eventFormData['last_comment'],
            'date_last_comment' => $this->eventFormData['date_last_comment'],
            'other_comment' => $this->eventFormData['other_comment'],
            'note1' => $this->eventFormData['note1'],
            'temper' => $this->eventFormData['temper'],
            'retour' => $this->eventFormData['retour']
        ]);

        $this->dispatch('alert', type: 'success', message: "Event created successfully");
        $this->closeEventModal();
    }

    public function showEventList()
    {
        if (empty($this->selectedRows)) {
            // Show all events
            redirect()->route('trgevtlist');
            return;
        }

        $eventDataCount = TrgEvent::whereIn('trg_id', $this->selectedRows)->count();


        if ($eventDataCount === 0) {
            $this->dispatch('alert', type: 'error', message: "No event created for selected row");
            return;
        }

        // Show events for selected rows
        redirect()->route('trgevtlist', ['selectedRows' => $this->selectedRows]);
    }

    public function resetEventForm()
    {
        $selectedItem = null;
        if (!empty($this->selectedRows)) {
            $selectedItem = Trgdashboard::find($this->selectedRows[0]);
        }

        if ($selectedItem) {

            $this->eventFormData = [
                'trg_id' => $selectedItem->id,
                'trg_code' => $selectedItem->trg_code,
                'company' => $selectedItem->company,
                'ctc_code' => '',
                'first_name' => $selectedItem->first_name,
                'last_name' => $selectedItem->last_name,
                'position' => $selectedItem->position,
                'event_date' => date('Y-m-d'),
                'type' => '',
                'io' => '',
                'object' => '',
                'status' => '',
                'comment' => '',
                'next' => '',
                'ech' => '',
                'priority' => '',
                'last_comment' => '',
                'date_last_comment' => date('Y-m-d'),
                'other_comment' => '',
                'note1' => '',
                'temper' => '',
                'retour' => ''
            ];
        } else {
            $this->eventFormData = [
                'trg_id' => '',
                'trg_code' => '',
                'company' => '',
                'ctc_code' => '',
                'first_name' => '',
                'last_name' => '',
                'position' => '',
                'event_date' => date('Y-m-d'),
                'type' => '',
                'io' => '',
                'object' => '',
                'status' => '',
                'comment' => '',
                'next' => '',
                'ech' => '',
                'priority' => '',
                'last_comment' => '',
                'date_last_comment' => date('Y-m-d'),
                'other_comment' => '',
                'note1' => '',
                'temper' => '',
                'retour' => ''
            ];
        }

        $this->dispatch('alert', type: 'info', message: "Form has been reset");
        $this->dispatch('form-reset');
    }


    public function newEventForm()
    {
        $selectedItem = null;
        if (!empty($this->selectedRows)) {
            $selectedItem = Trgdashboard::find($this->selectedRows[0]);
        }

        if ($selectedItem) {

            $this->eventFormData = [
                'trg_id' => $selectedItem->id,
                'trg_code' => $selectedItem->trg_code,
                'company' => $selectedItem->company,
                'ctc_code' => '',
                'first_name' => $selectedItem->first_name,
                'last_name' => $selectedItem->last_name,
                'position' => $selectedItem->position,
                'event_date' => date('Y-m-d'),
                'type' => '',
                'io' => '',
                'object' => '',
                'status' => '',
                'comment' => '',
                'next' => '',
                'ech' => '',
                'priority' => '',
                'last_comment' => '',
                'date_last_comment' => date('Y-m-d'),
                'other_comment' => '',
                'note1' => '',
                'temper' => '',
                'retour' => ''
            ];
        } else {
            $this->eventFormData = [
                'trg_id' => '',
                'trg_code' => '',
                'company' => '',
                'ctc_code' => '',
                'first_name' => '',
                'last_name' => '',
                'position' => '',
                'event_date' => date('Y-m-d'),
                'type' => '',
                'io' => '',
                'object' => '',
                'status' => '',
                'comment' => '',
                'next' => '',
                'ech' => '',
                'priority' => '',
                'last_comment' => '',
                'date_last_comment' => date('Y-m-d'),
                'other_comment' => '',
                'note1' => '',
                'temper' => '',
                'retour' => ''
            ];
        }

        $this->dispatch('alert', type: 'success', message: "New Event Form Opened");
        $this->dispatch('form-reset');
    }
























    public function editRow($id)
    {
        $this->editId = $id;
        $item = Trgdashboard::find($id);

        if ($item) {
            $this->formData = $item->toArray();
            $this->isEditing = true;
        }
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->editId = null;
        $this->formData = [];
    }

    public function updateForm()
    {
        // $this->validate([
        //     'formData.date_ctc' => 'required|date',
        //     'formData.ctc_code' => 'required',
        //     'formData.first_name' => 'required',
        //     'formData.last_name' => 'required',
        //     'formData.mail' => 'required|email',
        // ]);

        $item = Trgdashboard::find($this->editId);
        if ($item) {
            $item->update([
                'creation_date' => $this->formData['creation_date'] ?? null,
                'auth' => $this->formData['auth'] ?? null,
                'company' => $this->formData['company'] ?? null,
                'standard_phone' => $this->formData['standard_phone'] ?? null,
                'website_url' => $this->formData['website_url'] ?? null,
                'trg_code' => $this->formData['trg_code'] ?? null,
                'address' => $this->formData['address'] ?? null,
                'address_one' => $this->formData['address_one'] ?? null,
                'postal_code_department' => $this->formData['postal_code_department'] ?? null,
                'region' => $this->formData['region'] ?? null,
                'town' => $this->formData['town'] ?? null,
                'country' => $this->formData['country'] ?? null,
                'ca_k' => $this->formData['ca_k'] ?? null,
                'employees' => $this->formData['employees'] ?? null,
                'activity' => $this->formData['activity'] ?? null,
                'type' => $this->formData['type'] ?? null,
                'siret' => $this->formData['siret'] ?? null,
                'rcs' => $this->formData['rcs'] ?? null,
                'filiation' => $this->formData['filiation'] ?? null,
                'off' => $this->formData['off'] ?? null,
                'legal_form' => $this->formData['legal_form'] ?? null,
                'vat_number' => $this->formData['vat_number'] ?? null,
                'trg_status' => $this->formData['trg_status'] ?? null,
                'remarks' => $this->formData['remarks'] ?? null,
                'notes' => $this->formData['notes'] ?? null,
                'last_modification_date' => $this->formData['last_modification_date'] ?? null,
                'priority' => $this->formData['priority'] ?? null,

            ]);

            $this->isEditing = false;
            $this->editId = null;
            $this->formData = [];

            $this->refreshData();

            // session()->flash('message', 'Form Updated Successfully ✅');
            $this->dispatch('alert', type: 'success', message: "Form Updated Successfully");
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function render()
    {
        $data = Trgdashboard::orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        if ($this->isEditing) {
            return view('livewire.back.trgform.edit');
        }

        return view('livewire.back.trgdashboard.admin', [
            'data' => $data
        ]);
    }
}
