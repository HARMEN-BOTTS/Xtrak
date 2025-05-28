<?php

namespace App\Livewire\Back\Dashboard;

use App\Models\User;
use App\Helpers\Helper;
use Livewire\Component;
use App\Models\Position;
use App\Models\Candidate;
use App\Models\CandidateState;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\CandidateStatut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CandidateRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class Trunc extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $company = '';
    public $position = '';
    public $cv = '';
    public $cre_ref = '';   
    public $nbPaginate = 100;
    public $candidate_statut_id = '';
    public $candidateStatuses;
    public $filterName = '';
    public $filterDate = '';
    public $candidate_state_id = '';
    public $selectedCandidateId;
    public $candidateStates;
    public $positions;
    public $position_id;
    public $users_id;
    public $users;
    public $cp;
    public $sortColumn = 'last_name';
    public $sortDirection = 'desc';
    public $checkboxes = [];
    public $selectAll = false;
    public $created_by;
    public $certifiedCandidatesCount;
    public $uncertifiedCandidatesCount;
    public $cvFileExists = '';
    public $creFileExists = '';

    public function selectCandidate($id, $page)
    {
        $this->selectedCandidateId = $id;
        session(['dash_base_cdt_selected_candidate_id' => $id]);
        session(['dash_base_cdt_current_page' => $page]);
        session(['dash_base_cdt_nb_paginate' => $this->nbPaginate]);
        return redirect()->route('candidates.show', $id);
    }

    public function selectCandidateGoToCre($id, $page)
    {
        $this->selectedCandidateId = $id;

        session(['dash_base_cdt_selected_candidate_id' => $id]);
        session(['dash_base_cdt_current_page' => $page]);
        session(['dash_base_cdt_nb_paginate' => $this->nbPaginate]);

        return redirect()->route('candidate.cre', $id);
    }

    public function selectCandidateGoToCv($id, $page)
    {
        $this->selectedCandidateId = $id;
        
        session(['dash_base_cdt_selected_candidate_id' => $id]);
        session(['dash_base_cdt_current_page' => $page]);
        session(['dash_base_cdt_nb_paginate' => $this->nbPaginate]);
    
        return redirect()->route('candidate.cv', $id);
    }
    

    #[On('delete')]
    public function deleteData($id)
    {
        $candidateRepository = new CandidateRepository();
        DB::beginTransaction();
    
        try {
            foreach($id as $idc){ 
                $candidate = $candidateRepository->find($idc);
                $candidateRepository->delete($candidate->id);
            }
            
            DB::commit();
            $this->dispatch('alert', type: 'success', message: "Les candidats sont supprimés avec succès");
            $this->checkboxes = [];
            $this->selectAll = false;

        } catch (\Throwable $th) {
            DB::rollBack();
            $ids = implode(', ', $id);
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer les candidats");
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->checkboxes = Candidate::pluck('id')->toArray();
        } else {
            $this->checkboxes = [];
        }
    }

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortColumn === $column
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';
    
        $this->sortColumn = $column;
    }

    public function searchCandidates()
    {
        // \Log::info('searchCandidates method called with search: ' . $this->search);
        $searchFields = ['first_name', 'last_name', 'email', 'phone', 'city', 'address', 'region', 'country', 'commentaire', 'description', 'suivi'];

        return Candidate::with(['position', 'disponibility', 'civ', 'compagny', 'speciality', 'field', 'auteur'])
            ->where(function ($query) use ($searchFields) {
            $query
                ->where(function ($query) use ($searchFields) {
                foreach ($searchFields as $field) {
                    $query->orWhere($field, 'like', '%' . $this->search . '%');
                }
                })
                ->orWhereHas('disponibility', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('civ', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('compagny', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('speciality', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('field', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('auteur', function ($query) {
                $query->where('trigramme', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterName, function ($query) {
                return $query->orderBy('last_name', $this->filterName);
            })
            ->when($this->filterDate, function ($query) {
                return $query->orderBy('created_at', $this->filterDate);
            })
            ->when($this->candidate_state_id, function ($query) {
                $query->where('candidate_state_id', $this->candidate_state_id);
            })
            ->when($this->candidate_statut_id, function ($query) {
                $query->where('candidate_statut_id', $this->candidate_statut_id);
            })
            ->when($this->position_id, function ($query) {
                $query->where('position_id', $this->position_id);
            })
            ->when($this->users_id, function ($query) {
                $query->where('created_by', $this->users_id);
            })
            ->when($this->cp, function ($query) {
                $query->where('postal_code', 'like', '%' . $this->cp . '%');
            })
            ->when($this->position, function ($query) {
                $query->whereHas('position', function ($query) {
                    $query->where('name', 'like', '%' . $this->position . '%');
                });
            })
            ->when($this->company, function ($query) {
                $query->whereHas('compagny', function ($query) {
                    $query->where('name', 'like', '%' . $this->company . '%');
                });
            })
            ->when($this->cvFileExists !== '', function ($query) {
                if ($this->cvFileExists) {
                    return $query->whereHas('files', function ($query) {
                        $query->where('file_type', 'cv');
                    });
                } else {
                    return $query->whereDoesntHave('files', function ($query) {
                        $query->where('file_type', 'cv');
                    });
                }
            })
            ->when($this->creFileExists !== '', function ($query) {
                if ($this->creFileExists) {
                    return $query->whereHas('cres');
                } else {
                    return $query->whereDoesntHave('cres');
                }
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->nbPaginate);
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer le candidat $nom", type: 'warning', method: 'delete', id: $id);
    }

    public function confirmDeleteChecked($id)
    {
        $idsArray = explode(",", $id);
        $this->dispatch('swal:confirm', title: 'Suppression', 
        text: "Vous-êtes sur le point de supprimer le(s) candidat(s) séléctionné(s)", type: 'warning', method: 'delete', id: $idsArray);
    }

    // public function mount()
    // {
    //     $this->positions = Position::all();
    //     $this->candidateStatuses = CandidateStatut::all();
    //     $this->candidateStates = CandidateState::all();
    //     $this->users = User::all();
    //     $this->certifiedCandidatesCount = $this->countCertifiedCandidates();
    //     $this->uncertifiedCandidatesCount = $this->countUncertifiedCandidates();
    //     $this->search = session()->get('search', '');
    //     $this->nbPaginate = session()->get('nbPaginate', 100);
    //     $this->users_id = session()->get('users_id', '');
    //     $this->candidate_state_id = session()->get('candidate_state_id', '');
    //     $this->candidate_statut_id = session()->get('candidate_statut_id', '');
    //     $this->company = session()->get('company', '');
    //     $this->position_id = session()->get('position_id', '');
    //     $this->cp = session()->get('cp', '');
    //     $this->cvFileExists = session()->get('cvFileExists', '');
    //     $this->creFileExists = session()->get('creFileExists', '');
    //     $this->position = session()->get('position', '');

    //     if (session()->has('dash_base_cdt_selected_candidate_id')) {
    //         $this->selectedCandidateId = session('dash_base_cdt_selected_candidate_id');
    //     }

    //     if (session()->has('dash_base_cdt_current_page')) {
    //         $this->setPage(session('dash_base_cdt_current_page'));
    //     }
    //     if (session()->has('dash_base_cdt_nb_paginate')) {
    //         $this->nbPaginate = session('dash_base_cdt_nb_paginate');
    //     }
    // }

        public function mount()
    {
        $this->positions = Position::all();
        $this->candidateStatuses = CandidateStatut::all();
        $this->candidateStates = CandidateState::all();
        $this->users = User::all();
        $this->certifiedCandidatesCount = $this->countCertifiedCandidates();
        $this->uncertifiedCandidatesCount = $this->countUncertifiedCandidates();
        $this->search = session()->get('search', '');
        $this->nbPaginate = session()->get('nbPaginate', 100);
        $this->users_id = session()->get('users_id', '');
        $this->candidate_state_id = session()->get('candidate_state_id', '');
        $this->candidate_statut_id = session()->get('candidate_statut_id', '');
        $this->company = session()->get('company', '');
        $this->position_id = session()->get('position_id', '');
        $this->cp = session()->get('cp', '');
        $this->cvFileExists = session()->get('cvFileExists', '');
        $this->creFileExists = session()->get('creFileExists', '');
        $this->position = session()->get('position', '');

        // Récupération de l'ID du candidat sélectionné
        $this->selectedCandidateId = session()->get('dash_base_cdt_selected_candidate_id', null);

        // Récupération de la page actuelle
        if (session()->has('dash_base_cdt_current_page')) {
            $this->setPage(session('dash_base_cdt_current_page'));
        }

        $this->nbPaginate = session()->get('dash_base_cdt_nb_paginate', $this->nbPaginate);
    }

    public function downloadExcel(array $selectedCandidateIds = [])
    {
        try {
            // Initialisez la requête
            $query = Candidate::with([
                'position', 'nextStep', 'disponibility', 'civ', 'compagny', 
                'speciality', 'field', 'auteur', 'cres', 'candidateStatut', 
                'candidateState', 'nsDate'
            ]);
            
            // Appliquez les filtres
            $query = $this->applyFilters($query);
    
            // Si des lignes sont sélectionnées, filtrez par les IDs sélectionnés
            if (!empty($selectedCandidateIds)) {
                $query->whereIn('id', $selectedCandidateIds);
            }
    
            $candidates = $query->get();
    
            // Générer et télécharger le fichier Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $headers = [
                'Source', 'CodeCDT', 'Auteur', 'Civ', 'Prénom', 'Nom', 
                'Poste', 'Spécialité', 'Domaine', 'Société', 'Mail', 
                'Tél1', 'Tél2', 'UrlCTC', 'CP/Dpt', 'Ville', 'Région', 
                'Disponibilité', 'Statut CDT', 'NextStep', 'NSDate'
            ];
            $sheet->fromArray([$headers], null, 'A1');
    
            $row = 2;
            foreach ($candidates as $candidate) {
                $rowData = [
                    $candidate->source ?? '',
                    $candidate->code_cdt ?? '',
                    $candidate->auteur->trigramme ?? '',
                    $candidate->civ->name ?? '',
                    $candidate->first_name ?? '',
                    $candidate->last_name ?? '',
                    $candidate->position->name ?? '',
                    $candidate->speciality->name ?? '',
                    $candidate->field->name ?? '',
                    $candidate->compagny->name ?? '',
                    $candidate->email ?? '',
                    $candidate->phone ?? '',
                    $candidate->phone2 ?? '',
                    $candidate->url_ctc ?? '',
                    $candidate->postal_code ?? '',
                    $candidate->city ?? '',
                    $candidate->region ?? '',
                    $candidate->disponibility->name ?? '',
                    $candidate->candidateStatut->name ?? '',
                    $candidate->nextStep->name ?? '',
                    $candidate->nsDate->name ?? ''
                ];
                $sheet->fromArray([$rowData], null, 'A' . $row);
                $row++;
            }
    
            $writer = new Xlsx($spreadsheet);
            $fileName = 'base_candidats.xlsx';
            $writer->save($fileName);
    
            $this->dispatch('alert', type: 'success', message: 'Base candidats exportée avec succès');
            $this->dispatch('exportCompleted'); 
            return response()->download($fileName)->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            $this->dispatch('alert', type: 'error', message: "Une erreur est survenue, veuillez réessayer ou contacter l'administrateur");
        }
    }
    
 
    protected function applyFilters($query)
    {
        return $query->where(function ($query) {
            $searchFields = ['first_name', 'last_name', 'email', 'phone', 'city', 'address', 'region', 'country', 'commentaire', 'description', 'suivi'];
    
            $query->where(function ($query) use ($searchFields) {
                foreach ($searchFields as $field) {
                    $query->orWhere($field, 'like', '%' . $this->search . '%');
                }
            })
            ->orWhereHas('disponibility', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('civ', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('compagny', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('speciality', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('field', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('auteur', function ($query) {
                $query->where('trigramme', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->filterName, function ($query) {
            return $query->orderBy('last_name', $this->filterName);
        })
        ->when($this->filterDate, function ($query) {
            return $query->orderBy('created_at', $this->filterDate);
        })
        ->when($this->candidate_state_id, function ($query) {
            $query->where('candidate_state_id', $this->candidate_state_id);
        })
        ->when($this->candidate_statut_id, function ($query) {
            $query->where('candidate_statut_id', $this->candidate_statut_id);
        })
        ->when($this->position_id, function ($query) {
            $query->where('position_id', $this->position_id);
        })
        ->when($this->users_id, function ($query) {
            $query->where('created_by', $this->users_id);
        })
        ->when($this->cp, function ($query) {
            $query->where('postal_code', 'like', '%' . $this->cp . '%');
        })
        ->when($this->position, function ($query) {
            $query->whereHas('position', function ($query) {
                $query->where('name', 'like', '%' . $this->position . '%');
            });
        })
        ->when($this->company, function ($query) {
            $query->whereHas('compagny', function ($query) {
                $query->where('name', 'like', '%' . $this->company . '%');
            });
        })
        ->when($this->cvFileExists !== '', function ($query) {
            if ($this->cvFileExists) {
                return $query->whereHas('files', function ($query) {
                    $query->where('file_type', 'cv');
                });
            } else {
                return $query->whereDoesntHave('files', function ($query) {
                    $query->where('file_type', 'cv');
                });
            }
        })
        ->when($this->creFileExists !== '', function ($query) {
            if ($this->creFileExists) {
                return $query->whereHas('cres');
            } else {
                return $query->whereDoesntHave('cres');
            }
        })
        ->orderBy($this->sortColumn, $this->sortDirection);
    }

   public function resetFilters()
    {
        $this->reset([
        'search', 
        'nbPaginate',
        'users_id', 
        'candidate_state_id', 
        'candidate_statut_id',
        'company', 
        'position_id',
        'cp', 
        'cvFileExists',
        'creFileExists',
        'position'
        ]);

        session()->forget([
            'search', 
            'nbPaginate', 
            'users_id', 
            'candidate_state_id', 
            'candidate_statut_id', 
            'company', 
            'position_id', 
            'cp', 
            'cvFileExists', 
            'creFileExists',
            'position'
        ]);
    }

    public function countCertifiedCandidates()
    {
        return Candidate::whereHas('candidateState', function ($query) {
            $query->where('name', 'Certifié');
        })->count();
    }

    public function countUncertifiedCandidates()
    {
        return Candidate::whereHas('candidateState', function ($query) {
            $query->where('name', 'Attente');
        })->count();
    }
    public function updated($propertyName)
    {
        session()->put($propertyName, $this->{$propertyName});
    }

    public function render()
    {
        $users = User::all();

        return view('livewire.back.dashboard.trunc')->with([
            'candidates' => $this->searchCandidates(),
            'users' => $users,
        ]);
    }
}
