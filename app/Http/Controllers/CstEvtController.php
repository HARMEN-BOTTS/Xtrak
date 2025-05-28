<?php

namespace App\Http\Controllers;

use App\Models\Trgdashboard;

class CstEvtController extends Controller
{
    public function index()
    {
        $data = Trgdashboard::all();
        return view('back.cstevtlist.admin', compact('data'));
    }
}
