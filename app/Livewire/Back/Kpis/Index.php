<?php

namespace App\Livewire\Back\Kpis;

use Livewire\Component;
use App\Models\Kpisdashboard;
use Carbon\Carbon;

class Index extends Component
{
    public $trg_calls_done;
    public $trg_calls_obj;
    public $trg_wn_done;
    public $trg_nrp_done;
    public $trg_ctc_done;
    public $trg_ctc_obj;
    public $trg_rv_done;
    public $trg_rv_obj;
    public $trg_bqf_done;
    public $trg_bqf_obj;
    public $trg_klf_done;
    public $trg_klf_obj;
    public $trg_hrd_done;
    public $trg_hrd_obj;
    public $cdt_calls_done;
    public $cdt_calls_obj;
    public $cdt_ctc_done;
    public $cdt_refs_done;
    public $cdt_cv_done;
    public $cdt_cv_obj;
    public $cdt_push_done;
    public $cdt_push_obj;
    public $cdt_cre_done;
    public $cdt_cre_obj;
    public $cdt_ctc_obj;
    public $cdt_refs_obj;

    public $trg_date;
    public $ctc_date;

    public $editId;
    public $isEditing = false;

    public $entries;
    public $latestEntry;
    // public $latestTrgEntry;
    // public $latestCdtEntry;
    public $latestTrgDoneEntry;
    public $latestTrgObjEntry;
    public $latestCdtDoneEntry;
    public $latestCdtObjEntry;
    public $showForm = false;
    public $showFormTRG = false;
    public $showFormOBJ = false;

    public $averages = [
        '7_days' => [],
        '30_days' => [],
        '12_months' => [],
        'overall' => []
    ];


    // public function toggleForm()
    // {
    //     $this->showForm = !$this->showForm;

    //     if ($this->showForm) {
    //         $this->loadFormWithLatestData();
    //     } else {
    //         $this->resetForm();
    //     }
    // }

    public function toggleForm()
    {
        $this->showFormTRG = false;
        $this->showFormOBJ = false;

        $this->showForm = !$this->showForm;

        if ($this->showForm) {
            $this->loadFormWithLatestData();
            $this->ctc_date = now()->format('Y-m-d');
        } else {
            $this->resetForm();
        }
    }

    public function toggleFormTRG()
    {
        $this->showForm = false;
        $this->showFormOBJ = false;

        $this->showFormTRG = !$this->showFormTRG;

        if ($this->showFormTRG) {
            $this->loadFormWithLatestData();
            $this->trg_date = now()->format('Y-m-d');
        } else {
            $this->resetForm();
        }
    }

    public function toggleFormOBJ()
    {
        $this->showForm = false;
        $this->showFormTRG = false;

        $this->showFormOBJ = !$this->showFormOBJ;

        if ($this->showFormOBJ) {
            $this->loadFormWithLatestData();
            $this->trg_date = now()->format('Y-m-d');
        } else {
            $this->resetForm();
        }
    }


