<?php

namespace App\Livewire\Back\Disponibilities;

use App\Models\Disponibility;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $disponibility;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;
    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $disponibility = Disponibility::find($id);
        try {
            if ($disponibility) {
                $disponibility->delete($disponibility->id);
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'la disponibilité est supprimé avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer la disponibilité $disponibility->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer la disponibilité $nom", type: 'warning', method: 'delete', id: $id);
    }
    public function searchFiles()
    {
        return Disponibility::where('name', 'like', '%' . $this->search . '%')->paginate($this->nbPaginate);
    }
    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->disponibility = Disponibility::find($id);
            $this->name = $this->disponibility->name ?? '';
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
            $this->disponibility->update($validateData);
        } else {
            Disponibility::create($validateData);
        }
        DB::commit();
        $this->dispatch('close:modal');
        $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'la disponibilité est ajouté avec succès');
       
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter la disponibilité');
        }
    }
    public function render()
    {
        return view('livewire.back.disponibilities.index')->with([
            'disponibilities' => $this->searchFiles(),
        ]);
    }
}
