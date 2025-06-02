<?php

namespace App\Livewire\Back\Trgevtlist;

use App\Models\TrgEvent;
use Livewire\Component;
use Livewire\WithPagination;

class Admin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';
    public $selectAll = false;
    public $selectedRows = [];
    

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


    public function mount()
    {
        $this->selectedRows = request()->get('selectedRows', []);
        
    }

    public function render()
    {
        $query = TrgEvent::with('trgDashboard');

        if (!empty($this->selectedRows)) {
            $query->whereIn('trg_id', $this->selectedRows);
        }

        $data = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        return view('livewire.back.trgevtlist.admin', [
            'data' => $data
        ]);
    }

    // public function render()
    // {
    //     $data = Trgdashboard::orderBy($this->sortField, $this->sortDirection)
    //         ->paginate(100);

    //     return view('livewire.back.trgevtlist.admin', [
    //         'data' => $data
    //     ]);
    // }
}


