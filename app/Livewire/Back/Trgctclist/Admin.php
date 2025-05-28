<?php

namespace App\Livewire\Back\Trgctclist;

use Livewire\Component;
use App\Models\TrgCtcLink;
use App\Models\Ctcdashboard;
use Livewire\WithPagination;

class Admin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $datas;
    public $selectedRows = [];
    protected $listeners = ['refreshTable' => '$refresh'];
    public $isEditing = false;
    public $editId = null;
    public $formData = [];
    public $selectAll = false;
    public $step = 1;
    public $action;

    public $search = '';

    public function refreshData()
    {
        $this->datas = TrgCtcLink::latest()->get();
    }

    public function mount()
    {
        $this->refreshData();
    }


    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = $this->links->pluck('id')->map(function ($id) {
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

        TrgCtcLink::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        // session()->flash('message', 'Data Deleted Successfully 🛑');
        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    }



    public function editRow($id)
    {
        $this->editId = $id;
        $link = TrgCtcLink::with(['opportunity', 'candidate'])->find($id);

        if ($link) {
            $this->formData = $link->toArray();
            $this->isEditing = true;
        } else {
            // session()->flash('message', 'Record not found!');
            $this->dispatch('alert', type: 'error', message: "Record not found!");
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
        $candidateData = $this->formData['candidate'];

        $link = Ctcdashboard::where('ctc_code', $candidateData['ctc_code'])->first();
        if ($link) {
            $link->update([
                'date_ctc' => $candidateData['date_ctc'] ?? null,
                'ctc_code' => $candidateData['ctc_code'] ?? null,
                'trg_code' => $candidateData['trg_code'] ?? null,
                'company_ctc' => $candidateData['company_ctc'] ?? null,
                'civ' => $candidateData['civ'] ?? null,
                'first_name' => $candidateData['first_name'] ?? null,
                'last_name' => $candidateData['last_name'] ?? null,
                'function_ctc' => $candidateData['function_ctc'] ?? null,
                'std_ctc' => $candidateData['std_ctc'] ?? null,
                'ext_ctc' => $candidateData['ext_ctc'] ?? null,
                'ld' => $candidateData['ld'] ?? null,
                'remarks' => $candidateData['remarks'] ?? null,
                'cell' => $candidateData['cell'] ?? null,
                'mail' => $candidateData['mail'] ?? null,
                'notes' => $candidateData['notes'] ?? null,
            ]);

            $this->isEditing = false;
            $this->editId = null;
            $this->formData = [];

            $this->refreshData();

            // session()->flash('message', 'Form Updated Successfully ✅');
            $this->dispatch('alert', type: 'success', message: "Form Updated Successfully");
        } else {
            // session()->flash('message', 'Record not found ❌');
            $this->dispatch('alert', type: 'error', message: "Record not found");
        }
    }



    public function deleteCtcLink($linkId)
    {
        TrgCtcLink::find($linkId)->delete();
        // session()->flash('message', 'Link removed successfully ✅');
        $this->dispatch('alert', type: 'success', message: "Link removed successfully");
    }

    public function render()
    {
        $query = TrgCtcLink::with(['opportunity', 'candidate']);


        if (request()->has('selectedRows')) {
            $selectedRows = request()->get('selectedRows');
            $query->whereIn('trg_id', $selectedRows);
        }

        $links = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($this->isEditing) {
            return view('livewire.back.trgctclist.edit');
        }

        return view('livewire.back.trgctclist.admin', [
            'links' => $links
        ]);
    }
}


