<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rtdashboard;

class RtController extends Controller
{
    public function index()
    {
        $entries = Rtdashboard::all();
        return view('back.rtform.index', compact('entries'));
    }

    public function edit($id)
    {
        $entry = Rtdashboard::findOrFail($id);
        return view('back.rtform.edit', compact('entry'));
    }
}





