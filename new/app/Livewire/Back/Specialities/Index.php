<?php

namespace App\Livewire\Back\Specialities;

use App\Models\Position;
use App\Models\Speciality;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $speciality;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;
    public $position_id;
    public $positions;

    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $speciality = Speciality::find($id);
        try {
            if ($speciality) {
                $speciality->delete();
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'La spécialité est supprimée avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer la spécialité $speciality->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous êtes sur le point de supprimer la spécialité $nom", type: 'warning', method: 'delete', id: $id);
    }

    public function searchFiles()
    {
        return Speciality::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate($this->nbPaginate);
    }

    public function openModal($id = null)
    {
        $this->name = '';
        $this->position_id = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->speciality = Speciality::find($id);
            $this->name = $this->speciality->name ?? '';
            $this->position_id = $this->speciality->position_id ?? '';
        }
        $this->dispatch('open:modal');
    }

    public function storeData()
    {
        $validateData = $this->validate(
            [
                'name' => 'required|string|max:255',
                'position_id' => 'required'
            ],
            [
                'name.required' => 'Le nom est obligatoire',
                'position_id.required' => 'Le poste est obligatoire'
            ],
        );

        try {
            DB::beginTransaction();

            if ($this->isUpdate) {
                $this->speciality->update($validateData);
            } else {
                Speciality::create($validateData);
            }

            DB::commit();
            $this->dispatch('close:modal');
            $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'La spécialité est modifiée avec succès' : 'La spécialité est ajoutée avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: 'Impossible de traiter la demande');
        }

        $this->reset();
    }

    public function render()
    {
        $this->positions = Position::all();
        $specialities = $this->searchFiles();
        return view('livewire.back.specialities.index', compact('specialities'));
    }
}
