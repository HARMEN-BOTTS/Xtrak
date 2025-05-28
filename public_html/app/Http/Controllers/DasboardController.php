<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class DasboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('Administrateur')) {
            // if (request()->query('dashboard') === 'consultant') {
            //     return view('back.dashboard.consultant');
            // }
            return view('back.dashboard.admin');
        } //vue manager à personnaliser plus tard
        elseif (auth()->user()->hasRole('Manager')) {
            return view('back.dashboard.admin');
        } elseif (auth()->user()->hasRole('CST+')) {
            if (request()->query('dashboard') === 'consultant') {
                return view('back.dashboard.consultant');
            }
            return view('back.dashboard.trunc');
        } else {
            return view('back.dashboard.consultant');
        }
        //return view('back.dashboard.index');
    }

    public function summary()
    {
        return view('back.dashboard.summary');
    }
    public function metier()
    {
        return view('back.dashboard.metier');
    }
    public function detail()
    {
        return view('back.dashboard.detail');
    }

    public function landings()
    {
        return view('back.dashboard.landings');
    }

    public function tables()
    {
        return view('back.dashboard.tables');
    }

    public function filtrages()
    {
        return view('back.dashboard.filtrages');
    }

    public function vue()
    {
        return view('back.dashboard.vue');
    }

    public function upload()
    {
        return view('back.dashboard.upload');
    }

    public function cdtvue()
    {
        return view('back.dashboard.cdtvue');

        // if (auth()->user()->hasRole('Administrateur')) {
        //     return view('back.dashboard.cdtvue');
        // } //vue manager à personnaliser plus tard
        // elseif (auth()->user()->hasRole('Manager')) {
        //     return view('back.dashboard.cdtvue');
        // } else {
        //     return view('back.dashboard.cdtvue');
        // }
    }

    public function oppvue()
    {
        return view('back.dashboard.oppvue');

        // if (auth()->user()->hasRole('Administrateur')) {
        //     return view('back.dashboard.oppvue');
        // } //vue manager à personnaliser plus tard
        // elseif (auth()->user()->hasRole('Manager')) {
        //     return view('back.dashboard.oppvue');
        // } else {
        //    return view('back.dashboard.oppvue');
        // }
    }

    public function trgvue()
    {
        return view('back.dashboard.trgvue');
    }

    public function facvue()
    {
        return view('back.dashboard.facvue');
    }

    public function formcdt()
    {
        return view('back.dashboard.formcdt');
    }

    public function formopp()
    {
        return view('back.dashboard.formopp');
    }

    public function canevascdt()
    {
        return view('back.dashboard.canevascdt');
    }

    public function canevasann()
    {
        return view('back.dashboard.canevasann');
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
