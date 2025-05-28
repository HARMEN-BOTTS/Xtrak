<?php

namespace App\Livewire\Back\Civs;

use App\Models\Civ;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $civ;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;
    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $civ = Civ::find($id);
        try {
            if ($civ) {
                $civ->delete($civ->id);
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'la civilité est supprimé avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer la civilité $civ->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer la civilité $nom", type: 'warning', method: 'delete', id: $id);
    }
    public function searchFiles()
    {
        return Civ::where('name', 'like', '%' . $this->search . '%')->paginate($this->nbPaginate);
    }
    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->civ = Civ::find($id);
            $this->name = $this->civ->name ?? '';
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
            $this->civ->update($validateData);
        } else {
            Civ::create($validateData);
        }
        DB::commit();
        $this->dispatch('close:modal');
        $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'la civilité est ajouté avec succès');
       
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter la civilité');
        }
    }
    public function render()
    {
        return view('livewire.back.civs.index')->with([
            'civs' => $this->searchFiles(),
        ]);
    }
}