    public function loadFormWithLatestData()
    {
        if ($this->latestTrgDoneEntry) {
            $this->trg_calls_done = $this->latestTrgDoneEntry->trg_calls_done;
            $this->trg_wn_done = $this->latestTrgDoneEntry->trg_wn_done;
            $this->trg_nrp_done = $this->latestTrgDoneEntry->trg_nrp_done;
            $this->trg_ctc_done = $this->latestTrgDoneEntry->trg_ctc_done;
            $this->trg_rv_done = $this->latestTrgDoneEntry->trg_rv_done;
            $this->trg_bqf_done = $this->latestTrgDoneEntry->trg_bqf_done;
            $this->trg_klf_done = $this->latestTrgDoneEntry->trg_klf_done;
            $this->trg_hrd_done = $this->latestTrgDoneEntry->trg_hrd_done;
        }

        if ($this->latestTrgObjEntry) {
            $this->trg_calls_obj = $this->latestTrgObjEntry->trg_calls_obj;
            $this->trg_ctc_obj = $this->latestTrgObjEntry->trg_ctc_obj;
            $this->trg_rv_obj = $this->latestTrgObjEntry->trg_rv_obj;
            $this->trg_bqf_obj = $this->latestTrgObjEntry->trg_bqf_obj;
            $this->trg_klf_obj = $this->latestTrgObjEntry->trg_klf_obj;
            $this->trg_hrd_obj = $this->latestTrgObjEntry->trg_hrd_obj;
            $this->trg_date = $this->latestTrgObjEntry->trg_date;
        }

        if ($this->latestCdtDoneEntry) {
            $this->cdt_calls_done = $this->latestCdtDoneEntry->cdt_calls_done;
            $this->cdt_ctc_done = $this->latestCdtDoneEntry->cdt_ctc_done;
            $this->cdt_cre_done = $this->latestCdtDoneEntry->cdt_cre_done;
            $this->cdt_refs_done = $this->latestCdtDoneEntry->cdt_refs_done;
            $this->cdt_cv_done = $this->latestCdtDoneEntry->cdt_cv_done;
            $this->cdt_push_done = $this->latestCdtDoneEntry->cdt_push_done;
        }

        if ($this->latestCdtObjEntry) {
            $this->cdt_calls_obj = $this->latestCdtObjEntry->cdt_calls_obj;
            $this->cdt_ctc_obj = $this->latestCdtObjEntry->cdt_ctc_obj;
            $this->cdt_cre_obj = $this->latestCdtObjEntry->cdt_cre_obj;
            $this->cdt_refs_obj = $this->latestCdtObjEntry->cdt_refs_obj;
            $this->cdt_cv_obj = $this->latestCdtObjEntry->cdt_cv_obj;
            $this->cdt_push_obj = $this->latestCdtObjEntry->cdt_push_obj;
            $this->ctc_date = $this->latestCdtObjEntry->ctc_date;
        }
    }


    public function mount()
    {
        $this->loadEntries();
        $this->loadLatestEntry();
        $this->calculateAverages();
        $this->ctc_date = date('Y-m-d');
        $this->trg_date = date('Y-m-d');
    }

    public function calculateAverages()
    {
        $entries = Kpisdashboard::orderBy('created_at', 'desc')->get();
        $this->calculatePeriodAverages($entries);
    }

    private function calculatePeriodAverages($entries)
    {
        $columns = [

            'trg_calls_done',
            'trg_wn_done',
            'trg_nrp_done',
            'trg_ctc_done',
            'trg_rv_done',
            'trg_bqf_done',
            'trg_klf_done',
            'trg_hrd_done',

            'trg_calls_obj',
            'trg_ctc_obj',
            'trg_rv_obj',
            'trg_bqf_obj',
            'trg_klf_obj',
            'trg_hrd_obj',

            'cdt_calls_done',
            'cdt_ctc_done',
            'cdt_refs_done',
            'cdt_cv_done',
            'cdt_push_done',
            'cdt_cre_done',

            'cdt_calls_obj',
            'cdt_cv_obj',
            'cdt_push_obj',
            'cdt_cre_obj',
            'cdt_ctc_obj',
            'cdt_refs_obj'
        ];


        $now = Carbon::now();


        foreach ($columns as $column) {

            $last7Days = $entries->filter(function ($entry) use ($now, $column) {
                $entryDate = Carbon::parse($entry->created_at);
                return $entryDate->diffInDays($now) <= 7 && $entry->$column !== null;
            });
            $this->averages['7_days'][$column] = $last7Days->count() > 0
                ? $last7Days->avg($column)
                : 0;


            $last30Days = $entries->filter(function ($entry) use ($now, $column) {
                $entryDate = Carbon::parse($entry->created_at);
                return $entryDate->diffInDays($now) <= 30 && $entry->$column !== null;
            });
            $this->averages['30_days'][$column] = $last30Days->count() > 0
                ? $last30Days->avg($column)
                : 0;


            $last12Months = $entries->filter(function ($entry) use ($now, $column) {
                $entryDate = Carbon::parse($entry->created_at);
                return $entryDate->diffInMonths($now) <= 12 && $entry->$column !== null;
            });
            $this->averages['12_months'][$column] = $last12Months->count() > 0
                ? round($last12Months->avg($column))
                : 0;


            $overallEntries = $entries->filter(function ($entry) use ($column) {
                return $entry->$column !== null;
            });
            $this->averages['overall'][$column] = $overallEntries->count() > 0
                ? $overallEntries->avg($column)
                : 0;
        }
    }


