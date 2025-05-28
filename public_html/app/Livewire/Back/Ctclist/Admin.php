<?php

namespace App\Livewire\Back\Ctclist;

use App\Models\Ctcdashboard;
use Livewire\Component;
use Livewire\WithPagination;

class Admin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';
    public $selectAll = false;

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
        $data = Ctcdashboard::orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        return view('livewire.back.ctclist.admin', [
            'data' => $data
        ]);
    }
}
