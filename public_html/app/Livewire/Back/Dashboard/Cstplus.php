<?php

namespace App\Livewire\Back\Dashboard;

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

class Cstplus extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $nbPaginate = 100;
    public $filterName = '';
    public $filterDate = '';
    public $candidate_state_id = '';
    public $selectedCandidateId;
    public $candidateStates;
    public $positions;
    public $position_id;
    public $candidate_statut_id = '';
    public $candidateStatuses;
    public $cp;
    public $users_id;
    public $users;
    public $sortColumn = 'last_name';
    public $sortDirection = 'desc';
    public $checkboxes = [];
    public $selectAll = false;
    public $cvFileExists = '';
    public $creFileExists = '';
    public $company = '';
    public $position = '';

    public function selectCandidate($id, $page)
    {
        $this->selectedCandidateId = $id;
        session(['cte_base_cdt_selected_candidate_id' => $id]);
        session(['cte_base_cdt_current_page' => $page]);
        session(['cte_base_cdt_nb_paginate' => $this->nbPaginate]);
        return redirect()->route('candidates.show', $id);
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
            $this->dispatch('alert', type: 'success', message: "Les candidats sont supprimés avec succès" );
            $this->checkboxes = [];
            $this->selectAll = false;

        } catch (\Throwable $th) {
            DB::rollBack();
            $ids = implode(', ', $id);
    
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer les candidats");
        }
        /*
        }else
        {
            $candidate = $candidateRepository->find($id);
            try {
                $candidateRepository->delete($candidate->id);
                DB::commit();
                $this->dispatch('alert', type: 'success', message: 'le candidat est supprimé avec succès');
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->dispatch('alert', type: 'error', message: "Impossible de supprimer le candidat $candidate->first_name. $candidate->laste_name");
            }
        }
        */
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
        $searchFields = ['first_name', 'last_name', 'email', 'phone', 'postal_code', 'city', 'address', 'region', 'country', 'commentaire', 'description', 'suivi'];

        return Candidate::with(['position', 'disponibility', 'civ', 'compagny', 'speciality', 'field'])
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
                    });
            })
            ->when($this->filterName, function ($query) {
                return $query->orderBy('last_name', $this->filterName);
            })
            ->when($this->filterDate, function ($query) {
                return $query->orderBy('updated_at', $this->filterDate);
            })
            ->when($this->candidate_state_id , function ($query) {
                $query->where('candidate_state_id', $this->candidate_state_id );
            })
            ->when($this->candidate_statut_id, function ($query) {
                $query->where('candidate_statut_id', $this->candidate_statut_id);
            })
            ->when($this->position_id, function ($query) {
                $query->where('position_id', $this->position_id);
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
            ->where('created_by', Auth::id())
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->nbPaginate);
    }
    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer le candidat $nom", type: 'warning', method: 'delete', id: $id);
    }

    //
    public function confirmDeleteChecked($id)
    {
        $idsArray = explode(",", $id); // transform the string set passed by JS into an array
        //idsString = implode(", ", $idsArray);
        $this->dispatch('swal:confirm', title: 'Suppression', 
        text: "Vous-êtes sur le point de supprimer le(s) candidat(s) sélectionné(s)", type: 'warning', method: 'delete', id: $idsArray);
    }
    //

    
    public function mount()
    {
        $this->positions= Position::all();
        $this->candidateStatuses = CandidateStatut::all();
        $this->candidateStates = CandidateState::all();
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

        if (session()->has('cte_base_cdt_selected_candidate_id')) {
            $this->selectedCandidateId = session('cte_base_cdt_selected_candidate_id');
        }

        if (session()->has('cte_base_cdt_current_page')) {
            $this->setPage(session('cte_base_cdt_current_page'));
        }
        if (session()->has('cte_base_cdt_nb_paginate')) {
            $this->nbPaginate = session('cte_base_cdt_nb_paginate');
        }
    }
    public function resetFilters()
    {
        // $this->search = '';
        // $this->filterName = '';
        // $this->filterDate = '';
        // $this->candidate_state_id = '';
        // $this->candidate_statut_id = '';
        // $this->position_id = '';
        // // $this->users_id = '';
        // $this->cp = '';
        // $this->cvFileExists = ''; 
        // $this->creFileExists = ''; 

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
    public function updated($propertyName)
    {
        session()->put($propertyName, $this->{$propertyName});
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

    public function render()
    {
        return view('livewire.back.dashboard.cstplus')->with([
            'candidates' => $this->searchCandidates(),
        ]);
    }
}
