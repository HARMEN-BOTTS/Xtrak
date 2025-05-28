<?php

namespace App\Http\Controllers;

use App\Models\Ctcdashboard;

class CtclistController extends Controller
{
    public function index()
    {

        $data = Ctcdashboard::all();
        return view('back.ctclist.admin', compact('data'));
    }
}


