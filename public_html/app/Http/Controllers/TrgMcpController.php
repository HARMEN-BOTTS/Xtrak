<?php

namespace App\Http\Controllers;

use App\Models\TrgMcpLink;

class TrgMcpController extends Controller
{
    public function index()
    {
        $data = TrgMcpLink::all();
        return view('back.trgmcplist.admin', compact('data'));
    }
}

