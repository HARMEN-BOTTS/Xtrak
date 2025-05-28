<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpisdashboard;

class KpisController extends Controller
{
    public function index()
    {
        $entries = Kpisdashboard::all();
        return view('back.kpis.index', compact('entries'));
    }

    public function edit($id)
    {
        $entry = Kpisdashboard::findOrFail($id);
        return view('back.kpis.edit', compact('entry'));
    }
}



