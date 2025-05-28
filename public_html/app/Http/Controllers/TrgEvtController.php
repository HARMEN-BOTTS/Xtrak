<?php

namespace App\Http\Controllers;

use App\Models\Trgdashboard;

class TrgEvtController extends Controller
{
    public function index()
    {
        $data = Trgdashboard::all();
        return view('back.trgevtlist.admin', compact('data'));
    }
}
