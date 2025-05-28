<?php

namespace App\Livewire\Back\Compagnies;

use App\Models\Compagny;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $compagny;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;
    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $compagny = Compagny::find($id);
        try {
            if ($compagny) {
                $compagny->delete($compagny->id);
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'la compagnie est supprimé avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer la compagnie $compagny->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer la compagnie $nom", type: 'warning', method: 'delete', id: $id);
    }
    public function searchFiles()
    {
        return Compagny::where('name', 'like', '%' . $this->search . '%')->paginate($this->nbPaginate);
    }
    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->compagny = Compagny::find($id);
            $this->name = $this->compagny->name ?? '';
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
            $this->compagny->update($validateData);
        } else {
            Compagny::create($validateData);
        }
        DB::commit();
        $this->dispatch('close:modal');
        $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'la compagnie est ajouté avec succès');
      
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter la compagnie');
        }
    }
    public function render()
    {
        return view('livewire.back.compagnies.index')->with([
            'compagnies' => $this->searchFiles(),
        ]);
    }
}
