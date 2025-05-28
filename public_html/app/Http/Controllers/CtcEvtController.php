<?php

namespace App\Http\Controllers;

use App\Models\Trgdashboard;

class CtcEvtController extends Controller
{
    public function index()
    {
        $data = Trgdashboard::all();
        return view('back.ctcevtlist.admin', compact('data'));
    }
}
