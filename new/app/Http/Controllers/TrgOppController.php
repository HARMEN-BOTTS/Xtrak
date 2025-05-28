<?php

namespace App\Http\Controllers;

use App\Models\TrgOppLink;

class TrgOppController extends Controller
{
    public function index()
    {
        $data = TrgOppLink::all();
        return view('back.trgopplist.admin', compact('data'));
    }
}


