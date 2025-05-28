<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oppdashboard;

class OpportunityController extends Controller
{
    public function index()
    {
        $entries = Oppdashboard::all();
        return view('back.oppform.index', compact('entries'));
    }

    public function edit($id)
    {
        $entry = Oppdashboard::findOrFail($id);
        return view('back.oppform.edit', compact('entry'));
    }

    public function management()
    {
        return view('back.oppform.management');
    }

    public function evts()
    {
        return view('back.oppform.evts');
    }

}


