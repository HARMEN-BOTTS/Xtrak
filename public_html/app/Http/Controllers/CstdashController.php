<?php

namespace App\Http\Controllers;

use App\Models\Cstdashboard;

class CstdashController extends Controller
{
    public function index()
    {
        $data = Cstdashboard::all();
        return view('back.cstdashboard.admin', compact('data'));
    }
}





