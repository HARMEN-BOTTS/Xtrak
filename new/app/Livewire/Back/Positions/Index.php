<?php

namespace App\Livewire\Back\Positions;

use App\Models\Position;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $position;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;
    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $position = Position::find($id);
        try {
            if ($position) {
                $position->delete($position->id);
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'le poste est supprimé avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer le poste $position->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer le poste $nom", type: 'warning', method: 'delete', id: $id);
    }
    public function searchFiles()
    {
        return Position::where('name', 'like', '%' . $this->search . '%')
        ->orderBy('created_at', 'desc') 
        ->paginate($this->nbPaginate);
    }
    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->position = Position::find($id);
            $this->name = $this->position->name ?? '';
        }
        $this->dispatch('open:modal'); 
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
            $this->position->update($validateData);
        } else {
            Position::create($validateData);
        }
        DB::commit();
        $this->dispatch('close:modal');
        $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'le poste est ajouté avec succès');
        $this->dispatch('refresh-page');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter le poste');
        }
    }
    public function render()
    {
        return view('livewire.back.positions.index')->with([
            'positions' => $this->searchFiles(),
        ]);
    }
}