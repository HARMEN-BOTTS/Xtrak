<?php

namespace App\Livewire\Back\Mcpdstlist;

use Livewire\Component;
use App\Models\McpTrgLink;
use App\Models\Trgdashboard;
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
        $this->datas = McpTrgLink::latest()->get();
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

        McpTrgLink::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        // session()->flash('message', 'Data Deleted Successfully 🛑');
        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    }



    public function editRow($id)
    {
        $this->editId = $id;
        $link = McpTrgLink::with(['opportunity', 'candidate'])->find($id);

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

        $link = Trgdashboard::where('trg_code', $candidateData['trg_code'])->first();
        if ($link) {
            $link->update([
                'creation_date' => $candidateData['creation_date'] ?? null,
                'auth' => $candidateData['auth'] ?? null,
                'company' => $candidateData['company'] ?? null,
                'standard_phone' => $candidateData['standard_phone'] ?? null,
                'website_url' => $candidateData['website_url'] ?? null,
                'trg_code' => $candidateData['trg_code'] ?? null,
                'address' => $candidateData['address'] ?? null,
                'address_one' => $candidateData['address_one'] ?? null,
                'postal_code_department' => $candidateData['postal_code_department'] ?? null,
                'region' => $candidateData['region'] ?? null,
                'town' => $candidateData['town'] ?? null,
                'country' => $candidateData['country'] ?? null,
                'ca_k' => $candidateData['ca_k'] ?? null,
                'employees' => $candidateData['employees'] ?? null,
                'activity' => $candidateData['activity'] ?? null,
                'type' => $candidateData['type'] ?? null,
                'siret' => $candidateData['siret'] ?? null,
                'rcs' => $candidateData['rcs'] ?? null,
                'filiation' => $candidateData['filiation'] ?? null,
                'off' => $candidateData['off'] ?? null,
                'legal_form' => $candidateData['legal_form'] ?? null,
                'vat_number' => $candidateData['vat_number'] ?? null,
                'trg_status' => $candidateData['trg_status'] ?? null,
                'remarks' => $candidateData['remarks'] ?? null,
                'notes' => $candidateData['notes'] ?? null,
                'last_modification_date' => $candidateData['last_modification_date'] ?? null,
                'priority' => $candidateData['priority'] ?? null,

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



    public function deleteTrgLink($linkId)
    {
        McpTrgLink::find($linkId)->delete();
        // session()->flash('message', 'Link removed successfully ✅');
        $this->dispatch('alert', type: 'success', message: "Link removed successfully");
    }

    public function render()
    {
        $query = McpTrgLink::with(['opportunity', 'candidate']);


        if (request()->has('selectedRows')) {
            $selectedRows = request()->get('selectedRows');
            $query->whereIn('mcp_id', $selectedRows);
        }

        $links = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($this->isEditing) {
            return view('livewire.back.mcpdstlist.edit');
        }

        return view('livewire.back.mcpdstlist.admin', [
            'links' => $links
        ]);
    }
}
