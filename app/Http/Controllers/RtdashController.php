<?php

namespace App\Http\Controllers;

use App\Models\Rtdashboard;

class RtdashController extends Controller
{
    public function index()
    {
        $data = Rtdashboard::all();
        return view('back.rtdashboard.admin', compact('data'));
    }
}





