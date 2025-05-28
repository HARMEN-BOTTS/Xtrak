<?php

namespace App\Livewire\Back\Candidates;

use App\Models\Civ;
use App\Models\Cre;
use App\Models\File;
use App\Models\Field;
use App\Helpers\Helper;
use Livewire\Component;
use App\Models\Compagny;
use App\Models\NextStep;
use App\Models\Position;
use App\Models\Candidate;
use App\Models\Speciality;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\Disponibility;
use Livewire\WithFileUploads;
use App\Models\CandidateState;
use App\Models\CandidateStatut;
use App\Models\NsDate;
use Illuminate\Support\Facades\DB;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CandidateRepository;

class Form extends Component
{
    use WithFileUploads;
    
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
    public $candidate;
    public $created_by;
    public $autorizeAddCandidate = true;
    public $action;
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
    public $step = 1;
    public $files;
    public $isUpdateFile = false;
    public $name;
    public $newFile;
    public $file;
    public $fileType;
    public $cre;
    public $response1;
    public $response2;
    public $response3;
    public $response4;
    public $response5;
    public $response6;
    public $response7;
    public $response8;
    public $response9;
    public $isUpdateCre = false;
    public $isUpdateCandidate = false;
    #[On('deleteFile')]
    public function deleteFile($id)
    {
        try {
            $fileRepository = new FileRepository();
            DB::beginTransaction();
            $file = $fileRepository->find($id);

            if ($file) {
                $fileRepository->delete($file->id);
            }
            $this->files = $this->candidate->files;
            $stateId = CandidateState::where('name', 'Attente')->first()->id;
            if ($this->candidate->files()->exists()) {
                $cvFile = $this->candidate->files()->where('file_type', 'cv')->first();
                if (!$cvFile && $stateId) {
                    $this->candidate->update([
                        'certificate' => null,
                        'candidate_state_id' => $stateId,
                    ]);
                }
            } else {
                if ($stateId) {
                    $this->candidate->update([
                        'certificate' => null,
                        'candidate_state_id' => $stateId,
                    ]);
                }
            }
            DB::commit();
            $this->dispatch('alert', type: 'success', message: 'le document est supprimé avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer le document $file->name");
        }
    }

    public function confirmDeleteFile($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer le document  $nom", type: 'warning', method: 'deleteFile', id: $id);
    }
    public function mount()
    {
        $this->candidateStatuses = CandidateStatut::all();
        $this->nextSteps = NextStep::all();
        $this->nsDates = NsDate::all();
        $this->civs = Civ::all();
        $this->disponibilities = Disponibility::all();
        $this->positions = Position::orderBy('name', 'asc')->get();
        $this->compagnies = Compagny::orderBy('name', 'asc')->get();
        if ($this->candidate && $this->candidate->exists) {
            $this->civ_id = $this->candidate->civ_id ?? null;
            $this->first_name = $this->candidate->first_name;
            $this->last_name = $this->candidate->last_name;
            $this->email = $this->candidate->email;
            $this->phone = $this->candidate->phone;
            $this->compagny_id = $this->candidate->compagny->name ?? '';
            $this->postal_code = $this->candidate->postal_code;
            $this->candidate_statut_id = $this->candidate->candidateStatut->id ?? null;
            $this->position_id = $this->candidate->position_id ?? null;
            $this->city = $this->candidate->city;
            $this->address = $this->candidate->address;
            $this->region = $this->candidate->region;
            $this->country = $this->candidate->country;
            $this->disponibility_id = $this->candidate->disponibility_id ?? null;
            $this->next_step_id = $this->candidate->next_step_id ?? null;
            $this->url_ctc = $this->candidate->url_ctc;
            $this->speciality_id = $this->candidate->speciality_id ?? null;
            $this->field_id = $this->candidate->field_id ?? null;
            $this->commentaire = $this->candidate->commentaire;
            $this->description = $this->candidate->description;
            $this->suivi = $this->candidate->suivi;
            $this->origine = $this->candidate->origine;
            $this->ns_date_id = $this->candidate->ns_date_id ?? null;
            $this->files = $this->candidate->files;
            $this->files = $this->candidate->files;
        }
    }

    public function updated($field)
    {
        $this->checkExistingCandidate();
    }
    public function checkExistingCandidate()
    {
        if (!empty($this->email)) {
            $existingCandidate = Candidate::when($this->first_name, function ($query) {
                $query->where('first_name', $this->first_name);
            })
                ->when($this->email, function ($query) {
                    $query->where('email', $this->email);
                })
                ->where('last_name', $this->last_name)
                ->exists();

            if ($existingCandidate) {
                $this->autorizeAddCandidate = false;
                if (!empty($this->first_name)) {
                    $this->addError('first_name', 'Candidat déja enregistré.');
                }
                if (!empty($this->last_name)) {
                    $this->addError('last_name', 'Candidat déja enregistré.');
                }
                if (!empty($this->email)) {
                    $this->addError('email', 'Candidat déja enregistré.');
                }
            } else {
                $this->autorizeAddCandidate = true;
                $this->resetErrorBag(['first_name', 'last_name', 'email']);
            }
        }
    }
    public function storeCandidateData()
    {
        $validatedData = $this->validate(
            [
                'civ_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => $this->action == 'create' ? 'required|email|unique:candidates,email' : 'required|email',
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
                'civ_id.required' => 'La civilité est obligatoire',
                'position_id.required' => 'Le poste est obligatoire',
                'email.unique' => 'Cet email est déjà utilisé',
            ],
        );

        DB::beginTransaction();
        $candidateRepository = new CandidateRepository();
        $fileRepository = new FileRepository();
        if ($validatedData['compagny_id']) {
            $companyName = $validatedData['compagny_id'];
            $company = Compagny::firstOrCreate(['name' => $companyName]);
            $validatedData['compagny_id'] = $company->id;
        } else {
            $validatedData['compagny_id'] = null;
        }
        if ($this->action == 'create') {
            $stateId = CandidateState::where('name', 'Attente')->first()->id;
            $validatedData['candidate_state_id'] = $stateId;
            $validatedData['created_by'] = auth()->user()->id;
            $stringToHash = $validatedData['first_name'] . $validatedData['last_name'] . now();
            $hash = Hash::make($stringToHash);
            $validatedData['code_cdt'] = Str::limit(preg_replace('/[^a-zA-Z0-9]/', '', $hash), 7, '');
            $this->candidate = $candidateRepository->create($validatedData);
        } else {
            $this->candidate = $candidateRepository->update($this->candidate->id, $validatedData);
        }

        DB::commit();
        $this->reset(['origine', 'commentaire','speciality_id', 'field_id', 'civ_id', 'first_name', 'last_name', 'email', 'phone', 'compagny_id', 'postal_code', 'candidate_statut_id', 'position_id', 'city', 'address', 'region', 'country', 'disponibility_id', 'url_ctc']);
        $this->step = 2;
        $this->dispatch('alert', type: 'success', message: $this->action == 'create' ? 'Le candidat a été enregistré avec succès.' : 'Le candidat a été modifié avec succès.');
        try {
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->action == 'create' ? 'Erreur lors de la création du candidat' : 'Erreur lors de la modification du candidat');
        }
    }
    public function storeCandidateData2()
    {
        $validatedData = $this->validate(
            [
                'civ_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => $this->action == 'create' ? 'required|email|unique:candidates,email' : 'required|email',
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
                'civ_id.required' => 'La civilité est obligatoire',
                'position_id.required' => 'Le poste est obligatoire',
                'email.unique' => 'Cet email est déjà utilisé',
            ],
        );

        DB::beginTransaction();
        $candidateRepository = new CandidateRepository();
        $fileRepository = new FileRepository();
        if ($validatedData['compagny_id']) {
            $companyName = $validatedData['compagny_id'];
            $company = Compagny::firstOrCreate(['name' => $companyName]);
            $validatedData['compagny_id'] = $company->id;
        } else {
            $validatedData['compagny_id'] = null;
        }
        if ($this->action == 'create') {
            $stateId = CandidateState::where('name', 'Attente')->first()->id;
            $validatedData['candidate_state_id'] = $stateId;
            $validatedData['created_by'] = auth()->user()->id;
            $stringToHash = $validatedData['first_name'] . $validatedData['last_name'] . now();
            $hash = Hash::make($stringToHash);
            $validatedData['code_cdt'] = Str::limit(preg_replace('/[^a-zA-Z0-9]/', '', $hash), 7, '');
            $this->candidate = $candidateRepository->create($validatedData);
        } else {
            $this->candidate = $candidateRepository->update($this->candidate->id, $validatedData);
        }

        DB::commit();
        $this->reset(['origine', 'commentaire', 'description','suivi','speciality_id', 'field_id', 'civ_id', 'first_name', 'last_name', 'email', 'phone', 'compagny_id', 'postal_code', 'candidate_statut_id', 'position_id', 'city', 'address', 'region', 'country', 'disponibility_id', 'url_ctc']);
        // $this->step = 2;
        $this->dispatch('alert', type: 'success', message: $this->action == 'create' ? 'Le candidat a été enregistré avec succès.' : 'Le candidat a été modifié avec succès.');
        try {
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->action == 'create' ? 'Erreur lors de la création du candidat' : 'Erreur lors de la modification du candidat');
        }
    }

    public function openFileModal($id = null)
    {
        $this->name = '';
        $this->isUpdateFile = false;
        $this->newFile = null;
        $this->fileType = '';
        if ($id) {
            $this->isUpdateFile = true;
            $this->file = File::find($id);
            $this->name = $this->file->name ?? '';
            $this->fileType = $this->file->file_type ?? '';
        }
    }
    public function storeFile()
    {
        $validateData = $this->validate(
            [
                'name' => 'nullable|string|max:255',
                'newFile' => 'nullable|file|mimes:pdf,doc,docx|max:2024',
                'fileType' => 'required|string',
            ],
            [
                'newFile.mimes' => 'Le fichier doit être de type: pdf, doc, docx',
                'newFile.max' => 'Le fichier ne doit pas dépasser 2Mo',
                'fileType.required' => 'Le type de fichier est obligatoire',
            ],
        );
        $fileRepository = new FileRepository();
        try {
            DB::beginTransaction();
            if ($this->isUpdateFile) {
                $fileRepository->update($this->file, ['name' => $validateData['name'], 'file_type' => $validateData['fileType']]);
            } else {
                if ($this->candidate->files()->exists()) {
                    $cvFile = $this->candidate->files()->where('file_type', 'cv')->first();
                    if ($cvFile && $validateData['fileType'] == 'cv') {
                        $this->dispatch('swal:modal', type: 'error', title: 'Action refusée', text: 'Impossible d\'ajouter un autre Cv');
                        return;
                    }
                    $coverLetterFile = $this->candidate->files()->where('file_type', 'cover letter')->first();
                    if ($coverLetterFile && $validateData['fileType'] == 'cover letter') {
                        $this->dispatch('swal:modal', type: 'error', title: 'Action refusée', text: 'Impossible d\'ajouter une autre lettre de motivation');
                        return;
                    }
                }
                $fileRepository->createOne($validateData['newFile'], $this->candidate->id, $validateData['fileType']);
                if ($this->candidate->files()->exists()) {
                    $stateId = CandidateState::where('name', 'Certifié')->first()->id;
                    $cvFile = $this->candidate->files()->where('file_type', 'cv')->first();
                    $additionalFieldsFilled = $this->candidate->first_name && $this->candidate->last_name && $this->candidate->civ_id && $this->candidate->email && $this->candidate->position_id;
                    if ($cvFile && $stateId && $additionalFieldsFilled) {
                        $certificate = Helper::generateCandidateCertificate();
                        $this->candidate->update([
                            'certificate' => $certificate,
                            'candidate_state_id' => $stateId,
                        ]);
                    }
                }
            }
            DB::commit();
            $this->files = $this->candidate->files;
            $this->reset('name', 'newFile', 'fileType');
            $this->dispatch('close:modal');
            $this->dispatch('alert', type: 'success', message: $this->isUpdateFile ? 'le nom est modifié avec success' : 'le document est ajouté avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdateFile ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter le document');
        }
    }
    public function updateCandidateState()
    {
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
      
    }
    public function storeCre()
    {
        $questions = [
            1 => ' Statut professionnel',
            2 => 'Statut personnel',
            3 => 'Situation professionnelle',
            4 => 'Points incontournables',
            5 => 'Savoir-être du candidat',
            6 => 'Prise de référence(s)', 
            7 => 'Prétentions salariales',
            8 => 'Disponibilités candidat',
            9 => 'Résumé du parcours professionnel',
        ];

        $validatedData = $this->validate([
            'response1' => 'nullable',
            'response2' => 'nullable',
            'response3' => 'nullable',
            'response4' => 'nullable',
            'response5' => 'nullable',
            'response6' => 'nullable',
            'response7' => 'nullable',
            'response8' => 'nullable',
            'response9' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            foreach ($validatedData as $key => $value) {
                $number = substr($key, strlen('response'));
                Cre::create([
                    'response' => $value,
                    'number' => $number,
                    'candidate_id' => $this->candidate->id,
                    'question' => $questions[$number],
                ]);
            }
            $this->candidate->update([
                'cre_ref' => 'CRE' . rand(1, 99999),
                'cre_created_at' => now(),
            ]);
            $this->updateCandidateState();
            DB::commit();
            return redirect()
                ->route('candidates.show', $this->candidate->id)
                ->with('success', 'Le candidat a été enregistré avec succès.');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->action == 'create' ? 'Erreur lors de la création du c.r.e' : 'Erreur lors de la modification du c.r.e');
        }
    }
    
    public function endCreate()
    {
        $this->updateCandidateState();
        return redirect()
            ->route('candidates.show', $this->candidate->id)
            ->with('success', 'Le candidat a été enregistré avec succès.');
    }
    public function goToCre()
    {
        $this->step = 3;
    }
    public function goToForm()
    {
        $this->candidateStatuses = CandidateStatut::all();
        $this->nextSteps = NextStep::all();
        $this->nsDates = NsDate::all();
        $this->civs = Civ::all();
        $this->disponibilities = Disponibility::all();
        $this->positions = Position::orderBy('name', 'asc')->get();
        $this->compagnies = Compagny::orderBy('name', 'asc')->get();
        if ($this->candidate && $this->candidate->exists) {
            $this->civ_id = $this->candidate->civ_id ?? null;
            $this->first_name = $this->candidate->first_name;
            $this->last_name = $this->candidate->last_name;
            $this->email = $this->candidate->email;
            $this->phone = $this->candidate->phone;
            $this->compagny_id = $this->candidate->compagny->name ?? '';
            $this->postal_code = $this->candidate->postal_code;
            $this->candidate_statut_id = $this->candidate->candidateStatut->id ?? null;
            $this->position_id = $this->candidate->position_id ?? null;
            $this->city = $this->candidate->city;
            $this->address = $this->candidate->address;
            $this->region = $this->candidate->region;
            $this->country = $this->candidate->country;
            $this->disponibility_id = $this->candidate->disponibility_id ?? null;
            $this->next_step_id = $this->candidate->next_step_id ?? null;
            $this->url_ctc = $this->candidate->url_ctc;
            $this->speciality_id = $this->candidate->speciality_id ?? null;
            $this->field_id = $this->candidate->field_id ?? null;
            $this->commentaire = $this->candidate->commentaire;
            $this->description = $this->candidate->description;
            $this->suivi = $this->candidate->suivi;
            $this->origine = $this->candidate->origine;
            $this->ns_date_id = $this->candidate->ns_date_id ?? null;
            $this->files = $this->candidate->files;
            $this->action = 'update';
        }
        $this->step = 1;
    }
    public function goToDoc()
    {
        $this->step = 2;
    }

    public function resetForm()
    {
        $this->reset(['next_step_id', 'ns_date_id', 'origine', 'commentaire','description','suivi','speciality_id', 'field_id', 'civ_id', 'first_name', 'last_name', 'email', 'phone', 'compagny_id', 'postal_code', 'candidate_statut_id', 'position_id', 'city', 'address', 'region', 'country', 'disponibility_id', 'url_ctc']);
    }
    public function updatedPositionId($value)
    {
        $this->specialities = Position::find($value)->specialities;
    }
    public $new_position;

public function createPosition()
{
    $position = Position::create(['name' => $this->new_position]);
    $this->position_id = $position->id;
    $this->new_position = '';
}
    public function updatedSpecialityId($value)
    {
        $this->fields = Speciality::find($value)->fields;
    }
    public function render()
    {
        return view('livewire.back.candidates.form');
    }
}