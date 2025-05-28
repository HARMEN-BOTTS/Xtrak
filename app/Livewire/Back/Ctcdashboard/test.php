<?php

namespace App\Livewire\Back\Oppdashboard;

use App\Models\User;
use App\Helpers\Helper;
use Livewire\Component;
use App\Models\Position;
use App\Models\Opportunity;
// use App\Models\OpportunityState;
use Livewire\Attributes\On;
use Livewire\WithPagination;
// use App\Models\OpportunityStatut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OpportunityRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class test extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $nbPaginate = 100;
    public $search = '';
    // public $company = '';
    public $position = '';
    public $positions = '';
    // public $cv = '';
    // public $cre_ref = '';

    // public $Opportunity_statut_id = '';
    // public $OpportunityStatuses;
    public $filterName = '';
    public $filterDate = '';
    // public $Opportunity_state_id = '';
    public $selectedOpportunityId;
    // public $OpportunityStates;
    // public $positions;
    // public $position_id;
    // public $users_id;
    public $users;
    // public $cp;
    public $sortColumn = 'last_name';
    public $sortDirection = 'desc';
    public $checkboxes = [];
    public $selectAll = false;
    public $company_name = '';

    // public $created_by;
    // public $certifiedOpportunitysCount;
    // public $uncertifiedOpportunitysCount;
    // public $cvFileExists = '';
    // public $creFileExists = '';

    public function selectOpportunity($id, $page)
    {
        $this->selectedOpportunityId = $id;
        session(['dash_base_cdt_selected_Opportunity_id' => $id]);
        session(['dash_base_cdt_current_page' => $page]);
        session(['dash_base_cdt_nb_paginate' => $this->nbPaginate]);
        return redirect()->route('Opportunitys.show', $id);
    }

    public function selectOpportunityGoToCre($id, $page)
    {
        $this->selectedOpportunityId = $id;

        session(['dash_base_cdt_selected_Opportunity_id' => $id]);
        session(['dash_base_cdt_current_page' => $page]);
        session(['dash_base_cdt_nb_paginate' => $this->nbPaginate]);

        return redirect()->route('opportunity.cre', $id);
    }

    // public function selectOpportunityGoToCv($id, $page)
    // {
    //     $this->selectedOpportunityId = $id;

    //     session(['dash_base_cdt_selected_Opportunity_id' => $id]);
    //     session(['dash_base_cdt_current_page' => $page]);
    //     session(['dash_base_cdt_nb_paginate' => $this->nbPaginate]);

    //     return redirect()->route('opportunity.cv', $id);
    // }


    #[On('delete')]
    public function deleteData($id)
    {
        $opportunityRepository = new OpportunityRepository();
        DB::beginTransaction();

        try {
            foreach ($id as $idc) {
                $opportunity = $opportunityRepository->find($idc);
                $opportunityRepository->delete($opportunity->id);
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
            $this->checkboxes = Opportunity::pluck('id')->toArray();
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

    public function searchOpportunities()
    {
        // \Log::info('searchOpportunities method called with search: ' . $this->search);
        $searchFields = ['first_name', 'last_name', 'city_name', 'town', 'country'];

        return Opportunity::with(['position', 'civ_id', 'company_name', 'speciality'])
            ->where(function ($query) use ($searchFields) {
                $query
                    ->where(function ($query) use ($searchFields) {
                        foreach ($searchFields as $field) {
                            $query->orWhere($field, 'like', '%' . $this->search . '%');
                        }
                    })
                    ->orWhereHas('civ_id', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('company_name', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('speciality', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filterName, function ($query) {
                return $query->orderBy('last_name', $this->filterName);
            })
            ->when($this->city_name, function ($query) {
                $query->whereHas('city_name', function ($query) {
                    $query->where('name', 'like', '%' . $this->city_name . '%');
                });
            })
            ->when($this->town, function ($query) {
                $query->whereHas('town', function ($query) {
                    $query->where('name', 'like', '%' . $this->town . '%');
                });
            })
            ->when($this->company_name, function ($query) {
                $query->whereHas('company_name', function ($query) {
                    $query->where('name', 'like', '%' . $this->company_name . '%');
                });
            })
            ->when($this->position, function ($query) {
                $query->whereHas('position', function ($query) {
                    $query->where('name', 'like', '%' . $this->position . '%');
                });
            })
            ->when($this->country, function ($query) {
                $query->whereHas('country', function ($query) {
                    $query->where('name', 'like', '%' . $this->country . '%');
                });
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


    public function mount()
    {
        $this->positions = Position::all();
        // $this->OpportunityStatuses = OpportunityStatut::all();
        // $this->OpportunityStates = OpportunityState::all();
        $this->users = User::all();
        // $this->certifiedOpportunitysCount = $this->countCertifiedOpportunitys();
        // $this->uncertifiedOpportunitysCount = $this->countUncertifiedOpportunitys();
        $this->search = session()->get('search', '');
        $this->nbPaginate = session()->get('nbPaginate', 100);
        // $this->users_id = session()->get('users_id', '');
        // $this->Opportunity_state_id = session()->get('Opportunity_state_id', '');
        // $this->Opportunity_statut_id = session()->get('Opportunity_statut_id', '');
        $this->company_name = session()->get('company_name', '');
        // $this->position_id = session()->get('position_id', '');
        // $this->cp = session()->get('cp', '');
        // $this->cvFileExists = session()->get('cvFileExists', '');
        // $this->creFileExists = session()->get('creFileExists', '');
        $this->position = session()->get('position', '');

        // Récupération de l'ID du candidat sélectionné
        $this->selectedOpportunityId = session()->get('dash_base_cdt_selected_Opportunity_id', null);

        // Récupération de la page actuelle
        if (session()->has('dash_base_cdt_current_page')) {
            $this->setPage(session('dash_base_cdt_current_page'));
        }

        $this->nbPaginate = session()->get('dash_base_cdt_nb_paginate', $this->nbPaginate);
    }

    public function downloadExcel(array $selectedOpportunityIds = [])
    {
        try {
            // Initialisez la requête
            $query = Opportunity::with(
                [
                    'position',
                    'date_opp',
                    'oppcode',
                    'origine',
                    'trgcode',
                    'company_name',
                    'cp',
                    'city_name',
                    'ctc_code',
                    'civ_id',
                    'first_name',
                    'last_name',
                    'function',
                    'job_title',
                    'speciality',
                    'domain',
                    'cp_dpt',
                    'town',
                    'country',
                    'experience',
                    'education',
                    'schedules',
                    'mobility',
                    'permit',
                    'type',
                    'vehicle',
                    'skill_one',
                    'skill_two',
                    'skill_three',
                    'others_one',
                    'remarks_one',
                    'annual_gross_salary',
                    'advantage_one',
                    'advantage_two',
                    'advantage_three',
                    'others_two',
                    'remarks_two',
                    'opp_statut',
                    'ref_fact'
                ]
            );

            // Appliquez les filtres
            $query = $this->applyFilters($query);

            // Si des lignes sont sélectionnées, filtrez par les IDs sélectionnés
            if (!empty($selectedOpportunityIds)) {
                $query->whereIn('id', $selectedOpportunityIds);
            }

            $Opportunitys = $query->get();

            // Générer et télécharger le fichier Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $headers = [
                'date_opp',
                'oppcode',
                'origine',
                'trgcode',
                'company_name',
                'cp',
                'city_name',
                'ctc_code',
                'civ_id',
                'first_name',
                'last_name',
                'function',
                'job_title',
                'speciality',
                'domain',
                'cp_dpt',
                'town',
                'country',
                'experience',
                'education',
                'schedules',
                'mobility',
                'permit',
                'type',
                'vehicle',
                'skill_one',
                'skill_two',
                'skill_three',
                'others_one',
                'remarks_one',
                'annual_gross_salary',
                'advantage_one',
                'advantage_two',
                'advantage_three',
                'others_two',
                'remarks_two',
                'opp_statut',
                'ref_fact'
            ];

            $sheet->fromArray([$headers], null, 'A1');

            $row = 2;
            foreach ($Opportunitys as $Opportunity) {
                $rowData = [
                    $Opportunity->date_opp ?? '',
                    $Opportunity->oppcode ?? '',
                    $Opportunity->origine ?? '',
                    $Opportunity->trgcode ?? '',
                    $Opportunity->company_name ?? '',
                    $Opportunity->cp ?? '',
                    $Opportunity->city_name ?? '',
                    $Opportunity->ctc_code ?? '',
                    $Opportunity->civ_id ?? '',
                    $Opportunity->first_name ?? '',
                    $Opportunity->last_name ?? '',
                    $Opportunity->function ?? '',
                    $Opportunity->job_title ?? '',
                    $Opportunity->speciality ?? '',
                    $Opportunity->domain ?? '',
                    $Opportunity->cp_dpt ?? '',
                    $Opportunity->town ?? '',
                    $Opportunity->country ?? '',
                    $Opportunity->experience ?? '',
                    $Opportunity->education ?? '',
                    $Opportunity->schedules ?? '',
                    $Opportunity->mobility ?? '',
                    $Opportunity->permit ?? '',
                    $Opportunity->type ?? '',
                    $Opportunity->vehicle ?? '',
                    $Opportunity->skill_one ?? '',
                    $Opportunity->skill_two ?? '',
                    $Opportunity->skill_three ?? '',
                    $Opportunity->others_one ?? '',
                    $Opportunity->remarks_one ?? '',
                    $Opportunity->annual_gross_salary ?? '',
                    $Opportunity->advantage_one ?? '',
                    $Opportunity->advantage_two ?? '',
                    $Opportunity->advantage_three ?? '',
                    $Opportunity->others_two ?? '',
                    $Opportunity->remarks_two ?? '',
                    $Opportunity->opp_statut ?? '',
                    $Opportunity->ref_fact ?? ''
                ];
                $sheet->fromArray([$rowData], null, 'A' . $row);
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $fileName = 'base_opportunity.xlsx';
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
            $searchFields = ['first_name', 'last_name', 'city_name', 'town', 'country'];

            $query->where(function ($query) use ($searchFields) {
                foreach ($searchFields as $field) {
                    $query->orWhere($field, 'like', '%' . $this->search . '%');
                }
            })
                ->orWhereHas('civ_id', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('company_name', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('speciality', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
        })
            ->when($this->filterName, function ($query) {
                return $query->orderBy('last_name', $this->filterName);
            })
            ->when($this->city_name, function ($query) {
                $query->whereHas('city_name', function ($query) {
                    $query->where('name', 'like', '%' . $this->city_name . '%');
                });
            })
            ->when($this->town, function ($query) {
                $query->whereHas('town', function ($query) {
                    $query->where('name', 'like', '%' . $this->town . '%');
                });
            })
            ->when($this->company_name, function ($query) {
                $query->whereHas('company_name', function ($query) {
                    $query->where('name', 'like', '%' . $this->company_name . '%');
                });
            })
            ->when($this->position, function ($query) {
                $query->whereHas('position', function ($query) {
                    $query->where('name', 'like', '%' . $this->position . '%');
                });
            })
            ->when($this->country, function ($query) {
                $query->whereHas('country', function ($query) {
                    $query->where('name', 'like', '%' . $this->country . '%');
                });
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->nbPaginate);
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'nbPaginate',
            'company_name',
            'position'
        ]);

        session()->forget([
            'search',
            'nbPaginate',
            'company_name',
            'position'
        ]);
    }

    // public function countCertifiedOpportunitys()
    // {
    //     return Opportunity::whereHas('OpportunityState', function ($query) {
    //         $query->where('name', 'Certifié');
    //     })->count();
    // }

    // public function countUncertifiedOpportunitys()
    // {
    //     return Opportunity::whereHas('OpportunityState', function ($query) {
    //         $query->where('name', 'Attente');
    //     })->count();
    // }
    public function updated($propertyName)
    {
        session()->put($propertyName, $this->{$propertyName});
    }

    public function render()
    {
        $users = User::all();

        return view('livewire.back.oppdashboard.admin')->with([
            'Opportunitys' => $this->searchOpportunitys(),
            'users' => $users,
        ]);
    }
}



