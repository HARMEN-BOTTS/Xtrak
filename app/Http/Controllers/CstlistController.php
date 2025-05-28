<?php

namespace App\Http\Controllers;

use App\Models\Ctcdashboard;

class CstlistController extends Controller
{
    public function index()
    {

        $data = Ctcdashboard::all();
        return view('back.cstlist.admin', compact('data'));
    }
}


