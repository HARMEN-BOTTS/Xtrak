<?php

namespace App\Http\Controllers;

use App\Models\McpTrgLink;

class McpDstController extends Controller
{
    public function index()
    {
        $data = McpTrgLink::all();
        return view('back.mcpdstlist.admin', compact('data'));
    }
}

