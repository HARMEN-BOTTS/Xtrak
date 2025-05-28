<?php

namespace App\Livewire\Back\Nsdate;

use App\Models\NsDate;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nsDate;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;

    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $nsDate = NsDate::find($id);
        try {
            if ($nsDate) {
                $nsDate->delete($nsDate->id);
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'NsDate est supprimé avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer NsDate $nsDate->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer NsDate $nom", type: 'warning', method: 'delete', id: $id);
    }

    public function searchFiles()
    {
        return NsDate::where('name', 'like', '%' . $this->search . '%')->paginate($this->nbPaginate);
    }

    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->nsDate = NsDate::find($id);
            $this->name = $this->nsDate->name ?? '';
        }

        $this->dispatch('openModal');
    }

    public function storeData()
    {
        $validateData = $this->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Le nom est obligatoire',
            ],
        );
        try {
            DB::beginTransaction();

            if ($this->isUpdate) {
                $this->nsDate->update($validateData);
            } else {
                NsDate::create($validateData);
            }
            DB::commit();
            $this->dispatch('close:modal');
            $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'NsDate est ajouté avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter NsDate');
        }
    }

    public function render()
    {
        return view('livewire.back.nsdate.index')->with([
            'nsDates' => $this->searchFiles(),
        ]);
    }
}
