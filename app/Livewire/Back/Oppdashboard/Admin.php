<?php

namespace App\Livewire\Back\Oppdashboard;

use App\Models\Ctcdashboard;
use App\Models\Oppdashboard;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Candidate; // Add this
use App\Models\OppCdtLink; // We'll create this model

use App\Models\Cstdashboard; // Add this
use App\Models\OppCstLink; // We'll create this model


use App\Models\Mcpdashboard; // Add this
use App\Models\OppMcpLink; // We'll create this model

class Admin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';
    public $selectAll = false;
    public $hiredCount;
    public $inprogressCount;
    public $presentedCount;

    // Filter : 
    public $select = false;
    public $search = '';
    public $codeopp = '';
    public $libelle = '';
    public $company = '';
    public $statut = '';
    public $position = '';
    public $remarks = '';


    public $datas;
    public $selectedRows = [];

    // Add properties for CDT linking
    public $cdtCode = '';
    public $showCdtModal = false;
    public $cdtLinkError = '';


    // Add properties for CDT linking
    public $cstCode = '';
    public $showCstModal = false;
    public $cstLinkError = '';

    // Add properties for CDT linking
    public $mcpCode = '';
    public $showMcpModal = false;
    public $mcpLinkError = '';


    protected $listeners = ['refreshTable' => '$refresh'];
    public $isEditing = false;
    public $editId = null;
    public $formData = [];
    public $step = 1;
    public $action;

    // Rules for CDT code validation
    protected $rules = [
        'cdtCode' => 'required',
    ];


    // Rules for CDT code validation
    protected $rules_cst = [
        'cstCode' => 'required',
    ];


    // Rules for CDT code validation
    protected $rules_mcp = [
        'mcpCode' => 'required',
    ];

    public $showCheckboxes = false;

    public function toggleSelectionMode()
    {
        $this->showCheckboxes = !$this->showCheckboxes;
        if (!$this->showCheckboxes) {
            $this->selectedRows = [];
            $this->selectAll = false;
        }
    }


    public $pageNumberInput = '';
    public $totalPages = 0;
    public $pageMessage = '';
    public $pageMessageType = '';

    public function goToPage()
    {
        // Validate page number input
        if (!is_numeric($this->pageNumberInput) || $this->pageNumberInput < 1) {
            // $this->pageMessageType = 'error';
            // $this->pageMessage = 'Please enter a valid page number';
            $this->dispatch('alert', type: 'error', message: "Please enter a valid page number");
            return;
        }

        // Check if page number is within bounds
        if ($this->pageNumberInput > $this->totalPages) {
            // $this->pageMessageType = 'error';
            // $this->pageMessage = "Page number out of range. Maximum is {$this->totalPages}";
            $this->dispatch('alert', type: 'error', message: "Page number out of range. Maximum is {$this->totalPages}");
            return;
        }

        // Go to the specified page
        $this->setPage($this->pageNumberInput);

        // Show success message
        // $this->pageMessageType = 'success';
        // $this->pageMessage = "Successfully navigated to page {$this->pageNumberInput}";
        $this->dispatch('alert', type: 'success', message: "Successfully navigated to page {$this->pageNumberInput}");
    }



    public function refreshData()
    {
        $this->datas = Oppdashboard::latest()->get();
    }

    // public function updatedSelectAll($value)
    // {
    //     if ($value) {
    //         $this->selectedRows = $this->data->pluck('id')->map(function ($id) {
    //             return (string) $id;
    //         })->toArray();
    //     } else {
    //         $this->selectedRows = [];
    //     }
    // }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $query = Oppdashboard::query();

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('opportunity_date', 'like', '%' . $this->search . '%')
                        ->orWhere('opp_code', 'like', '%' . $this->search . '%')
                        ->orWhere('job_titles', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('postal_code_1', 'like', '%' . $this->search . '%')
                        ->orWhere('site_city', 'like', '%' . $this->search . '%')
                        ->orWhere('opportunity_status', 'like', '%' . $this->search . '%')
                        ->orWhere('remarks', 'like', '%' . $this->search . '%')
                        ->orWhere('trg_code', 'like', '%' . $this->search . '%')
                        ->orWhere('total_paid', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->codeopp) {
                $query->where('opp_code', 'like', '%' . $this->codeopp . '%');
            }

            if ($this->libelle) {
                $query->where('job_titles', 'like', '%' . $this->libelle . '%');
            }

            if ($this->company) {
                $query->where('name', 'like', '%' . $this->company . '%');
            }

            if ($this->statut !== '') {
                if ($this->statut == 'Open') {
                    $query->where('opportunity_status', 'Open');
                } else if ($this->statut == 'Closed') {
                    $query->where('opportunity_status', 'Closed');
                } else if ($this->statut == 'Filled') {
                    $query->where('opportunity_status', 'Filled');
                }
            }

            if ($this->position) {
                $query->where('postal_code_1', 'like', '%' . $this->position . '%');
            }

            if ($this->remarks) {
                $query->where('remarks', 'like', '%' . $this->remarks . '%');
            }

            $this->selectedRows = $query->pluck('id')->map(function ($id) {
                return (string) $id;
            })->toArray();
        } else {
            $this->selectedRows = [];
        }


        if (!empty($this->selectedRows)) {
            $linkedDataCount = OppMcpLink::whereIn('opp_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-mcplist-button');
            } else {
                $this->dispatch('enable-mcplist-button');
            }
        } else {
            $this->dispatch('disable-mcplist-button');
        }

        if (!empty($this->selectedRows)) {
            $linkedDataCountCST = OppCstLink::whereIn('opp_id', $this->selectedRows)->count();

            if ($linkedDataCountCST === 0) {
                $this->dispatch('hide-cstlist-button');
            } else {
                $this->dispatch('enable-cstlist-button');
            }
        } else {
            $this->dispatch('disable-cstlist-button');
        }


        if (!empty($this->selectedRows)) {
            $linkedDataCountCDT = OppCdtLink::whereIn('opp_id', $this->selectedRows)->count();

            if ($linkedDataCountCDT === 0) {
                $this->dispatch('hide-cdtlist-button');
            } else {
                $this->dispatch('enable-cdtlist-button');
            }
        } else {
            $this->dispatch('disable-cdtlist-button');
        }
    }


    public function toggleSelect($id)
    {
        if (in_array($id, $this->selectedRows)) {
            $this->selectedRows = array_diff($this->selectedRows, [$id]);
        } else {
            $this->selectedRows = [$id];
        }


        if (!empty($this->selectedRows)) {
            $linkedDataCount = OppMcpLink::whereIn('opp_id', $this->selectedRows)->count();

            if ($linkedDataCount === 0) {
                $this->dispatch('hide-mcplist-button');
            } else {
                $this->dispatch('enable-mcplist-button');
            }
        } else {
            $this->dispatch('disable-mcplist-button');
        }


        if (!empty($this->selectedRows)) {
            $linkedDataCountCST = OppCstLink::whereIn('opp_id', $this->selectedRows)->count();

            if ($linkedDataCountCST === 0) {
                $this->dispatch('hide-cstlist-button');
            } else {
                $this->dispatch('enable-cstlist-button');
            }
        } else {
            $this->dispatch('disable-cstlist-button');
        }


        if (!empty($this->selectedRows)) {
            $linkedDataCountCDT = OppCdtLink::whereIn('opp_id', $this->selectedRows)->count();

            if ($linkedDataCountCDT === 0) {
                $this->dispatch('hide-cdtlist-button');
            } else {
                $this->dispatch('enable-cdtlist-button');
            }
        } else {
            $this->dispatch('disable-cdtlist-button');
        }
    }


    public function checkLinkedData()
    {
        if (empty($this->selectedRows)) {
            return false;
        }

        $linkedDataCount = OppMcpLink::whereIn('opp_id', $this->selectedRows)->count();
        return $linkedDataCount > 0;
    }

    public function checkLinkedDataCST()
    {
        if (empty($this->selectedRows)) {
            return false;
        }

        $linkedDataCountCST = OppCstLink::whereIn('opp_id', $this->selectedRows)->count();
        return $linkedDataCountCST > 0;
    }

    public function checkLinkedDataCDT()
    {
        if (empty($this->selectedRows)) {
            return false;
        }

        $linkedDataCountCDT = OppCdtLink::whereIn('opp_id', $this->selectedRows)->count();
        return $linkedDataCountCDT > 0;
    }


    public function showLinkedData()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('oppmcplist');
            return;
        }

        $linkedDataCount = OppMcpLink::whereIn('opp_id', $this->selectedRows)->count();

        if ($linkedDataCount === 0) {
            // session()->flash('message', 'No linked data for selected row.');
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-mcplist-button');
            return;
        }

        redirect()->route('oppmcplist', ['selectedRows' => $this->selectedRows]);
    }

    public function showLinkedDataCST()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('oppcstlist');
            return;
        }

        $linkedDataCountCST = OppCstLink::whereIn('opp_id', $this->selectedRows)->count();

        if ($linkedDataCountCST === 0) {
            // session()->flash('message', 'No linked data for selected row.');
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-cstlist-button');
            return;
        }

        redirect()->route('oppcstlist', ['selectedRows' => $this->selectedRows]);
    }


    public function showLinkedDataCDT()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('message', 'Please select a row to view linked data.');
            redirect()->route('oppcdtlist');
            return;
        }

        $linkedDataCountCDT = OppCdtLink::whereIn('opp_id', $this->selectedRows)->count();

        if ($linkedDataCountCDT === 0) {
            // session()->flash('message', 'No linked data for selected row.');
            $this->dispatch('alert', type: 'error', message: "No data linked to the selected row.");
            $this->dispatch('hide-cdtlist-button');
            return;
        }

        redirect()->route('oppcdtlist', ['selectedRows' => $this->selectedRows]);
    }




    public function deleteSelected()
    {
        if (empty($this->selectedRows)) {
            return;
        }

        Oppdashboard::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        // session()->flash('message', 'Data Deleted Successfully 🛑');
        $this->dispatch('alert', type: 'success', message: "Data Deleted Successfully");
    }


    public function editRow($id)
    {
        $this->editId = $id;
        $item = Oppdashboard::find($id);

        if ($item) {
            $this->formData = $item->toArray();
            $this->isEditing = true;
        }
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->editId = null;
        $this->formData = [];
    }

    public function updateForm()
    {
        // $this->validate([
        //     'formData.date_ctc' => 'required|date',
        //     'formData.ctc_code' => 'required',
        //     'formData.first_name' => 'required',
        //     'formData.last_name' => 'required',
        //     'formData.mail' => 'required|email',
        // ]);

        $item = Oppdashboard::find($this->editId);
        if ($item) {
            $item->update([
                'opportunity_date' => $this->formData['opportunity_date'] ?? null,
                'opp_code' => $this->formData['opp_code'] ?? null,
                'auth' => $this->formData['auth'] ?? null,
                'trg_code' => $this->formData['trg_code'] ?? null,
                'name' => $this->formData['name'] ?? null,
                'postal_code_1' => $this->formData['postal_code_1'] ?? null,
                'site_city' => $this->formData['site_city'] ?? null,
                'ctc1_code' => $this->formData['ctc1_code'] ?? null,
                'civs' => $this->formData['civs'] ?? null,
                'ctc1_first_name' => $this->formData['ctc1_first_name'] ?? null,
                'ctc1_last_name' => $this->formData['ctc1_last_name'] ?? null,
                'position' => $this->formData['position'] ?? null,
                'remarks' => $this->formData['remarks'] ?? null,
                'job_titles' => $this->formData['job_titles'] ?? null,
                'specificities' => $this->formData['specificities'] ?? null,
                'domain' => $this->formData['domain'] ?? null,
                'postal_code' => $this->formData['postal_code'] ?? null,
                'town' => $this->formData['town'] ?? null,
                'country' => $this->formData['country'] ?? null,
                'experience' => $this->formData['experience'] ?? null,
                'schooling' => $this->formData['schooling'] ?? null,
                'schedules' => $this->formData['schedules'] ?? null,
                'mobility' => $this->formData['mobility'] ?? null,
                'permission' => $this->formData['permission'] ?? null,
                'type' => $this->formData['type'] ?? null,
                'vehicle' => $this->formData['vehicle'] ?? null,
                'job_offer_date' => $this->formData['job_offer_date'] ?? null,
                'skill_one' => $this->formData['skill_one'] ?? null,
                'skill_two' => $this->formData['skill_two'] ?? null,
                'skill_three' => $this->formData['skill_three'] ?? null,
                'other_one' => $this->formData['other_one'] ?? null,
                'remarks_two' => $this->formData['remarks_two'] ?? null,
                'job_start_date' => $this->formData['job_start_date'] ?? null,
                'invoice_date' => $this->formData['invoice_date'] ?? null,
                'gross_salary' => $this->formData['gross_salary'] ?? null,
                'bonus_1' => $this->formData['bonus_1'] ?? null,
                'bonus_2' => $this->formData['bonus_2'] ?? null,
                'bonus_3' => $this->formData['bonus_3'] ?? null,
                'other_two' => $this->formData['other_two'] ?? null,
                'date_emb' => $this->formData['date_emb'] ?? null,
            ]);

            $this->isEditing = false;
            $this->editId = null;
            $this->formData = [];

            $this->refreshData();

            // session()->flash('message', 'Form Updated Successfully ✅');
            $this->dispatch('alert', type: 'success', message: "Form Updated Successfully");
        }
    }



    public function resetFilters()
    {
        $this->select = false;
        $this->search = '';
        $this->codeopp = '';
        $this->libelle = '';
        $this->company = '';
        $this->statut = '';
        $this->position = '';
        $this->remarks = '';
    }

    public function mount()
    {
        $this->hiredCount = $this->countHired();
        $this->inprogressCount = $this->countInprogress();
        $this->presentedCount = $this->countPresented();

        // Calculate total pages
        $query = Oppdashboard::query();
        $totalRecords = $query->count();
        $this->totalPages = ceil($totalRecords / 100);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function countHired()
    {
        return Oppdashboard::where('opportunity_status', 'HIRED')->count();
    }

    public function countInprogress()
    {
        return Oppdashboard::where('opportunity_status', 'En cours')->count();
    }

    public function countPresented()
    {
        return Oppdashboard::where('opportunity_status', 'Presented')->count();
    }


    // New methods for CDT linking
    public function openCdtModal()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('error', 'Please select at least one opportunity to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one opportunity to link");

            return;
        }

        $this->showCdtModal = true;
        $this->cdtCode = '';
        $this->cdtLinkError = '';
        $this->dispatch('open-cdt-modal');
    }

    public function closeCdtModal()
    {
        $this->showCdtModal = false;
        $this->cdtCode = '';
        $this->cdtLinkError = '';

        $this->dispatch('closeModal', modalId: 'cdtLinkModal');
    }

    public function linkCdt()
    {
        $this->validate([
            'cdtCode' => 'required',
        ]);

        // Check if any rows are selected
        if (empty($this->selectedRows)) {
            // $this->cdtLinkError = 'Please select at least one opportunity to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one opportunity to link");
            return;
        }

        // Find the candidate with the given code
        $candidate = Candidate::where('code_cdt', $this->cdtCode)->first();

        if (!$candidate) {
            // $this->cdtLinkError = 'No candidate found with this CDT code';
            $this->dispatch('alert', type: 'error', message: "No candidate found with this CDT code");
            $this->cdtCode = '';
            $this->closeCdtModal();

            $this->dispatch('closeModal', modalId: 'cdtLinkModal');
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        foreach ($this->selectedRows as $oppId) {
            // Check if already linked
            $existingLink = OppCdtLink::where('opp_id', $oppId)
                ->where('cdt_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            OppCdtLink::create([
                'opp_id' => $oppId,
                'cdt_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->cdtCode = '';
            $this->closeCdtModal();

            $this->dispatch('closeModal', modalId: 'cdtLinkModal');
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount opportunities linked successfully");
            $this->cdtCode = '';
            $this->closeCdtModal();

            $this->dispatch('closeModal', modalId: 'cdtLinkModal');
        } elseif ($alreadyLinkedCount > 0) {
            // $this->cdtLinkError = "Selected opportunities are already linked to this CDT";
            $this->dispatch('alert', type: 'error', message: "Selected opportunities are already linked to this CDT");
            $this->cdtCode = '';
            $this->closeCdtModal();

            $this->dispatch('closeModal', modalId: 'cdtLinkModal');

            return;
        }

        // Clear inputs and close modal
        $this->cdtCode = '';
        $this->closeCdtModal();

        $this->dispatch('closeModal', modalId: 'cdtLinkModal');
    }




    // New methods for CST linking
    public function openCstModal()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('error', 'Please select at least one opportunity to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one opportunity to link");

            return;
        }

        $this->showCstModal = true;
        $this->cstCode = '';
        $this->cstLinkError = '';
        $this->dispatch('open-cst-modal');
    }

    public function closeCstModal()
    {
        $this->showCstModal = false;
        $this->cstCode = '';
        $this->cstLinkError = '';

        $this->dispatch('closeModal', modalId: 'cstLinkModal');
    }

    public function linkCst()
    {
        $this->validate([
            'cstCode' => 'required',
        ]);

        // Check if any rows are selected
        if (empty($this->selectedRows)) {
            // $this->cstLinkError = 'Please select at least one opportunity to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one opportunity to link");
            return;
        }

        // Find the candidate with the given code
        $candidate = Cstdashboard::where('cst_code', $this->cstCode)->first();

        if (!$candidate) {
            // $this->cstLinkError = 'No data found with this CST code';
            $this->dispatch('alert', type: 'error', message: "No data found with this CST code");
            $this->cstCode = '';
            $this->closeCstModal();
            $this->dispatch('closeModal', modalId: 'cstLinkModal');
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        foreach ($this->selectedRows as $oppId) {
            // Check if already linked
            $existingLink = OppCstLink::where('opp_id', $oppId)
                ->where('cst_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            OppCstLink::create([
                'opp_id' => $oppId,
                'cst_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->cstCode = '';
            $this->closeCstModal();
            $this->dispatch('closeModal', modalId: 'cstLinkModal');
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount opportunities linked successfully");
            $this->cstCode = '';
            $this->closeCstModal();
            $this->dispatch('closeModal', modalId: 'cstLinkModal');
        } elseif ($alreadyLinkedCount > 0) {
            // $this->cstLinkError = "Selected opportunities are already linked to this CST";
            $this->dispatch('alert', type: 'error', message: "Selected opportunities are already linked to this CST");
            $this->cstCode = '';
            $this->closeCstModal();
            $this->dispatch('closeModal', modalId: 'cstLinkModal');

            return;
        }

        // Clear inputs and close modal
        $this->cstCode = '';
        $this->closeCstModal();
        $this->dispatch('closeModal', modalId: 'cstLinkModal');
    }



    // New methods for MCP linking

    public function openMcpModal()
    {
        if (empty($this->selectedRows)) {
            // session()->flash('error', 'Please select at least one opportunity to link');
            $this->dispatch('alert', type: 'error', message: "Please select at least one opportunity to link");

            return;
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
        if (empty($this->selectedRows)) {
            // $this->mcpLinkError = 'Please select at least one opportunity to link';
            $this->dispatch('alert', type: 'error', message: "Please select at least one opportunity to link");
            return;
        }

        // Find the candidate with the given code
        $candidate = Mcpdashboard::where('mcp_code', $this->mcpCode)->first();

        if (!$candidate) {
            // $this->mcpLinkError = 'No data found with this MCP code';
            $this->dispatch('alert', type: 'error', message: "No data found with this MCP code");
            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
            return;
        }

        $linkedCount = 0;
        $alreadyLinkedCount = 0;

        // Link each selected opportunity to the CDT
        foreach ($this->selectedRows as $oppId) {
            // Check if already linked
            $existingLink = OppMcpLink::where('opp_id', $oppId)
                ->where('mcp_id', $candidate->id)
                ->first();

            if ($existingLink) {
                $alreadyLinkedCount++;
                continue;
            }

            // Create new link
            OppMcpLink::create([
                'opp_id' => $oppId,
                'mcp_id' => $candidate->id
            ]);

            $linkedCount++;
        }

        // Show appropriate message
        if ($linkedCount > 0 && $alreadyLinkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");
            $this->dispatch('alert', type: 'success', message: "$linkedCount opportunities linked successfully $alreadyLinkedCount were already linked.");

            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        } elseif ($linkedCount > 0) {
            // session()->flash('linkmessage', "$linkedCount opportunities linked successfully");
            $this->dispatch('alert', type: 'success', message: "$linkedCount opportunities linked successfully");

            $this->mcpCode = '';
            $this->closeMcpModal();
            $this->dispatch('closeModal', modalId: 'mcpLinkModal');
        } elseif ($alreadyLinkedCount > 0) {
            // $this->mcpLinkError = "Selected opportunities are already linked to this MCP";
            $this->dispatch('alert', type: 'error', message: "Selected opportunities are already linked to this MCP");

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
        $query = Oppdashboard::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('opportunity_date', 'like', '%' . $this->search . '%')
                    ->orWhere('opp_code', 'like', '%' . $this->search . '%')
                    ->orWhere('job_titles', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('postal_code_1', 'like', '%' . $this->search . '%')
                    ->orWhere('site_city', 'like', '%' . $this->search . '%')
                    ->orWhere('opportunity_status', 'like', '%' . $this->search . '%')
                    ->orWhere('remarks', 'like', '%' . $this->search . '%')
                    ->orWhere('trg_code', 'like', '%' . $this->search . '%')
                    ->orWhere('total_paid', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->codeopp) {
            $query->where('opp_code', 'like', '%' . $this->codeopp . '%');
        }

        if ($this->libelle) {
            $query->where('job_titles', 'like', '%' . $this->libelle . '%');
        }

        if ($this->company) {
            $query->where('name', 'like', '%' . $this->company . '%');
        }

        if ($this->statut !== '') {
            if ($this->statut == 'Open') {
                $query->where('opportunity_status', 'Open');
            } else if ($this->statut == 'Closed') {
                $query->where('opportunity_status', 'Closed');
            } else if ($this->statut == 'Filled') {
                $query->where('opportunity_status', 'Filled');
            }
        }

        if ($this->position) {
            $query->where('postal_code_1', 'like', '%' . $this->position . '%');
        }

        if ($this->remarks) {
            $query->where('remarks', 'like', '%' . $this->remarks . '%');
        }


        // $data = Oppdashboard::orderBy($this->sortField, $this->sortDirection)
        //     ->paginate(100);

        $data = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);


        if ($this->isEditing) {
            return view('livewire.back.oppform.edit');
        }

        return view('livewire.back.oppdashboard.admin', [
            'data' => $data
        ]);
    }
}
