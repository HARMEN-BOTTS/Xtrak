<?php

namespace App\Livewire\Back\Mcpreport;

use Livewire\Component;
use App\Models\McpEmailLog;
use App\Models\Mcpdashboard;
use Livewire\WithPagination;

class Admin extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    
    public $mcpCode;
    public $campaignInfo;
    public $sortField = 'hour';
    public $sortDirection = 'asc';
    public $search = '';

    public function mount($mcpCode = null)
    {
        $this->mcpCode = $mcpCode;
        // For debugging
        info("Mounted with mcpCode: " . $mcpCode);
        
        if ($this->mcpCode) {
            $this->loadCampaignInfo();
        }
    }

    public function loadCampaignInfo()
    {
        $this->campaignInfo = Mcpdashboard::where('mcp_code', $this->mcpCode)->first();
        
        if (!$this->campaignInfo) {
            session()->flash('error', 'Campaign not found.');
            return redirect()->route('admin.mcpdashboard');
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function render()
    {
        if (!$this->mcpCode) {
            // For debugging
            info("No mcpCode in render method");
            return view('livewire.back.mcpreport.admin', [
                'emailLogs' => collect([])
            ]);
        }
        
        // For debugging
        info("Querying McpEmailLog with mcpCode: " . $this->mcpCode);
        
        // Check if records exist
        $count = McpEmailLog::where('mcp_code', $this->mcpCode)->count();
        info("Found {$count} records for mcpCode: {$this->mcpCode}");
        
        $emailLogs = McpEmailLog::where('mcp_code', $this->mcpCode)
            ->when($this->search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('recipient_email', 'like', '%'.$search.'%')
                        ->orWhere('recipient_name', 'like', '%'.$search.'%')
                        ->orWhere('company', 'like', '%'.$search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        return view('livewire.back.mcpreport.admin', [
            'emailLogs' => $emailLogs,
        ]);
    }
}