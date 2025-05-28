<?php

namespace App\Livewire\Back\Candidates\Import;

use Livewire\Component;
use App\Models\ImportLog;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Jobs\ImportCandidatesJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class Index extends Component
{
    use WithFileUploads;
    public $fileData;
    public $rejected = [];
    public $accepted = [];
    #[On('data-from-import')]
    public function dataFromImport($accepted, $rejected)
    {
        $this->accepted = $accepted;
        $this->rejected = $rejected;
    }
    public function storeFileData()
    {
        $validateData = $this->validate(
            [
                'fileData' => 'required|mimes:xls,xlsx',
            ],
            [
                'fileData.required' => 'Le fichier est obligatoire',
                'fileData.mimes' => 'Le fichier doit être un fichier excel',
            ],
        );
        $path = Storage::putFile('/public/files', $validateData['fileData']);
        $filepath = Storage::path($path);
        if (file_exists($filepath)) {
            // try {
                $user = Auth::user();
                ImportCandidatesJob::dispatch($filepath, $user->id);
                $result = ImportLog::where('file_path', $filepath)
                    ->where('user_id', $user->id)
                    ->first();
                if ($result) {
                    $accepted = json_decode($result->accepted, true);
                    $rejected = json_decode($result->rejected, true);
                    $this->dispatch('data-from-import', accepted: $accepted, rejected: $rejected);
                }
                $this->dispatch('alert', type: 'success', message: 'Opération reusie avec succès');
            // } catch (\Exception $e) {
            //     $this->dispatch('alert', type: 'error', message: 'Une erreure est survenu, merci de réessayez');
            // }
        } else {
            $this->dispatch('alert', type: 'error', message: 'Le fichier n\'existe pas');
        }

        $this->reset(['fileData']);
    }
    public function downloadFile()
    {
        $filePath = public_path('storage/files/caneva.xlsx');

        if (file_exists($filePath)) {
            return response()->download($filePath, 'caneva.xlsx');
        } else {
            $this->dispatch('alert', type: 'error', message: 'Le fichier n\'existe pas');
        }
    }
    public function mount()
    {
        $this->fileData = '';
    }
    public function render()
    {
        return view('livewire.back.candidates.import.index');
    }
}
