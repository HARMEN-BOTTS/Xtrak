<?php

namespace App\Http\Controllers;

use App\Models\Trgdashboard;

class CdtEvtController extends Controller
{
    public function index()
    {
        $data = Trgdashboard::all();
        return view('back.cdtevtlist.admin', compact('data'));
    }
}
