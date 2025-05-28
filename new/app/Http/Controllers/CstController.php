<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cstdashboard;

class CstController extends Controller
{
    public function index()
    {
        $entries = Cstdashboard::all();
        return view('back.cstform.index', compact('entries'));
    }

    public function edit($id)
    {
        $entry = Cstdashboard::findOrFail($id);
        return view('back.cstform.edit', compact('entry'));
    }
}



