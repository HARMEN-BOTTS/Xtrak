<?php

namespace App\Livewire\Back\Ctcdashboard;

use App\Models\Ctcdashboard;
use Livewire\Component;
use Livewire\WithPagination;

// MCP Link 
use App\Models\Mcpdashboard;
use App\Models\CtcMcpLink;

class Admin extends Component
{
    use WithPagination;
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


