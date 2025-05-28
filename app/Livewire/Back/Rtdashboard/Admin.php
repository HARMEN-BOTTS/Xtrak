<?php

namespace App\Livewire\Back\Rtdashboard;

use App\Models\Rtdashboard;
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


    public function refreshData()
    {
        $this->datas = Rtdashboard::latest()->get();
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

        Rtdashboard::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    }


    public function editRow($id)
    {
        $this->editId = $id;
        $item = Rtdashboard::find($id);

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

        $item = Rtdashboard::find($this->editId);
        if ($item) {
            $item->update([
                'date_rt' => $this->formData['date_rt'] ?? null,
                'auth' => $this->formData['auth'] ?? null,
                'task_code' => $this->formData['task_code'] ?? null,
                'destination' => $this->formData['destination'] ?? null,
                'type_input' => $this->formData['type_input'] ?? null,
                'subject' => $this->formData['subject'] ?? null,
                'position' => $this->formData['position'] ?? null,
                're' => $this->formData['re'] ?? null,
                'problems' => $this->formData['problems'] ?? null,
                'corrective_actions' => $this->formData['corrective_actions'] ?? null,
                'delay' => $this->formData['delay'] ?? null,
                'remarks' => $this->formData['remarks'] ?? null,
                'priority' => $this->formData['priority'] ?? null,
                'status' => $this->formData['status'] ?? null,
                'note_one' => $this->formData['note_one'] ?? null,
                'note_two' => $this->formData['note_two'] ?? null,
                'rk' => $this->formData['rk'] ?? null,
                'vol' => $this->formData['vol'] ?? null,

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
        $data = Rtdashboard::orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        if ($this->isEditing) {
            return view('livewire.back.rtform.edit');
        }

        return view('livewire.back.rtdashboard.admin', [
            'data' => $data
        ]);
    }
}
