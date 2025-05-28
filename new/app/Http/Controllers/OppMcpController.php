<?php

namespace App\Http\Controllers;

use App\Models\OppMcpLink;

class OppMcpController extends Controller
{
    public function index()
    {
        $data = OppMcpLink::all();
        return view('back.oppmcplist.admin', compact('data'));
    }
}
