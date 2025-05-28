<?php

namespace App\Livewire\Back\Detail;

use Livewire\Component;
use App\Models\User;
use App\Models\Candidate;
use Carbon\Carbon;

class Index extends Component
{
    public $usersWithCandidateCounts;
    public $users;
    public $user_id;
    public function mount()
    {
        $this->users = User::orderBy('last_name')->get();
        $this->usersWithCandidateCounts = User::whereHas('candidates', function ($query) {
            $query->whereHas('candidateState', function ($subQuery) {
                $subQuery->where('name', '!=', 'Doublon');
            });
        })
            ->withCount([
                'candidates',
                'candidates as candidates_today' => function ($query) {
                    $query->whereDate('created_at', Carbon::today());
                },
                'candidates as candidates_this_week' => function ($query) {
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                },
                'candidates as candidates_this_month' => function ($query) {
                    $query->whereMonth('created_at', Carbon::now()->month);
                },
                'candidates as total_candidates',
            ])
            ->get();
    }
    public function updatedUserId($id)
    {
        if ($id) {
            $this->usersWithCandidateCounts = User::where('id', $id)
                ->whereHas('candidates', function ($query) {
                    $query->whereHas('candidateState', function ($subQuery) {
                        $subQuery->where('name', '!=', 'Doublon');
                    });
                })
                ->withCount([
                    'candidates',
                    'candidates as candidates_today' => function ($query) {
                        $query->whereDate('created_at', Carbon::today());
                    },
                    'candidates as candidates_this_week' => function ($query) {
                        $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    },
                    'candidates as candidates_this_month' => function ($query) {
                        $query->whereMonth('created_at', Carbon::now()->month);
                    },
                    'candidates as total_candidates',
                ])
                ->get();
        } else {
            $this->usersWithCandidateCounts = User::whereHas('candidates', function ($query) {
                $query->whereHas('candidateState', function ($subQuery) {
                    $subQuery->where('name', '!=', 'Doublon');
                });
            })
                ->withCount([
                    'candidates',
                    'candidates as candidates_today' => function ($query) {
                        $query->whereDate('created_at', Carbon::today());
                    },
                    'candidates as candidates_this_week' => function ($query) {
                        $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    },
                    'candidates as candidates_this_month' => function ($query) {
                        $query->whereMonth('created_at', Carbon::now()->month);
                    },
                    'candidates as total_candidates',
                ])
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.back.detail.index');
    }
}
