<?php

namespace App\Http\Controllers;

use App\Models\Ctcdashboard;

class CtcdashController extends Controller
{
    public function index()
    {

        $data = Ctcdashboard::all();
        return view('back.ctcdashboard.admin', compact('data'));
    }
}


