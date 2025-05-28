<?php

namespace App\Livewire\Back\Candidates;

use App\Models\Civ;
use App\Models\Field;
use App\Models\NsDate;
use App\Helpers\Helper;
use Livewire\Component;
use App\Models\Compagny;
use App\Models\NextStep;
use App\Models\Position;
use App\Models\Speciality;
use Livewire\Attributes\On;
use App\Models\Disponibility;
use App\Models\CandidateState;
use App\Models\CandidateStatut;
use Illuminate\Support\Facades\DB;
use App\Repositories\CandidateRepository;

class Show extends Component
{
    public $candidate;
    public $candidateStates;
    public $candidate_state_id;
    public $civs;
    public $civ_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $phone_2;
    public $compagny_id;
    public $postal_code;
    public $candidate_statut_id;
    public $position_id;
    public $positions;
    public $created_by;
    public $city;
    public $address;
    public $region;
    public $country;
    public $disponibilities;
    public $disponibility_id;
    public $url_ctc;
    public $specialities;
    public $speciality_id;
    public $fields;
    public $field_id;
    public $compagnies;
    public $commentaire;
    public $description;
    public $suivi;
    public $origine;
    public $nextSteps;
    public $next_step_id;
    public $ns_date_id;
    public $nsDates;

    public $candidateStatuses;
    #[On('deleteCandidate')]
    public function deleteData($id)
    {
        try {
            $candidateRepository = new CandidateRepository();
            DB::beginTransaction();
            $candidate = $candidateRepository->find($id);
            if ($candidate->candidateState->name == 'Certifié') {
                $this->dispatch('swal:modal', type: 'error', title: 'Ce candidat est certifié', text: 'Impossible de supprimer un candidat certifié');
                return;
            }
            $candidateRepository->delete($candidate->id);
            DB::commit();
            $this->dispatch('goBack');
            // return redirect()->route('candidates.index')->with('success', 'le candidat est supprimé avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de modifier l'état du candidat sans Cv$candidate->first_name. $candidate->laste_name");
        }
    }
    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de modifier l'état du candidat sans Cv$nom", type: 'warning', method: 'deleteCandidate', id: $id);
    }
    #[On('showsuccess')]
    public function showSuccess($candidate)
    {
        $this->dispatch('alert', type: 'error', message: 'Erreur lors de la modification du candidat');
    }
    public function mount()
    {
        $this->candidateStates = CandidateState::all();
        $this->candidateStatuses = CandidateStatut::all();
        $this->candidate_state_id = $this->candidate->candidateState->id ?? '';
        $this->nextSteps = NextStep::all();
        $this->nsDates = NsDate::all();
        $this->civs = Civ::all();
        $this->disponibilities = Disponibility::all();
        $this->positions = Position::orderBy('name', 'asc')->get();
        $this->compagnies = Compagny::orderBy('name', 'asc')->get();
        if ($this->candidate && $this->candidate->exists) {
            $this->civ_id = $this->candidate->civ->id ?? null;
            $this->first_name = $this->candidate->first_name;
            $this->last_name = $this->candidate->last_name;
            $this->email = $this->candidate->email;
            $this->phone = $this->candidate->phone;
            $this->compagny_id = $this->candidate->compagny->name ?? '';
            $this->postal_code = $this->candidate->postal_code;
            $this->candidate_statut_id = $this->candidate->candidateStatut->id ?? null;
            $this->position_id = $this->candidate->position->id ?? null;
            $this->city = $this->candidate->city;
            $this->address = $this->candidate->address;
            $this->region = $this->candidate->region;
            $this->country = $this->candidate->country;
            $this->disponibility_id = $this->candidate->disponibility->id ?? null;
            $this->next_step_id = $this->candidate->nextStep->id ?? null;
            $this->url_ctc = $this->candidate->url_ctc;
            $this->speciality_id = $this->candidate->speciality_id ?? null;
            $this->field_id = $this->candidate->field_id ?? null;
            $this->commentaire = $this->candidate->commentaire;
            $this->description = $this->candidate->description;
            $this->suivi = $this->candidate->suivi;
            $this->origine = $this->candidate->origine;
            $this->ns_date_id = $this->candidate->ns_date_id;
            $this->specialities = $this->candidate->position->specialities ?? null;
            $this->fields = $this->candidate->speciality->fields ?? null;
        }
    }
    public function storeData()
{
    $validatedData = $this->validate(
        [
            'civ_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'compagny_id' => 'nullable',
            'postal_code' => 'nullable',
            'candidate_statut_id' => 'nullable',
            'position_id' => 'required',
            'city' => 'nullable',
            'address' => 'nullable',
            'region' => 'nullable',
            'country' => 'nullable',
            'disponibility_id' => 'nullable',
            'url_ctc' => 'nullable',
            'speciality_id' => 'nullable',
            'field_id' => 'nullable',
            'phone_2' => 'nullable',
            'commentaire' => 'nullable',
            'description' => 'nullable',
            'suivi' => 'nullable',
            'origine' => 'nullable',
            'ns_date_id' => 'nullable',
            'next_step_id' => 'nullable',
        ],
        [
            'first_name.required' => 'Le prénom est obligatoire',
            'last_name.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être une adresse email valide',
            'position_id.required' => 'Le poste est obligatoire',
            'civ_id.required' => 'La civilité est obligatoire',
        ],
    );

    try {
        DB::beginTransaction();

        // Vérifiez et ajoutez la position si elle n'existe pas
        if ($validatedData['position_id']) {
            $positionName = $validatedData['position_id'];
            $position = Position::firstOrCreate(['name' => $positionName]);
            $validatedData['position_id'] = $position->id;
        }

        if ($validatedData['compagny_id']) {
            $companyName = $validatedData['compagny_id'];
            $company = Compagny::firstOrCreate(['name' => $companyName]);
            $validatedData['compagny_id'] = $company->id;
        } else {
            $validatedData['compagny_id'] = null;
        }

        $candidateRepository = new CandidateRepository();
        if ($this->candidate) {
            $this->candidate = $candidateRepository->update($this->candidate->id, $validatedData);
        } else {
            $this->candidate = $candidateRepository->create($validatedData);
        }

        $stateId = CandidateState::where('name', 'Certifié')->first()->id;
        if ($stateId != $this->candidate->candidate_state_id && $this->candidate->files()->exists()) {
            $cvFile = $this->candidate->files()->where('file_type', 'cv')->first();
            $additionalFieldsFilled = $this->candidate->first_name && $this->candidate->last_name && $this->candidate->civ_id && $this->candidate->email && $this->candidate->position_id;
            if ($cvFile && $additionalFieldsFilled) {
                $certificate = Helper::generateCandidateCertificate();
                $this->candidate->update([
                    'certificate' => $certificate,
                    'candidate_state_id' => $stateId,
                ]);
            }
        }

        DB::commit();
        $this->mount();
        $this->dispatch('alert', type: 'success', message: 'Candidat enregistré ou modifié avec succès');
    } catch (\Throwable $th) {
        DB::rollBack();
        $this->dispatch('alert', type: 'error', message: 'Erreur lors de la modification ou de la création du candidat');
    }
}

    
    public function updatedPositionId($value)
    {
        // $this->specialities = Position::find($value)->specialities;
        // Récupérer la position par son ID
    $position = Position::find($value);
    
    // Vérifier si la position existe
    if ($position) {
        $this->specialities = $position->specialities;
    } else {
        // Réinitialiser les spécialités si la position n'existe pas
        $this->specialities = [];
    }
    
    }
    public function updatedSpecialityId($value)
    {
        $this->fields = Speciality::find($value)->fields;
    }
    public function render()
    {
        return view('livewire.back.candidates.show');
    }
    public function updatedCandidateStateId($id)
    {
        try {
            DB::beginTransaction();
            $state = CandidateState::where('id', $id)->first() ?? null;
            $additionalFieldsFilled = $this->candidate->first_name && $this->candidate->last_name && $this->candidate->civ_id && $this->candidate->email && $this->candidate->position_id;
            if ($state && $this->candidate->files()->exists() && $additionalFieldsFilled && $state->name == 'Certifié' ) {
                $cvFile = $this->candidate->files()->where('file_type', 'cv')->first();
                if ($cvFile ) {
                    $certificate = Helper::generateCandidateCertificate();
                    $this->candidate->update([
                        'certificate' => $certificate,
                        'candidate_state_id' => $state->id,
                    ]);
                } else {
                    return $this->dispatch('swal:confirm-modif', title: 'Modification', text: "Vous êtes sur le point de modifier l'état du candidat alors qu'il n'a pas de CV ou que certains champs obligatoires sont manquants.", type: 'warning', method: 'updateState', id: $id);
                }
            } else {
                return $this->dispatch('swal:confirm-modif', title: 'Modification', text: "Vous êtes sur le point de modifier l'état du candidat.", type: 'warning', method: 'updateState', id: $id);
            }
            $this->dispatch('alert', type: 'success', message: 'Etat modifier avec succès');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: 'Erreur lors de la modification de l\'état du candidat');
        }
    }
    public function goToCv($candidateId)
    {
        return redirect()->route('candidate.cv', ['candidate' => $candidateId]);
    }
    #[On('updateState')]
    public function updateState($id)
    {
        try {
            DB::beginTransaction();
            $state = CandidateState::where('id', $id)->first() ?? null;
            $this->candidate->update([
                'certificate' => '',
                'candidate_state_id' => $state->id,
            ]);
            $this->dispatch('alert', type: 'success', message: 'Etat modifier avec succès');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: 'Erreur lors de la modification de l\'état du candidat');
        }
    }
}