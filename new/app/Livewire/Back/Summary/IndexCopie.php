<?php

namespace App\Livewire\Back\Summary;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class Index extends Component
{
    public $usersWithLoginCounts;
    public $users;
    public $user_id;
    public $usersWithLoginTimes;

    public function mount()
    {
        $this->users = User::orderBy('last_name')->get();
        $this->calculateLoginTimes();
    }

    public function calculateLoginTimes()
    {
        $this->usersWithLoginTimes = collect();

        foreach ($this->users as $user) {
            $totalLoginTime = $user->userLogins->reduce(function ($carry, $login) {
                $logoutAt = $login->logout_at ? Carbon::parse($login->logout_at) : Carbon::now();
                $loginAt = Carbon::parse($login->login_at);
                return $carry + $logoutAt->diffInSeconds($loginAt);
            }, 0);

            $loginsToday = $user->userLogins->filter(function ($login) {
                return $login->login_at >= Carbon::today();
            })->reduce(function ($carry, $login) {
                $logoutAt = $login->logout_at ? Carbon::parse($login->logout_at) : Carbon::now();
                $loginAt = Carbon::parse($login->login_at);
                return $carry + $logoutAt->diffInSeconds($loginAt);
            }, 0);

            $loginsThisWeek = $user->userLogins->filter(function ($login) {
                return $login->login_at >= Carbon::now()->startOfWeek() && $login->login_at <= Carbon::now()->endOfWeek();
            })->reduce(function ($carry, $login) {
                $logoutAt = $login->logout_at ? Carbon::parse($login->logout_at) : Carbon::now();
                $loginAt = Carbon::parse($login->login_at);
                return $carry + $logoutAt->diffInSeconds($loginAt);
            }, 0);

            $loginsThisMonth = $user->userLogins->filter(function ($login) {
                return $login->login_at >= Carbon::now()->startOfMonth() && $login->login_at <= Carbon::now()->endOfMonth();
            })->reduce(function ($carry, $login) {
                $logoutAt = $login->logout_at ? Carbon::parse($login->logout_at) : Carbon::now();
                $loginAt = Carbon::parse($login->login_at);
                return $carry + $logoutAt->diffInSeconds($loginAt);
            }, 0);

            $this->usersWithLoginTimes->push([
                'user' => $user,
                'total_login_time' => $totalLoginTime,
                'login_time_today' => $loginsToday,
                'login_time_this_week' => $loginsThisWeek,
                'login_time_this_month' => $loginsThisMonth,
            ]);
        }
    }

    public function updatedUserId($id)
    {
        if ($id == null) {
            $this->calculateLoginTimes();
            return;
        }

        $user = User::findOrFail($id);

        $totalLoginTime = $user->userLogins->reduce(function ($carry, $login) {
            $logoutAt = $login->logout_at ? Carbon::parse($login->logout_at) : Carbon::now();
            $loginAt = Carbon::parse($login->login_at);
            return $carry + $logoutAt->diffInSeconds($loginAt);
        }, 0);

        $loginsToday = $user->userLogins->filter(function ($login) {
            return $login->login_at >= Carbon::today();
        })->reduce(function ($carry, $login) {
            $logoutAt = $login->logout_at ? Carbon::parse($login->logout_at) : Carbon::now();
            $loginAt = Carbon::parse($login->login_at);
            return $carry + $logoutAt->diffInSeconds($loginAt);
        }, 0);

        $loginsThisWeek = $user->userLogins->filter(function ($login) {
            return $login->login_at >= Carbon::now()->startOfWeek() && $login->login_at <= Carbon::now()->endOfWeek();
        })->reduce(function ($carry, $login) {
            $logoutAt = $login->logout_at ? Carbon::parse($login->logout_at) : Carbon::now();
            $loginAt = Carbon::parse($login->login_at);
            return $carry + $logoutAt->diffInSeconds($loginAt);
        }, 0);

        $loginsThisMonth = $user->userLogins->filter(function ($login) {
            return $login->login_at >= Carbon::now()->startOfMonth() && $login->login_at <= Carbon::now()->endOfMonth();
        })->reduce(function ($carry, $login) {
            $logoutAt = $login->logout_at ? Carbon::parse($login->logout_at) : Carbon::now();
            $loginAt = Carbon::parse($login->login_at);
            return $carry + $logoutAt->diffInSeconds($loginAt);
        }, 0);

        $this->usersWithLoginTimes = collect([
            [
                'user' => $user,
                'total_login_time' => $totalLoginTime,
                'login_time_today' => $loginsToday,
                'login_time_this_week' => $loginsThisWeek,
                'login_time_this_month' => $loginsThisMonth,
            ],
        ]);
    }

    public function render()
    {
        return view('livewire.back.summary.index');
    }
}