    public function loadEntries()
    {
        $this->entries = Kpisdashboard::all();
    }

    // public function loadLatestEntry()
    // {
    //     // $this->latestEntry = Kpisdashboard::latest()->first();
    //     // $this->latestEntry = Kpisdashboard::orderBy('id', 'desc')->first();
    //     $this->latestTrgEntry = Kpisdashboard::where(function ($query) {
    //         $query->whereNotNull('trg_calls_done')
    //             ->orWhereNotNull('trg_calls_obj')
    //             ->orWhereNotNull('trg_wn_done')
    //             ->orWhereNotNull('trg_nrp_done')
    //             ->orWhereNotNull('trg_ctc_done')
    //             ->orWhereNotNull('trg_ctc_obj')
    //             ->orWhereNotNull('trg_rv_done')
    //             ->orWhereNotNull('trg_rv_obj')
    //             ->orWhereNotNull('trg_bqf_done')
    //             ->orWhereNotNull('trg_bqf_obj')
    //             ->orWhereNotNull('trg_klf_done')
    //             ->orWhereNotNull('trg_klf_obj')
    //             ->orWhereNotNull('trg_hrd_done')
    //             ->orWhereNotNull('trg_hrd_obj');
    //     })
    //         ->orderBy('id', 'desc')
    //         ->first();

    //     $this->latestCdtEntry = Kpisdashboard::where(function ($query) {
    //         $query->whereNotNull('cdt_calls_done')
    //             ->orWhereNotNull('cdt_calls_obj')
    //             ->orWhereNotNull('cdt_ctc_done')
    //             ->orWhereNotNull('cdt_refs_done')
    //             ->orWhereNotNull('cdt_cv_done')
    //             ->orWhereNotNull('cdt_cv_obj')
    //             ->orWhereNotNull('cdt_push_done')
    //             ->orWhereNotNull('cdt_push_obj')
    //             ->orWhereNotNull('cdt_cre_done')
    //             ->orWhereNotNull('cdt_cre_obj')
    //             ->orWhereNotNull('cdt_ctc_obj')
    //             ->orWhereNotNull('cdt_refs_obj');
    //     })
    //         ->orderBy('id', 'desc')
    //         ->first();
    // }

    public function loadLatestEntry()
    {
        $this->latestTrgDoneEntry = Kpisdashboard::where(function ($query) {
            $query->whereNotNull('trg_calls_done')
                ->orWhereNotNull('trg_wn_done')
                ->orWhereNotNull('trg_nrp_done')
                ->orWhereNotNull('trg_ctc_done')
                ->orWhereNotNull('trg_rv_done')
                ->orWhereNotNull('trg_bqf_done')
                ->orWhereNotNull('trg_klf_done')
                ->orWhereNotNull('trg_hrd_done');
        })
            ->orderBy('id', 'desc')
            ->first();

        $this->latestTrgObjEntry = Kpisdashboard::where(function ($query) {
            $query->whereNotNull('trg_calls_obj')
                ->orWhereNotNull('trg_ctc_obj')
                ->orWhereNotNull('trg_rv_obj')
                ->orWhereNotNull('trg_bqf_obj')
                ->orWhereNotNull('trg_klf_obj')
                ->orWhereNotNull('trg_hrd_obj');
        })
            ->orderBy('id', 'desc')
            ->first();

        $this->latestCdtDoneEntry = Kpisdashboard::where(function ($query) {
            $query->whereNotNull('cdt_calls_done')
                ->orWhereNotNull('cdt_ctc_done')
                ->orWhereNotNull('cdt_refs_done')
                ->orWhereNotNull('cdt_cv_done')
                ->orWhereNotNull('cdt_push_done')
                ->orWhereNotNull('cdt_cre_done');
        })
            ->orderBy('id', 'desc')
            ->first();

        $this->latestCdtObjEntry = Kpisdashboard::where(function ($query) {
            $query->whereNotNull('cdt_calls_obj')
                ->orWhereNotNull('cdt_cv_obj')
                ->orWhereNotNull('cdt_push_obj')
                ->orWhereNotNull('cdt_cre_obj')
                ->orWhereNotNull('cdt_ctc_obj')
                ->orWhereNotNull('cdt_refs_obj');
        })
            ->orderBy('id', 'desc')
            ->first();
    }

