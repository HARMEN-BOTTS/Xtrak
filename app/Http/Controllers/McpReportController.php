<?php

namespace App\Http\Controllers;

use App\Models\McpEmailLog;
use App\Models\Mcpdashboard;

class McpReportController extends Controller
{
    public function index($mcpCode)
    {
        // Fetch campaign info to pass to view
        $campaignInfo = Mcpdashboard::where('mcp_code', $mcpCode)->first();
        
        if (!$campaignInfo) {
            session()->flash('error', 'Campaign not found.');
            return redirect()->route('admin.mcpdashboard');
        }
        
        // Pass mcpCode to the view
        return view('back.mcpreport.admin', ['mcpCode' => $mcpCode]);
    }
}