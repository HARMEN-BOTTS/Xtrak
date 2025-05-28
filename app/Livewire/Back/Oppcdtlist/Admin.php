<?php

namespace App\Livewire\Back\Oppcdtlist;

use Livewire\Component;
use App\Models\OppCdtLink;
use App\Models\Candidate;
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
        $this->datas = OppCdtLink::latest()->get();
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

        OppCdtLink::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        // session()->flash('message', 'Data Deleted Successfully 🛑');
        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    
    }
    

    public function editRow($id)
    {
        $this->editId = $id;
        $link = OppCdtLink::with(['opportunity', 'candidate'])->find($id);

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

        $link = Candidate::where('code_cdt', $candidateData['code_cdt'])->first();
        if ($link) {
            $link->update([
               
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

    
    public function deleteCdtLink($linkId)
    {
        OppCdtLink::find($linkId)->delete();
        // session()->flash('message', 'Link removed successfully ✅');
        $this->dispatch('alert', type: 'success', message: "Link removed successfully");
    
    }
    
    public function render()
    {
        $query = OppCdtLink::with(['opportunity', 'candidate']);
      

        if (request()->has('selectedRows')) {
            $selectedRows = request()->get('selectedRows');
            $query->whereIn('opp_id', $selectedRows);
        }
        
        $links = $query->orderBy('created_at', 'desc')->paginate(10);

        
        if ($this->isEditing) {
            return view('livewire.back.oppcdtlist.edit');
        }
            
        return view('livewire.back.oppcdtlist.admin', [
            'links' => $links
        ]);
    }
}

