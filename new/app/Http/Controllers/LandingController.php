<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('Administrateur')) {
            return view('back.landing.admin');
        } //vue manager à personnaliser plus tard
        elseif (auth()->user()->hasRole('Manager')) {
            return view('back.landing.manager');
        } elseif (auth()->user()->hasRole('CST+')) {
            // if (request()->query('dashboard') === 'consultant') {
            //     return view('back.landing.cstplus');
            // }
            return view('back.landing.cstplus');
        } else {
            return view('back.landing.consultant');
        }
        //return view('back.dashboard.index');
    }

    public function kpis()
    {
        return view('back.landing.kpis');
    }

    public function trgform()
    {
        return view('back.landing.trgform');
    }

    public function ctcform()
    {
        return view('back.landing.ctcform');
    }


    public function commande($param)
    {
        if ($param == 'optimize') {
            \Artisan::call('view:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('cache:clear');
            \Artisan::call('optimize:clear');
        } elseif ($param == 'passport') {
            \Artisan::call('passport:install');
        } elseif ($param == 'migrate') {
            \Artisan::call('migrate:fresh --seed');
        } elseif ($param == 'storage') {
            \Artisan::call('storage:link');
        }

        // elseif ($param == 'migrate-no-seed') {
        //     \Artisan::call('migrate');
        // }
    }
}
