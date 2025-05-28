<?php

namespace App\Http\Controllers;

use App\Models\OppCstLink;

class OppCstController extends Controller
{
    public function index()
    {
        $data = OppCstLink::all();
        return view('back.oppcstlist.admin', compact('data'));
    }
}
