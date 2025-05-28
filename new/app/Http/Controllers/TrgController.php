<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trgdashboard;

class TrgController extends Controller
{
    public function index()
    {
        $entries = Trgdashboard::all();
        return view('back.trgform.index', compact('entries'));
    }

    public function edit($id)
    {
        $entry = Trgdashboard::findOrFail($id);
        return view('back.trgform.edit', compact('entry'));
    }
}



