<?php

namespace App\Http\Controllers;

use App\Models\OppCdtLink;

class OppCdtController extends Controller
{
    public function index()
    {
        $data = OppCdtLink::all();
        return view('back.oppcdtlist.admin', compact('data'));
    }
}
