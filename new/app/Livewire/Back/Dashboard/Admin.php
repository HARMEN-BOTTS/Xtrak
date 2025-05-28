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
use App\Models\Oppdashboard; // Add this
use App\Models\CdtOppLink; // We'll create this model

use App\Models\Mcpdashboard; // Add this
use App\Models\CdtMcpLink; // We'll create this model




class Admin extends Component
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


    // Add properties for CDT linking
    public $oppCode = '';
    public $showOppModal = false;
    public $oppLinkError = '';

    protected $rules = [
        'oppCode' => 'required',
    ];

    // Add properties for MCP linking
    public $mcpCode = '';
    public $showMcpModal = false;
    public $mcpLinkError = '';

    protected $rules_mcp = [
        'mcpCode' => 'required',
    ];

    public $totalPages = 0;
    public $currentPageMessage = '';

    public function gotoPage($pageNumber)
    {
        $maxPage = ceil($this->searchCandidates()->total() / $this->nbPaginate);
        $this->totalPages = $maxPage;

        if ($pageNumber > 0 && $pageNumber <= $maxPage) {
            $this->setPage($pageNumber);
            // $this->currentPageMessage = "Showing page $pageNumber of $maxPage";
            // session()->flash('success', "Successfully navigated to page $pageNumber");
            $this->dispatch('alert', type: 'success', message: "Successfully navigated to page $pageNumber");
          
        } else {
            // session()->flash('error', "Invalid page number. Please enter a number between 1 and $maxPage.");
            $this->dispatch('alert', type: 'error', message: "Invalid page number. Please enter a number between 1 and $maxPage.");
          
        }
    }




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
            foreach ($id as $idc) {
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

         // Check for linked data
        $selectedIds = array_keys(array_filter($this->checkboxes));

        if (!empty($selectedIds)) {
            $linkedDataCount = CdtMcpLink::whereIn('cdt_id', $selectedIds)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-mcplist-button');
            } else {
                $this->dispatch('enable-mcplist-button');
            }
        } else {
            $this->dispatch('disable-mcplist-button');
        }

        if (!empty($selectedIds)) {
            $linkedDataCountOPP = CdtOppLink::whereIn('cdt_id', $selectedIds)->count();

            if ($linkedDataCountOPP === 0) {
                $this->dispatch('hide-opplist-button');
            } else {
                $this->dispatch('enable-opplist-button');
            }
        } else {
            $this->dispatch('disable-opplist-button');
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
        $this->dispatch(
            'swal:confirm',
            title: 'Suppression',
            text: "Vous-êtes sur le point de supprimer le(s) candidat(s) séléctionné(s)",
            type: 'warning',
            method: 'delete',
            id: $idsArray
        );
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
                'position',
                'nextStep',
                'disponibility',
                'civ',
                'compagny',
                'speciality',
                'field',
                'auteur',
                'cres',
                'candidateStatut',
                'candidateState',
                'nsDate'
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
                'Source',
                'CodeCDT',
                'Auteur',
                'Civ',
                'Prénom',
                'Nom',
                'Poste',
                'Spécialité',
                'Domaine',
                'Société',
                'Mail',
                'Tél1',
                'Tél2',
                'UrlCTC',
                'CP/Dpt',
                'Ville',
                'Région',
                'Disponibilité',
                'Statut CDT',
                'NextStep',
                'NSDate'
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

    // Row selection 

    public function selectRow($id)
    {
        $this->selectedCandidateId = $id;

        if (isset($this->checkboxes[$id])) {
            $this->checkboxes[$id] = !$this->checkboxes[$id];
        } else {
            $this->checkboxes[$id] = true;
        }


        if (!empty($this->selectedCandidateId)) {
            $linkedDataCount = CdtMcpLink::where('cdt_id', $this->selectedCandidateId)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-mcplist-button');
            } else {
                $this->dispatch('enable-mcplist-button');
            }
        } else {
            $this->dispatch('disable-mcplist-button');
        }

        if (!empty($this->selectedCandidateId)) {
            $linkedDataCountOPP = CdtOppLink::where('cdt_id', $this->selectedCandidateId)->count();

            if ($linkedDataCountOPP === 0) {
                $this->dispatch('hide-opplist-button');
            } else {
                $this->dispatch('enable-opplist-button');
            }
        } else {
            $this->dispatch('disable-opplist-button');
        }
    }

    public function checkLinkedData()
    {
        if (empty($this->selectedCandidateId)) {
            return false;
        }

        $linkedDataCount = CdtMcpLink::where('cdt_id', $this->selectedCandidateId)->count();
        return $linkedDataCount > 0;
    }

    public function checkLinkedDataOPP()
    {
        if (empty($this->selectedCandidateId)) {
            return false;
        }

        $linkedDataCountOPP = CdtOppLink::where('cdt_id', $this->selectedCandidateId)->count();
        return $linkedDataCountOPP > 0;
    }



    public function showLinkedData()
    {
        if (empty($this->selectedCandidateId)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('cdtmcplist');
            return;
        }

        $linkedDataCount = CdtMcpLink::where('cdt_id', $this->selectedCandidateId)->count();

        if ($linkedDataCount === 0) {
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-mcplist-button');
            // session()->flash('message', 'No data linked to the selected row.');
            return;
        }

        // Pass the selected CDT ID(s) to the MCP List route
        redirect()->route('cdtmcplist', ['selectedRows' => [$this->selectedCandidateId]]);
    }

    public function showLinkedDataOPP()
    {
        if (empty($this->selectedCandidateId)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('opplist');
            return;
        }

        $linkedDataCountOPP = CdtOppLink::where('cdt_id', $this->selectedCandidateId)->count();

        if ($linkedDataCountOPP === 0) {
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-opplist-button');
            // session()->flash('message', 'No data linked to the selected row.');
            return;
        }

        // Pass the selected CDT ID(s) to the MCP List route
        redirect()->route('opplist', ['selectedRows' => [$this->selectedCandidateId]]);
    }



    // New methods for Opp linking
    // public function openOppModal()
    // {
    //     if (empty($this->selectedCandidateId)) {
    //         session()->flash('error', 'Please select at least one candidate to link');
    //         return;
    //     }

    //     $this->showOppModal = true;
    //     $this->oppCode = '';
    //     $this->oppLinkError = '';
    //     $this->dispatch('open-opp-modal');
    // }

    public function openOppModal()
    {
        $selectedIds = array_keys(array_filter($this->checkboxes));

        if (empty($selectedIds) && empty($this->selectedCandidateId)) {
            // session()->flash('error', 'Please select at least one candidate to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one opportunity to link");
    
            return;
        }

        if (empty($this->selectedCandidateId)) {
            $this->selectedCandidateId = implode(',', $selectedIds);
        }

        $this->showOppModal = true;
        $this->oppCode = '';
        $this->oppLinkError = '';
        $this->dispatch('open-opp-modal');
    }

    // public function selectRow($id)
    // {
    //     $this->selectedCandidateId = $id;
    //     if (isset($this->checkboxes[$id])) {
    //         $this->checkboxes[$id] = !$this->checkboxes[$id];
    //     } else {
    //         $this->checkboxes[$id] = true;
    //     }
    // }

    public function closeOppModal()
    {
        $this->showOppModal = false;
        $this->oppCode = '';
        $this->oppLinkError = '';
        $this->dispatch('closeModal', modalId: 'oppLinkModal');
    }

    public function linkOpp()
    {
        $this->validate([
            'oppCode' => 'required',
        ]);

        // Check if any rows are selected
        if (empty($this->selectedCandidateId)) {
            // $this->oppLinkError = 'Please select at least one candidate to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one candidate to link");
            return;
        }

        // Find the candidate with the given code
        $candidate = Oppdashboard::where('opp_code', $this->oppCode)->first();

        if (!$candidate) {
            // $this->oppLinkError = 'No candidate found with this OPP code';
            $this->dispatch('alert', type: 'error', message: "No candidate found with this OPP code");
            $this->oppCode = '';
            $this->closeOppModal();
            $this->dispatch('closeModal', modalId: 'oppLinkModal');
        
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        $candidateIds = explode(',', $this->selectedCandidateId);
        foreach ( $candidateIds as $cdtId) {
            // Check if already linked
            $existingLink = CdtOppLink::where('cdt_id', $cdtId)
                ->where('opp_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            CdtOppLink::create([
                'cdt_id' => $cdtId,
                'opp_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount candidates linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount candidates linked successfully $alreadyLinkedCount were already linked.");
            $this->oppCode = '';
            $this->closeOppModal();
            $this->dispatch('closeModal', modalId: 'oppLinkModal');
        
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount candidates linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount candidates linked successfully");
            $this->oppCode = '';
            $this->closeOppModal();
            $this->dispatch('closeModal', modalId: 'oppLinkModal');
        
        } elseif ($alreadyLinkedCount > 0) {
            // $this->oppLinkError = "Selected candidates are already linked to this CDT";
            $this->dispatch('alert', type: 'error', message: "Selected candidates are already linked to this CDT");
            $this->oppCode = '';
            $this->closeOppModal();
            $this->dispatch('closeModal', modalId: 'oppLinkModal');
        
            return;
        }

        // Clear inputs and close modal
        $this->oppCode = '';
        $this->closeOppModal();
        $this->dispatch('closeModal', modalId: 'oppLinkModal');
    }

    // Linking for CDT to MCP

    public function openMcpModal()
    {
        $selectedIds = array_keys(array_filter($this->checkboxes));

        if (empty($selectedIds) && empty($this->selectedCandidateId)) {
            // session()->flash('error', 'Please select at least one candidate to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one opportunity to link");
    
            return;
        }

        if (empty($this->selectedCandidateId)) {
            $this->selectedCandidateId = implode(',', $selectedIds);
        }

        $this->showMcpModal = true;
        $this->mcpCode = '';
        $this->mcpLinkError = '';
        $this->dispatch('open-mcp-modal');
    }

    
    public function closeMcpModal()
    {
        $this->showMcpModal = false;
        $this->mcpCode = '';
        $this->mcpLinkError = '';
        $this->dispatch('closeModal', modalId: 'mcpLinkModal');
    }

    public function linkMcp()
    {
        $this->validate([
            'mcpCode' => 'required',
        ]);

        // Check if any rows are selected
        if (empty($this->selectedCandidateId)) {
            // $this->mcpLinkError = 'Please select at least one candidate to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one candidate to link");
        
            return;
        }

        // Find the candidate with the given code
        $candidate = Mcpdashboard::where('mcp_code', $this->mcpCode)->first();

        if (!$candidate) {
            // $this->mcpLinkError = 'No candidate found with this MCP code';
            $this->dispatch('alert', type: 'error', message: "No candidate found with this MCP code");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        $candidateIds = explode(',', $this->selectedCandidateId);
        foreach ($candidateIds as $cdtId) {
            // Check if already linked
            $existingLink = CdtMcpLink::where('cdt_id', $cdtId)
                ->where('mcp_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            CdtMcpLink::create([
                'cdt_id' => $cdtId,
                'mcp_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount candidates linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount candidates linked successfully $alreadyLinkedCount were already linked.");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount candidates linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount candidates linked successfully");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        
        } elseif ($alreadyLinkedCount > 0) {
            // $this->mcpLinkError = "Selected candidates are already linked to this CDT";
            $this->dispatch('alert', type: 'error', message: "Selected candidates are already linked to this CDT");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        
            return;
        }

        // Clear inputs and close modal
        $this->mcpCode = '';
        $this->closeMcpModal();
        $this->dispatch('closeModal', modalId: 'mcpLinkModal');
    }







    public function render()
    {
        $users = User::all();
        $candidates = $this->searchCandidates();
        $this->totalPages = ceil($candidates->total() / $this->nbPaginate);

        return view('livewire.back.dashboard.admin')->with([
            'candidates' => $this->searchCandidates(),
            'users' => $users,
        ]);
    }
}
