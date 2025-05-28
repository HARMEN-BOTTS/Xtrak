<?php

namespace App\Livewire\Back\Nextstep;

use App\Models\NextStep;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nextstep;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;

    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $nextstep = NextStep::find($id);
        try {
            if ($nextstep) {
                $nextstep->delete($nextstep->id);
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'NextStep est supprimé avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer nextstep $nextstep->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer nextstep $nom", type: 'warning', method: 'delete', id: $id);
    }

    public function searchFiles()
    {
        return NextStep::where('name', 'like', '%' . $this->search . '%')->paginate($this->nbPaginate);
    }

    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->nextstep = NextStep::find($id);
            $this->name = $this->nextstep->name ?? '';
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
                $this->nextstep->update($validateData);
            } else {
                NextStep::create($validateData);
            }
            DB::commit();
            $this->dispatch('close:modal');
            $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'NextStep est ajouté avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter NextStep');
        }
    }

    public function render()
    {
        return view('livewire.back.nextstep.index')->with([
            'nextsteps' => $this->searchFiles(),
        ]);
    }
}

