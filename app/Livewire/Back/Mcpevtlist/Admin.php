<?php

namespace App\Livewire\Back\Mcpevtlist;

use App\Models\Mcpdashboard;
use Livewire\Component;
use Livewire\WithPagination;


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
        if ($value) {
            $this->selectedRows = $this->data->pluck('id')->map(function ($id) {
                return (string) $id;
            })->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function toggleSelect($id)
    {
        if (in_array($id, $this->selectedRows)) {
            $this->selectedRows = array_diff($this->selectedRows, [$id]);
        } else {
            $this->selectedRows = [$id];
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

        return view('livewire.back.mcpevtlist.admin', [
            'data' => $data
        ]);
    }
}
