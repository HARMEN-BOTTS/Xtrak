<?php

namespace App\Livewire\Back\Summary;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class Index extends Component
{
    public $usersWithLoginTimes;
    public $users;
    public $user_id;

    public function mount()
    {
        $this->fetchUsersWithLoginTimes();
    }

    public function updatedUserId($id)
    {
        if ($id == null) {
            $this->fetchUsersWithLoginTimes();
        } else {
            $this->fetchUserWithLoginTimes($id);
        }
    }

    public function refreshData()
    {
        if ($this->user_id) {
            $this->fetchUserWithLoginTimes($this->user_id);
        } else {
            $this->fetchUsersWithLoginTimes();
        }
    }

    private function fetchUsersWithLoginTimes()
    {
        $this->users = User::orderBy('last_name')->get();
        $this->usersWithLoginTimes = collect();

        foreach ($this->users as $user) {
            $this->calculateLoginTimes($user);
        }
    }

    private function fetchUserWithLoginTimes($id)
    {
        $user = User::findOrFail($id);
        $this->usersWithLoginTimes = collect();
        $this->calculateLoginTimes($user);
    }

    private function calculateLoginTimes($user)
    {
        // $totalLoginTime = $user->userLogins->sum('duration');
        // $loginsToday = $user->userLogins->where('login_at', '>=', Carbon::today())->sum('duration');
        // $loginsThisWeek = $user->userLogins->whereBetween('login_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('duration');
        // $loginsThisMonth = $user->userLogins()->whereMonth('login_at', Carbon::now()->month)->get()->sum('duration');


        $totalLoginTime = $user->userLogins->sum('duration');
        $loginsToday = $user->userLogins->where('login_at', '>=', Carbon::today())->sum('duration');
        // 7 derniers jours
        $loginsThisWeek =  $user->userLogins->where('login_at', '>=', Carbon::now()->subDays(7))->sum('duration');
        // 30 derniers jours
        $loginsThisMonth =$user->userLogins->where('login_at', '>=', Carbon::now()->subDays(30))->sum('duration');


        $this->usersWithLoginTimes->push([
            'user' => $user,
            'total_login_time' => $totalLoginTime,
            'login_time_today' => $loginsToday,
            'login_time_this_week' => $loginsThisWeek,
            'login_time_this_month' => $loginsThisMonth,
        ]);
    }

    public function render()
    {
        return view('livewire.back.summary.index', [
            'usersWithLoginTimes' => $this->usersWithLoginTimes,
            'users' => $this->users
        ])->extends('layouts.app')
          ->section('content')
          ->with(['refreshInterval' => 3000]); 
    }
}




// // COPIE 2  

// <?php

// namespace App\Livewire\Back\Summary;

// use App\Models\User;
// use Livewire\Component;
// use Carbon\Carbon;
// class Index extends Component
// {
//     public $usersWithLoginCounts;
//     public $users;
//     public $user_id;
//     public $usersWithLoginTimes;

//     public function mount()
//     {
//         $this->users = User::orderBy('last_name')->get();

//         $this->usersWithLoginTimes = collect();

//         foreach ($this->users as $user) {
//             $totalLoginTime = $user->userLogins->sum('duration');

//             $loginsToday = $user->userLogins->where('login_at', '>=', Carbon::today())->sum('duration');

//             $loginsThisWeek = $user->userLogins->whereBetween('login_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('duration');

//             $loginsThisMonth = $user
//                 ->userLogins()
//                 ->whereMonth('login_at', Carbon::now()->month)
//                 ->get()
//                 ->sum('duration');

//             $this->usersWithLoginTimes->push([
//                 'user' => $user,
//                 'total_login_time' => $totalLoginTime,
//                 'login_time_today' => $loginsToday,
//                 'login_time_this_week' => $loginsThisWeek,
//                 'login_time_this_month' => $loginsThisMonth,
//             ]);
//         }
//     }
//     //         'userLogins as logins_today' => function ($query) {
//     //             $query->whereDate('login_at', Carbon::today());
//     //         },
//     //         'userLogins as logins_this_week' => function ($query) {
//     //             $query->whereBetween('login_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
//     //         },
//     //         'userLogins as logins_this_month' => function ($query) {
//     //             $query->whereMonth('login_at', Carbon::now()->month);
//     //         },
//     //         'userLogins as total_logins',
//     //     ])->get();
//     // }
//     public function updatedUserId($id)
//     {
//         if ($id == null) {
//             $this->usersWithLoginTimes = collect();

//             foreach ($this->users as $user) {
//                 $totalLoginTime = $user->userLogins->sum('duration');

//                 $loginsToday = $user->userLogins->where('login_at', '>=', Carbon::today())->sum('duration');

//                 $loginsThisWeek = $user->userLogins->whereBetween('login_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('duration');

//                 $loginsThisMonth = $user
//                     ->userLogins()
//                     ->whereMonth('login_at', Carbon::now()->month)
//                     ->get()
//                     ->sum('duration');

//                 $this->usersWithLoginTimes->push([
//                     'user' => $user,
//                     'total_login_time' => $totalLoginTime,
//                     'login_time_today' => $loginsToday,
//                     'login_time_this_week' => $loginsThisWeek,
//                     'login_time_this_month' => $loginsThisMonth,
//                 ]);
//             }
//             return;
//         }
//         $user = User::findOrFail($id);

//         $loginsToday = $user->userLogins->where('login_at', '>=', Carbon::today())->sum('duration');

//         $loginsThisWeek = $user->userLogins->whereBetween('login_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('duration');

//         $loginsThisMonth = $user
//             ->userLogins()
//             ->whereMonth('login_at', Carbon::now()->month)
//             ->sum('duration');

//         $totalLoginTime = $user->userLogins->sum('duration');

//         $this->usersWithLoginTimes = collect([
//             [
//                 'user' => $user,
//                 'total_login_time' => $totalLoginTime,
//                 'login_time_today' => $loginsToday,
//                 'login_time_this_week' => $loginsThisWeek,
//                 'login_time_this_month' => $loginsThisMonth,
//             ],
//         ]);
//     }

//     // public function updatedUserId($id)
//     // {
//     //     if ($id) {
//     //         $this->usersWithLoginCounts = User::where('id', $id)
//     //             ->withCount([
//     //                 'userLogins',
//     //                 'userLogins as logins_today' => function ($query) {
//     //                     $query->whereDate('login_at', Carbon::today());
//     //                 },
//     //                 'userLogins as logins_this_week' => function ($query) {
//     //                     $query->whereBetween('login_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
//     //                 },
//     //                 'userLogins as logins_this_month' => function ($query) {
//     //                     $query->whereMonth('login_at', Carbon::now()->month);
//     //                 },
//     //                 'userLogins as total_logins',
//     //             ])
//     //             ->get();
//     //     } else {
//     //         $this->usersWithLoginCounts = User::withCount([
//     //             'userLogins',
//     //             'userLogins as logins_today' => function ($query) {
//     //                 $query->whereDate('login_at', Carbon::today());
//     //             },
//     //             'userLogins as logins_this_week' => function ($query) {
//     //                 $query->whereBetween('login_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
//     //             },
//     //             'userLogins as logins_this_month' => function ($query) {
//     //                 $query->whereMonth('login_at', Carbon::now()->month);
//     //             },
//     //             'userLogins as total_logins',
//     //         ])->get();
//     //     }
//     // }
//     public function render()
//     {
//         return view('livewire.back.summary.index');
//     }
// }
