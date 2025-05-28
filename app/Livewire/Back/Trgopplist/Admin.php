<?php

namespace App\Livewire\Back\Trgopplist;

use Livewire\Component;
use App\Models\TrgOppLink;
use App\Models\Oppdashboard;
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
        $this->datas = TrgOppLink::latest()->get();
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

        TrgOppLink::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        // session()->flash('message', 'Data Deleted Successfully 🛑');
        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    }



    public function editRow($id)
    {
        $this->editId = $id;
        $link = TrgOppLink::with(['opportunity', 'candidate'])->find($id);

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

        $link = Oppdashboard::where('opp_code', $candidateData['opp_code'])->first();
        if ($link) {
            $link->update([
                'opportunity_date' => $candidateData['opportunity_date'] ?? null,
                'opp_code' => $candidateData['opp_code'] ?? null,
                'auth' => $candidateData['auth'] ?? null,
                'trg_code' => $candidateData['trg_code'] ?? null,
                'name' => $candidateData['name'] ?? null,
                'postal_code_1' => $candidateData['postal_code_1'] ?? null,
                'site_city' => $candidateData['site_city'] ?? null,
                'ctc1_code' => $candidateData['ctc1_code'] ?? null,
                'civs' => $candidateData['civs'] ?? null,
                'ctc1_first_name' => $candidateData['ctc1_first_name'] ?? null,
                'ctc1_last_name' => $candidateData['ctc1_last_name'] ?? null,
                'position' => $candidateData['position'] ?? null,
                'remarks' => $candidateData['remarks'] ?? null,
                'job_titles' => $candidateData['job_titles'] ?? null,
                'specificities' => $candidateData['specificities'] ?? null,
                'domain' => $candidateData['domain'] ?? null,
                'postal_code' => $candidateData['postal_code'] ?? null,
                'town' => $candidateData['town'] ?? null,
                'country' => $candidateData['country'] ?? null,
                'experience' => $candidateData['experience'] ?? null,
                'schooling' => $candidateData['schooling'] ?? null,
                'schedules' => $candidateData['schedules'] ?? null,
                'mobility' => $candidateData['mobility'] ?? null,
                'permission' => $candidateData['permission'] ?? null,
                'type' => $candidateData['type'] ?? null,
                'vehicle' => $candidateData['vehicle'] ?? null,
                'job_offer_date' => $candidateData['job_offer_date'] ?? null,
                'skill_one' => $candidateData['skill_one'] ?? null,
                'skill_two' => $candidateData['skill_two'] ?? null,
                'skill_three' => $candidateData['skill_three'] ?? null,
                'other_one' => $candidateData['other_one'] ?? null,
                'remarks_two' => $candidateData['remarks_two'] ?? null,
                'job_start_date' => $candidateData['job_start_date'] ?? null,
                'invoice_date' => $candidateData['invoice_date'] ?? null,
                'gross_salary' => $candidateData['gross_salary'] ?? null,
                'bonus_1' => $candidateData['bonus_1'] ?? null,
                'bonus_2' => $candidateData['bonus_2'] ?? null,
                'bonus_3' => $candidateData['bonus_3'] ?? null,
                'other_two' => $candidateData['other_two'] ?? null,
                'date_emb' => $candidateData['date_emb'] ?? null,
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



    public function deleteOppLink($linkId)
    {
        TrgOppLink::find($linkId)->delete();
        // session()->flash('message', 'Link removed successfully ✅');
        $this->dispatch('alert', type: 'success', message: "Link removed successfully");
    }

    public function render()
    {
        $query = TrgOppLink::with(['opportunity', 'candidate']);


        if (request()->has('selectedRows')) {
            $selectedRows = request()->get('selectedRows');
            $query->whereIn('trg_id', $selectedRows);
        }

        $links = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($this->isEditing) {
            return view('livewire.back.trgopplist.edit');
        }

        return view('livewire.back.trgopplist.admin', [
            'links' => $links
        ]);
    }
}


