<?php

namespace App\Livewire\Back\States;

use App\Models\CandidateState;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $state;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;
    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $state = CandidateState::find($id);
        try {
            if ($state) {
                $state->delete($state->id);
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'l\'état est supprimé avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer l'état $state->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer l'état $nom", type: 'warning', method: 'delete', id: $id);
    }
    public function searchFiles()
    {
        return CandidateState::where('name', 'like', '%' . $this->search . '%')->paginate($this->nbPaginate);
    }
    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->state = CandidateState::find($id);
            $this->name = $this->state->name ?? '';
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
            $this->state->update($validateData);
        } else {
            CandidateState::create($validateData);
        }
        DB::commit();
        $this->dispatch('close:modal');
        $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'l\'état est ajouté avec succès');
       
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter l\'état');
        }
    }
    public function render()
    {
        return view('livewire.back.states.index')->with([
            'candidateStates' => $this->searchFiles(),
        ]);
    }
}
