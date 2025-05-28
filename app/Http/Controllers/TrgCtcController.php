<?php

namespace App\Http\Controllers;

use App\Models\TrgCtcLink;

class TrgCtcController extends Controller
{
    public function index()
    {
        $data = TrgCtcLink::all();
        return view('back.trgctclist.admin', compact('data'));
    }
}
