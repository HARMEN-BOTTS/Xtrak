<?php

namespace App\Http\Controllers;

use App\Models\Trgdashboard;

class OppEvtController extends Controller
{
    public function index()
    {
        $data = Trgdashboard::all();
        return view('back.oppevtlist.admin', compact('data'));
    }
}