    public function save()
    {

        if ($this->isEditing) {
            $entry = Kpisdashboard::find($this->editId);
            if ($entry) {
                $entry->update([
                    'trg_calls_done' => $this->trg_calls_done,
                    'trg_calls_obj' => $this->trg_calls_obj,
                    'trg_wn_done' => $this->trg_wn_done,
                    'trg_nrp_done' => $this->trg_nrp_done,
                    'trg_ctc_done' => $this->trg_ctc_done,
                    'trg_ctc_obj' => $this->trg_ctc_obj,
                    'trg_rv_done' => $this->trg_rv_done,
                    'trg_rv_obj' => $this->trg_rv_obj,
                    'trg_bqf_done' => $this->trg_bqf_done,
                    'trg_bqf_obj' => $this->trg_bqf_obj,
                    'trg_klf_done' => $this->trg_klf_done,
                    'trg_klf_obj' => $this->trg_klf_obj,
                    'trg_hrd_done' => $this->trg_hrd_done,
                    'trg_hrd_obj' => $this->trg_hrd_obj,
                    'cdt_calls_done' => $this->cdt_calls_done,
                    'cdt_calls_obj' => $this->cdt_calls_obj,
                    'cdt_ctc_done' => $this->cdt_ctc_done,
                    'cdt_refs_done' => $this->cdt_refs_done,
                    'cdt_cv_done' => $this->cdt_cv_done,
                    'cdt_cv_obj' => $this->cdt_cv_obj,
                    'cdt_push_done' => $this->cdt_push_done,
                    'cdt_push_obj' => $this->cdt_push_obj,
                    'cdt_cre_done' => $this->cdt_cre_done,
                    'cdt_cre_obj' => $this->cdt_cre_obj,
                    'cdt_ctc_obj' => $this->cdt_ctc_obj,
                    'cdt_refs_obj' => $this->cdt_refs_obj,
                    'trg_date' => $this->trg_date,
                    'ctc_date' => $this->ctc_date,
                ]);

                session()->flash('message', 'Record updated successfully!');
            }
        } else {
            Kpisdashboard::create([
                'trg_calls_done' => $this->trg_calls_done,
                'trg_calls_obj' => $this->trg_calls_obj,
                'trg_wn_done' => $this->trg_wn_done,
                'trg_nrp_done' => $this->trg_nrp_done,
                'trg_ctc_done' => $this->trg_ctc_done,
                'trg_ctc_obj' => $this->trg_ctc_obj,
                'trg_rv_done' => $this->trg_rv_done,
                'trg_rv_obj' => $this->trg_rv_obj,
                'trg_bqf_done' => $this->trg_bqf_done,
                'trg_bqf_obj' => $this->trg_bqf_obj,
                'trg_klf_done' => $this->trg_klf_done,
                'trg_klf_obj' => $this->trg_klf_obj,
                'trg_hrd_done' => $this->trg_hrd_done,
                'trg_hrd_obj' => $this->trg_hrd_obj,
                'cdt_calls_done' => $this->cdt_calls_done,
                'cdt_calls_obj' => $this->cdt_calls_obj,
                'cdt_ctc_done' => $this->cdt_ctc_done,
                'cdt_refs_done' => $this->cdt_refs_done,
                'cdt_cv_done' => $this->cdt_cv_done,
                'cdt_cv_obj' => $this->cdt_cv_obj,
                'cdt_push_done' => $this->cdt_push_done,
                'cdt_push_obj' => $this->cdt_push_obj,
                'cdt_cre_done' => $this->cdt_cre_done,
                'cdt_cre_obj' => $this->cdt_cre_obj,
                'cdt_ctc_obj' => $this->cdt_ctc_obj,
                'cdt_refs_obj' => $this->cdt_refs_obj,
                'trg_date' => $this->trg_date,
                'ctc_date' => $this->ctc_date,
            ]);

            session()->flash('message', 'Capture Done Successfully ✅');
        }

        // $this->resetForm();
        $this->showForm = false;
        $this->showFormTRG = false;
        $this->showFormOBJ = false;
        $this->loadEntries();
        $this->loadLatestEntry();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->editId = $id;

        $entry = Kpisdashboard::find($id);

        if ($entry) {
            $this->trg_calls_done = $entry->trg_calls_done;
            $this->trg_calls_obj = $entry->trg_calls_obj;
            $this->trg_wn_done = $entry->trg_wn_done;
            $this->trg_nrp_done = $entry->trg_nrp_done;
            $this->trg_ctc_done = $entry->trg_ctc_done;
            $this->trg_ctc_obj = $entry->trg_ctc_obj;
            $this->trg_rv_done = $entry->trg_rv_done;
            $this->trg_rv_obj = $entry->trg_rv_obj;
            $this->trg_bqf_done = $entry->trg_bqf_done;
            $this->trg_bqf_obj = $entry->trg_bqf_obj;
            $this->trg_klf_done = $entry->trg_klf_done;
            $this->trg_klf_obj = $entry->trg_klf_obj;
            $this->trg_hrd_done = $entry->trg_hrd_done;
            $this->trg_hrd_obj = $entry->trg_hrd_obj;
            $this->cdt_calls_done = $entry->cdt_calls_done;
            $this->cdt_calls_obj = $entry->cdt_calls_obj;
            $this->cdt_ctc_done = $entry->cdt_ctc_done;
            $this->cdt_refs_done = $entry->cdt_refs_done;
            $this->cdt_cv_done = $entry->cdt_cv_done;
            $this->cdt_cv_obj = $entry->cdt_cv_obj;
            $this->cdt_push_done = $entry->cdt_push_done;
            $this->cdt_push_obj = $entry->cdt_push_obj;
            $this->cdt_cre_done = $entry->cdt_cre_done;
            $this->cdt_cre_obj = $entry->cdt_cre_obj;
            $this->cdt_ctc_obj = $entry->cdt_ctc_obj;
            $this->cdt_refs_obj = $entry->cdt_refs_obj;
            $this->trg_date = $entry->trg_date;
            $this->ctc_date = $entry->ctc_date;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'trg_calls_done',
            'trg_calls_obj',
            'trg_wn_done',
            'trg_nrp_done',
            'trg_ctc_done',
            'trg_ctc_obj',
            'trg_rv_done',
            'trg_rv_obj',
            'trg_bqf_done',
            'trg_bqf_obj',
            'trg_klf_done',
            'trg_klf_obj',
            'trg_hrd_done',
            'trg_hrd_obj',
            'cdt_calls_done',
            'cdt_calls_obj',
            'cdt_ctc_done',
            'cdt_refs_done',
            'cdt_cv_done',
            'cdt_cv_obj',
            'cdt_push_done',
            'cdt_push_obj',
            'cdt_cre_done',
            'cdt_cre_obj',
            'cdt_ctc_obj',
            'cdt_refs_obj',
            'trg_date',
            'ctc_date'
        ]);

        $this->isEditing = false;
        $this->editId = null;
        $this->ctc_date = date('Y-m-d');
        $this->trg_date = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.back.kpis.index', [
            'averages' => $this->averages
        ]);
    }
}
