<?php

namespace App\Livewire\Back\Mcpdashboard;

use App\Models\Mcpdashboard;
use Livewire\Component;
use Livewire\WithPagination;

// TRG Link 
use App\Models\Trgdashboard;
use App\Models\McpTrgLink;

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

    // TRG Link 
    public $trgCode = '';
    public $showTrgModal = false;
    public $trgLinkError = '';

    // Rules for TRG code validation
    protected $rules_trg = [
        'trgCode' => 'required',
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
        $this->datas = Mcpdashboard::latest()->get();
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
            $linkedDataCount = McpTrgLink::whereIn('mcp_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-trglist-button');
            } else {
                $this->dispatch('enable-trglist-button');
            }
        } else {
            $this->dispatch('disable-trglist-button');
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
            $linkedDataCount = McpTrgLink::whereIn('mcp_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-trglist-button');
            } else {
                $this->dispatch('enable-trglist-button');
            }
        } else {
            $this->dispatch('disable-trglist-button');
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedRows)) {
            return;
        }

        Mcpdashboard::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    }

    public function checkLinkedDataTRG()
    {
        if (empty($this->selectedRows)) {
            return false;
        }

        $linkedDataCount = McpTrgLink::whereIn('mcp_id', $this->selectedRows)->count();
        return $linkedDataCount > 0;
    }



    public function showLinkedDataTRG()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('mcpdstlist');
            return;
        }

        $linkedDataCount = McpTrgLink::whereIn('mcp_id', $this->selectedRows)->count();

        if ($linkedDataCount === 0) {
            // session()->flash('message', 'No linked data for selected row.');
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-trglist-button');
            return;
        }

        redirect()->route('mcpdstlist', ['selectedRows' => $this->selectedRows]);
    }




    // New methods for TRG linking
    public function openTrgModal()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('error', 'Please select at least one opportunity to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one MCP to link");

            return;
        }

        $this->showTrgModal = true;
        $this->trgCode = '';
        $this->trgLinkError = '';
        $this->dispatch('open-trg-modal');
    }

    public function closeTrgModal()
    {
        $this->showTrgModal = false;
        $this->trgCode = '';
        $this->trgLinkError = '';

        $this->dispatch('closeModal', modalId: 'trgLinkModal');
    }

    public function linkTrg()
    {
        $this->validate([
            'trgCode' => 'required',
        ]);

        // Check if any rows are selected
        if (empty($this->selectedRows)) {
            // $this->cstLinkError = 'Please select at least one opportunity to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one MCP to link");
            return;
        }

        // Find the candidate with the given code
        $candidate = Trgdashboard::where('trg_code', $this->trgCode)->first();

        if (!$candidate) {
            // $this->cstLinkError = 'No data found with this CST code';
            $this->dispatch('alert', type: 'error', message: "No data found with this TRG code");
            $this->trgCode = '';
            $this->closeTrgModal();
            $this->dispatch('closeModal', modalId: 'trgLinkModal');
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        foreach ($this->selectedRows as $trgId) {
            // Check if already linked
            $existingLink = McpTrgLink::where('mcp_id', $trgId)
                ->where('trg_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            McpTrgLink::create([
                'mcp_id' => $trgId,
                'trg_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount MCPs linked successfully $alreadyLinkedCount were already linked.");
            $this->trgCode = '';
            $this->closeTrgModal();
            $this->dispatch('closeModal', modalId: 'trgLinkModal');
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount MCPs linked successfully");
            $this->trgCode = '';
            $this->closeTrgModal();
            $this->dispatch('closeModal', modalId: 'trgLinkModal');
        } elseif ($alreadyLinkedCount > 0) {
            // $this->cstLinkError = "Selected opportunities are already linked to this CST";
            $this->dispatch('alert', type: 'error', message: "Selected MCPs are already linked to this TRG");
            $this->trgCode = '';
            $this->closeTrgModal();
            $this->dispatch('closeModal', modalId: 'trgLinkModal');

            return;
        }

        // Clear inputs and close modal
        $this->trgCode = '';
        $this->closeTrgModal();
        $this->dispatch('closeModal', modalId: 'trgLinkModal');
    }




    public function editRow($id)
    {
        $this->editId = $id;
        $item = Mcpdashboard::find($id);

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

        $item = Mcpdashboard::find($this->editId);
        if ($item) {
            $item->update([
                'date_mcp' => $this->formData['date_mcp'] ?? null,
                'mcp_code' => $this->formData['mcp_code'] ?? null,
                'designation' => $this->formData['designation'] ?? null,
                'object' => $this->formData['object'] ?? null,
                'tag_source' => $this->formData['tag_source'] ?? null,
                'message' => $this->formData['message'] ?? null,
                'tool' => $this->formData['tool'] ?? null,
                'remarks' => $this->formData['remarks'] ?? null,
                'notes' => $this->formData['notes'] ?? null,
                'from_email' => $this->formData['from_email'] ?? null,
                'subject' => $this->formData['subject'] ?? null,
                'launch_date' => $this->formData['launch_date'] ?? null,
                'pause_min' => $this->formData['pause_min'] ?? null,
                'pause_max' => $this->formData['pause_max'] ?? null,
                'work_time_start' => $this->formData['work_time_start'] ?? null,
                'work_time_end' => $this->formData['work_time_end'] ?? null,
                'ref_time' => $this->formData['ref_time'] ?? null,
                'target_status' => $this->formData['target_status'] ?? null,
                'status' => $this->formData['status'] ?? null,
                'status_date' => $this->formData['status_date'] ?? null,

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


    // Update the viewMcmReport method
    public function viewMcmReport()
    {
        if (count($this->selectedRows) === 1) {
            $selectedMcp = Mcpdashboard::find($this->selectedRows[0]);
            if ($selectedMcp) {
                // Add debugging
                info("Redirecting to MCM report with mcp_code: " . $selectedMcp->mcp_code);

                // Redirect to MCM report with the selected MCP code
                return redirect()->route('mcpreport', ['mcpCode' => $selectedMcp->mcp_code]);
            }
        }

        // Show error message if multiple rows are selected
        if (count($this->selectedRows) > 1) {
            session()->flash('error', 'Please select only one campaign to view the report.');
        } else if (count($this->selectedRows) === 0) {
            session()->flash('error', 'Please select a campaign to view the report.');
        }
    }

    public function render()
    {
        $data = Mcpdashboard::orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        if ($this->isEditing) {
            return view('livewire.back.mcpform.edit');
        }

        return view('livewire.back.mcpdashboard.admin', [
            'data' => $data
        ]);
    }
}
