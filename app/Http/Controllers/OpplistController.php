<?php

namespace App\Http\Controllers;

use App\Models\CdtOppLink;

class OpplistController extends Controller
{
    public function index()
    {

        $data = CdtOppLink::all();
        return view('back.opplist.admin', compact('data'));
    }
}


