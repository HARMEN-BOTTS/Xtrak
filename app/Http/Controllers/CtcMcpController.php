<?php

namespace App\Http\Controllers;

use App\Models\CtcMcpLink;

class CtcMcpController extends Controller
{
    public function index()
    {
        $data = CtcMcpLink::all();
        return view('back.ctcmcplist.admin', compact('data'));
    }
}

