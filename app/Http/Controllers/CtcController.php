<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ctcdashboard;

class CtcController extends Controller
{
    public function index()
    {
        $entries = Ctcdashboard::all();
        return view('back.ctcform.index', compact('entries'));
    }

    public function edit($id)
    {
        $entry = Ctcdashboard::findOrFail($id);
        return view('back.ctcform.edit', compact('entry'));
    }
}



