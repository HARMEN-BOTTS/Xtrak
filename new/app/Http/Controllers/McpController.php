<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mcpdashboard;

class McpController extends Controller
{
    public function index()
    {
        $entries = Mcpdashboard::all();
        return view('back.mcpform.index', compact('entries'));
    }

    public function edit($id)
    {
        $entry = Mcpdashboard::findOrFail($id);
        return view('back.mcpform.edit', compact('entry'));
    }
}



