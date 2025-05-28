<?php

namespace App\Livewire\Back\Files;

use App\Models\File;
use App\Helpers\Helper;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\CandidateState;
use Illuminate\Support\Facades\DB;
use App\Repositories\FileRepository;

class CandidateFile extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $candidate;
    public $search = '';
    public $nbPaginate = 5;
    public $name;
    public $newFile;
    public $isUpdate = false;
    public $file;
    public $fileType;
    #[On('delete')]
    public function deleteData($id)
    {
        try {
        $fileRepository = new FileRepository();
        DB::beginTransaction();
        $file = $fileRepository->find($id);
            if ($file) {
                $fileRepository->delete($file->id);
            }
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
            $this->dispatch('refresh-page');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer le document $file->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer le document  $nom", type: 'warning', method: 'delete', id: $id);
    }
    public function searchFiles()
    {
        return $this->candidate
            ->files()
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->nbPaginate);
    }
    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
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

            if ($this->isUpdate) {
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
                    $cvFile = $this->candidate->files()->where('file_type', 'cv')->first();
                    $stateId = CandidateState::where('name', 'Certifié')->first()->id;
                    $additionalFieldsFilled = $this->candidate->first_name && $this->candidate->last_name && $this->candidate->civ_id &&  $this->candidate->email && $this->candidate->position_id;  
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
            $this->reset('name', 'newFile', 'fileType');
            $this->dispatch('close:modal');
            $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'le document est ajouté avec succès');
            $this->dispatch('refresh-page');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter le document');
        }
    }
    public function downloadFile($path, $name)
    {
        $filePath = public_path('storage/' . $path);
        if (file_exists($filePath)) {
            return response()->download($filePath, $name);
        } else {
            session()->flash('message', 'Le fichier n\'existe pas.');
        }
    }
    public function goToCv($candidateId)
    {
        return redirect()->route('candidate.cv', ['candidate' => $candidateId]);
    }
    
    public function render()
    {
        return view('livewire.back.files.candidate-file')->with([
            'files' => $this->searchFiles(),
        ]);
    }
}
