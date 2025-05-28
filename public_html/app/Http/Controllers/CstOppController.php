<?php

namespace App\Http\Controllers;

use App\Models\CstOppLink;

class CstOppController extends Controller
{
    public function index()
    {
        $data = CstOppLink::all();
        return view('back.cstopplist.admin', compact('data'));
    }
}



