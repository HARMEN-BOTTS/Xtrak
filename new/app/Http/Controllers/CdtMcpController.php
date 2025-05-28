<?php

namespace App\Http\Controllers;

use App\Models\CdtMcpLink;

class CdtMcpController extends Controller
{
    public function index()
    {
        $data = CdtMcpLink::all();
        return view('back.cdtmcplist.admin', compact('data'));
    }
}



