<?php

namespace App\Http\Controllers;

use App\Models\Trgdashboard;

class McpEvtController extends Controller
{
    public function index()
    {
        $data = Trgdashboard::all();
        return view('back.mcpevtlist.admin', compact('data'));
    }
}
