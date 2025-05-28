<?php

namespace App\Http\Controllers;

use App\Models\Oppdashboard;

class OppdashController extends Controller
{
    public function index()
    {

        $data = Oppdashboard::all();
        return view('back.oppdashboard.admin', compact('data'));
    }
}






