<?php

namespace App\Http\Controllers;

use App\Models\Mcpdashboard;

class McplistController extends Controller
{
    public function index()
    {

        $data = Mcpdashboard::all();
        return view('back.mcplist.admin', compact('data'));
    }
}


