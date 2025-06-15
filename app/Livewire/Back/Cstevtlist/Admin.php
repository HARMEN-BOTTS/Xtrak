<?php

namespace App\Livewire\Back\Cstevtlist;

use App\Models\CstEvent;
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


    public $datas;
    protected $listeners = ['refreshTable' => '$refresh'];
    public $isEditing = false;
    public $editId = null;
    public $formData = [];

    public function refreshData()
    {
        $this->datas = CstEvent::latest()->get();
    }


    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = $this->links->pluck('id')->map(function ($id) {
                return (string) $id;
            })->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function toggleSelect($id)
    {
        if (in_array($id, $this->selectedRows)) {
            $this->selectedRows = array_diff($this->selectedRows, [$id]);
        } else {
            $this->selectedRows = [$id];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedRows)) {
            return;
        }

        CstEvent::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;

        $this->refreshData();

        $this->dispatch('alert', type: 'success', message: "Event Deleted Successfully");
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


    public function mount()
    {
        $this->selectedRows = request()->get('selectedRows', []);
        $this->refreshData();
    }

    public function deleteEvent($eventId)
    {
        CstEvent::find($eventId)->delete();
        $this->dispatch('alert', type: 'success', message: "Event Deleted Successfully");
    }


    // Add these properties to your Admin class
    public $showEventModal = false;
    public $eventFormData = [];
    public $isEditMode = false;
    public $editingEventId = null;

    // Add these methods to your Admin class

    public function editRow($eventId)
    {
        $event = CstEvent::with('cstDashboard')->find($eventId);

        if (!$event) {
            $this->dispatch('alert', type: 'error', message: "Event not found");
            return;
        }

        // Populate form with existing data
        $this->eventFormData = [
            'cst_id' => $event->cst_id,
            'event_date' => $event->event_date,
            'type' => $event->type ?? '',
            'io' => $event->io ?? '',
            'object' => $event->object ?? '',
            'status' => $event->status ?? '',
            'feed' => $event->feed ?? '',
            'comment' => $event->comment ?? '',
            'next' => $event->next ?? '',
            'ech' => $event->ech ?? '',
            'priority' => $event->priority ?? '',
            'last_comment' => $event->last_comment ?? '',
            'date_last_comment' => $event->date_last_comment,
            'other_comment' => $event->other_comment ?? '',
            'note1' => $event->note1 ?? '',
            'temper' => $event->temper ?? ''
        ];

        $this->isEditMode = true;
        $this->editingEventId = $eventId;
        $this->showEventModal = true;

        $this->dispatch('open-event-modal');
    }

    public function updateEvent()
    {
        // Validate the form data
        // $this->validate([
        //     'eventFormData.event_date' => 'required|date',
        //     'eventFormData.type' => 'required',
        // ]);

        $event = CstEvent::find($this->editingEventId);

        if (!$event) {
            $this->dispatch('alert', type: 'error', message: "Event not found");
            return;
        }

        // Update the event
        $event->update([
            'event_date' => $this->eventFormData['event_date'],
            'type' => $this->eventFormData['type'],
            'io' => $this->eventFormData['io'],
            'object' => $this->eventFormData['object'],
            'status' => $this->eventFormData['status'],
            'feed' => $this->eventFormData['feed'],
            'comment' => $this->eventFormData['comment'],
            'next' => $this->eventFormData['next'],
            'ech' => $this->eventFormData['ech'],
            'priority' => $this->eventFormData['priority'],
            'last_comment' => $this->eventFormData['last_comment'],
            'date_last_comment' => $this->eventFormData['date_last_comment'],
            'other_comment' => $this->eventFormData['other_comment'],
            'note1' => $this->eventFormData['note1'],
            'temper' => $this->eventFormData['temper'],
        ]);

        $this->dispatch('alert', type: 'success', message: "Event updated successfully");
        $this->closeEventModal();
        $this->refreshData();
    }

    public function closeEventModal()
    {
        $this->showEventModal = false;
        $this->eventFormData = [];
        $this->isEditMode = false;
        $this->editingEventId = null;
        $this->dispatch('close-event-modal');
    }

    public function saveEvent()
    {
        if ($this->isEditMode) {
            $this->updateEvent();
        } else {
            // Your existing create logic here
            // $this->validate([
            //     'eventFormData.event_date' => 'required|date',
            //     'eventFormData.type' => 'required',
            // ]);

            CstEvent::create([
                'cst_id' => $this->eventFormData['cst_id'],
                'event_date' => $this->eventFormData['event_date'],
                'type' => $this->eventFormData['type'],
                'io' => $this->eventFormData['io'],
                'object' => $this->eventFormData['object'],
                'status' => $this->eventFormData['status'],
                'feed' => $this->eventFormData['feed'],
                'comment' => $this->eventFormData['comment'],
                'next' => $this->eventFormData['next'],
                'ech' => $this->eventFormData['ech'],
                'priority' => $this->eventFormData['priority'],
                'last_comment' => $this->eventFormData['last_comment'],
                'date_last_comment' => $this->eventFormData['date_last_comment'],
                'other_comment' => $this->eventFormData['other_comment'],
                'note1' => $this->eventFormData['note1'],
                'temper' => $this->eventFormData['temper'],
            ]);

            $this->dispatch('alert', type: 'success', message: "Event created successfully");
            $this->closeEventModal();
            $this->refreshData();
        }
    }

    public function resetEventForm()
    {
        if ($this->isEditMode) {
            // For edit mode, reset to original values
            $this->editRow($this->editingEventId);
        } else {
            // For create mode, clear all editable fields but keep basic info
            $selectedItem = null;
            if (!empty($this->selectedRows)) {
                $selectedItem = \App\Models\Cstdashboard::find($this->selectedRows[0]);
            }

            if ($selectedItem) {
                $this->eventFormData = [
                    'cst_id' => $selectedItem->id,
                    'event_date' => date('Y-m-d'),
                    'type' => '',
                    'io' => '',
                    'object' => '',
                    'status' => '',
                    'feed' => '',
                    'comment' => '',
                    'next' => '',
                    'ech' => '',
                    'priority' => '',
                    'last_comment' => '',
                    'date_last_comment' => date('Y-m-d'),
                    'other_comment' => '',
                    'note1' => '',
                    'temper' => '',
                ];
            }
        }

        $this->dispatch('alert', type: 'info', message: "Form has been reset");
    }


    public function validateEventForm()
    {
        if ($this->isEditMode) {
            // For edit mode, reset to original values
            $this->editRow($this->editingEventId);
        } else {
            // For create mode, clear all editable fields but keep basic info
            $selectedItem = null;
            if (!empty($this->selectedRows)) {
                $selectedItem = \App\Models\Cstdashboard::find($this->selectedRows[0]);
            }

            if ($selectedItem) {
                $this->eventFormData = [
                    'cst_id' => $selectedItem->id,
                    
                    'event_date' => date('Y-m-d'),
                    'type' => '',
                    'io' => '',
                    'object' => '',
                    'status' => '',
                    'feed' => '',
                    'comment' => '',
                    'next' => '',
                    'ech' => '',
                    'priority' => '',
                    'last_comment' => '',
                    'date_last_comment' => date('Y-m-d'),
                    'other_comment' => '',
                    'note1' => '',
                    'temper' => ''
                ];
            }
        }

        $this->dispatch('alert', type: 'success', message: "Form has been validated");
    }


    public function render()
    {
        $query = CstEvent::with('cstDashboard');

        if (request()->has('selectedRows')) {
            $selectedRows = request()->get('selectedRows');
            $query->whereIn('cst_id', $selectedRows);
        }

        // if (!empty($this->selectedRows)) {
        //     $query->whereIn('trg_id', $this->selectedRows);
        // }

        $data = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        return view('livewire.back.cstevtlist.admin', [
            'data' => $data
        ]);
    }
}
