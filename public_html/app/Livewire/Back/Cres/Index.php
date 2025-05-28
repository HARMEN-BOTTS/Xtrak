<?php

namespace App\Livewire\Back\Cres;

use App\Models\Cre;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $candidate;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $cre;
    public $search = '';
    public $nbPaginate = 10;
    public $response;
    public $isUpdate = false;
    #[On('deletecre')]
    
    public function deleteCre($candidateId)
    {
        DB::beginTransaction();
        try {
            $cres = Cre::where('candidate_id', $candidateId);
            if ($cres->exists()) {
                $cres->delete();
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'Les C.R.E sont supprimés avec succès');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer les C.R.E pour le candidat $candidateId");
        }
    }
    public function confirmDelete( $candidateId)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer la reponse", type: 'warning', method: 'deletecre', id: $candidateId);
    }
    public function searchFiles()
    {
        return $this->candidate
            ->cres()
            ->where('response', 'like', '%' . $this->search . '%')
            ->paginate($this->nbPaginate);
    }
    public function openModal($id = null)
    {
        $this->response = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->cre = Cre::find($id);
            $this->response = $this->cre->name ?? '';
        }
    }
    public function storeData()
    {
        $validateData = $this->validate(
            [
                'response' => 'required|string|max:255',
            ],
            [
                'response.required' => 'La réponse est obligatoire',
            ],
        );
        try {
            DB::beginTransaction();

            if ($this->isUpdate) {
                $this->cre->update($validateData);
            } else {
                Cre::create($validateData);
            }
            DB::commit();
            $this->dispatch('close:modal');
            $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'la réponse est modifié avec success' : 'Le C.R.E est ajouté avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier la réponse' : 'Impossible d\'ajouter Le C.R.E');
        }
    }
    public function goToCre($id)
    {
        return redirect()->route('candidate.cre',$id);
    }
    public function render()
    {
        return view('livewire.back.cres.index')->with([
            'cres' => $this->searchFiles(),
        ]);
    }
}
