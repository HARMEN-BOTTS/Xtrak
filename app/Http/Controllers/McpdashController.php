<?php

namespace App\Http\Controllers;

use App\Models\Mcpdashboard;

class McpdashController extends Controller
{
    public function index()
    {
        $data = Mcpdashboard::all();
        return view('back.mcpdashboard.admin', compact('data'));
    }
}





