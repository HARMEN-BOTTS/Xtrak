<?php

namespace App\Livewire\Back\Ctcdashboard;


use App\Models\Ctcdashboard;
use Livewire\Component;
use Livewire\WithPagination;

// MCP Link 
use App\Models\Mcpdashboard;
use App\Models\CtcMcpLink;

// Event : 
use App\Models\CtcEvent;

// Import/Export related
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CtcdashboardImport;
use App\Exports\CtcdashboardExport;


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


    // MCP Link 
    public $mcpCode = '';
    public $showMcpModal = false;
    public $mcpLinkError = '';

    // Rules for OPP code validation
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
            Excel::import(new CtcdashboardImport, $this->importFile->getRealPath());

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
            return Excel::download(new CtcdashboardExport, 'ctc_dashboard_' . date('Y-m-d_H-i-s') . '.xlsx');
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
        $this->datas = Ctcdashboard::latest()->get();
    }

    public function updatedSelectAll($value)
    {
        // if ($value) {
        //     $this->selectedRows = $this->data->pluck('id')->map(function ($id) {
        //         return (string) $id;
        //     })->toArray();
        // } else {
        //     $this->selectedRows = [];
        // }


        if (!empty($this->selectedRows)) {
            $linkedDataCount = CtcMcpLink::whereIn('ctc_id', $this->selectedRows)->count();

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
            $linkedDataCount = CtcMcpLink::whereIn('ctc_id', $this->selectedRows)->count();

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

        Ctcdashboard::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    }


    public function checkLinkedDataMCP()
    {
        if (empty($this->selectedRows)) {
            return false;
        }

        $linkedDataCount = CtcMcpLink::whereIn('ctc_id', $this->selectedRows)->count();
        return $linkedDataCount > 0;
    }

    public function showLinkedDataMCP()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('ctcmcplist');
            return;
        }

        $linkedDataCount = CtcMcpLink::whereIn('ctc_id', $this->selectedRows)->count();

        if ($linkedDataCount === 0) {
            // session()->flash('message', 'No linked data for selected row.');
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-mcplist-button');
            return;
        }

        redirect()->route('ctcmcplist', ['selectedRows' => $this->selectedRows]);
    }


    // New methods for MCP linking
    public function openMcpModal()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('error', 'Please select at least one opportunity to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one contact to link");

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
            $this->dispatch('alert', type: 'error', message: "Please select at least one contact to link");
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
            $existingLink = CtcMcpLink::where('ctc_id', $trgId)
                ->where('mcp_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            CtcMcpLink::create([
                'ctc_id' => $trgId,
                'mcp_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount contacts linked successfully $alreadyLinkedCount were already linked.");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount contacts linked successfully");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        } elseif ($alreadyLinkedCount > 0) {
            // $this->cstLinkError = "Selected opportunities are already linked to this CST";
            $this->dispatch('alert', type: 'error', message: "Selected contacts are already linked to this MCP");
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
        $selectedItem = Ctcdashboard::find($this->selectedRows[0]);

        if ($selectedItem) {
            $this->eventFormData = [
                'ctc_id' => $selectedItem->id,
                'event_date' => date('Y-m-d'),
                'type' => '',
                'io' => '',
                'object' => '',
                'status' => '',
                'feed' => '',
                'comment' => '',
                'next' => '',
                'ech' => '',
                'priority' => '',
                'last_comment' => '',
                'date_last_comment' => date('Y-m-d'),
                'other_comment' => '',
                'note1' => '',
                'temper' => '',
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

        CtcEvent::create([
            'ctc_id' => $this->eventFormData['ctc_id'],
            'event_date' => $this->eventFormData['event_date'],
            'type' => $this->eventFormData['type'],
            'io' => $this->eventFormData['io'],
            'object' => $this->eventFormData['object'],
            'status' => $this->eventFormData['status'],
            'feed' => $this->eventFormData['feed'],
            'temper' => $this->eventFormData['temper'],
            'comment' => $this->eventFormData['comment'],
            'next' => $this->eventFormData['next'],
            'ech' => $this->eventFormData['ech'],
            'priority' => $this->eventFormData['priority'],
            'last_comment' => $this->eventFormData['last_comment'],
            'date_last_comment' => $this->eventFormData['date_last_comment'],
            'other_comment' => $this->eventFormData['other_comment'],
            'note1' => $this->eventFormData['note1'],
        ]);

        $this->dispatch('alert', type: 'success', message: "Event created successfully");
        $this->closeEventModal();
    }

    public function showEventList()
    {
        if (empty($this->selectedRows)) {
            // Show all events
            redirect()->route('ctcevtlist');
            return;
        }

        $eventDataCount = CtcEvent::whereIn('ctc_id', $this->selectedRows)->count();


        if ($eventDataCount === 0) {
            $this->dispatch('alert', type: 'error', message: "No event created for selected row");
            return;
        }

        // Show events for selected rows
        redirect()->route('ctcevtlist', ['selectedRows' => $this->selectedRows]);
    }

    public function resetEventForm()
    {
        $selectedItem = null;
        if (!empty($this->selectedRows)) {
            $selectedItem = Ctcdashboard::find($this->selectedRows[0]);
        }

        if ($selectedItem) {

            $this->eventFormData = [
                'ctc_id' => $selectedItem->id,
                'event_date' => date('Y-m-d'),
                'type' => '',
                'io' => '',
                'object' => '',
                'status' => '',
                'feed' => '',
                'comment' => '',
                'next' => '',
                'ech' => '',
                'priority' => '',
                'last_comment' => '',
                'date_last_comment' => date('Y-m-d'),
                'other_comment' => '',
                'note1' => '',
                'temper' => '',
            ];
        } else {
            $this->eventFormData = [
                'ctc_id' => '',
                'event_date' => date('Y-m-d'),
                'type' => '',
                'io' => '',
                'object' => '',
                'status' => '',
                'feed' => '',
                'comment' => '',
                'next' => '',
                'ech' => '',
                'priority' => '',
                'last_comment' => '',
                'date_last_comment' => date('Y-m-d'),
                'other_comment' => '',
                'note1' => '',
                'temper' => '',
            ];
        }

        $this->dispatch('alert', type: 'info', message: "Form has been reset");
        $this->dispatch('form-reset');
    }










    public function editRow($id)
    {
        $this->editId = $id;
        $item = Ctcdashboard::find($id);

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

        $item = Ctcdashboard::find($this->editId);
        if ($item) {
            $item->update([
                'date_ctc' => $this->formData['date_ctc'],
                'ctc_code' => $this->formData['ctc_code'],
                'trg_code' => $this->formData['trg_code'] ?? null,
                'company_ctc' => $this->formData['company_ctc'] ?? null,
                'civ' => $this->formData['civ'] ?? null,
                'first_name' => $this->formData['first_name'],
                'last_name' => $this->formData['last_name'],
                'function_ctc' => $this->formData['function_ctc'] ?? null,
                'std_ctc' => $this->formData['std_ctc'] ?? null,
                'ext_ctc' => $this->formData['ext_ctc'] ?? null,
                'ld' => $this->formData['ld'] ?? null,
                'remarks' => $this->formData['remarks'] ?? null,
                'cell' => $this->formData['cell'] ?? null,
                'mail' => $this->formData['mail'],
                'notes' => $this->formData['notes'] ?? null,
            ]);

            $this->isEditing = false;
            $this->editId = null;
            $this->formData = [];

            $this->refreshData();

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
        $data = Ctcdashboard::orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        if ($this->isEditing) {
            return view('livewire.back.ctcform.edit');
        }

        return view('livewire.back.ctcdashboard.admin', [
            'data' => $data
        ]);
    }
}
