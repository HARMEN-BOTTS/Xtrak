<?php

namespace App\Http\Controllers;

use App\Models\Trgdashboard;
use Illuminate\Http\Request;

class TrgdashController extends Controller
{
    public function index()
    {

        $data = Trgdashboard::all();
        return view('back.trgdashboard.admin', compact('data'));
    }
}
