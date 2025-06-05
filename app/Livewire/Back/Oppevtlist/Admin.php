<?php

namespace App\Livewire\Back\Oppevtlist;

use App\Models\OppEvent;
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
        $this->datas = OppEvent::latest()->get();
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

        OppEvent::whereIn('id', $this->selectedRows)->delete();
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
        OppEvent::find($eventId)->delete();
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
        $event = OppEvent::with('oppDashboard')->find($eventId);

        if (!$event) {
            $this->dispatch('alert', type: 'error', message: "Event not found");
            return;
        }

        // Populate form with existing data
        $this->eventFormData = [
            'opp_id' => $event->opp_id,
            'opp_code' => $event->oppDashboard->opp_code ?? '',
            'job_titles' => $event->oppDashboard->job_titles ?? '',
            'name' => $event->oppDashboard->ctc_code ?? '',
            'event_date' => $event->event_date,
            'type' => $event->type ?? '',
            'io' => $event->io ?? '',
            'object' => $event->object ?? '',
            'feedback' => $event->feedback ?? '',
            'status' => $event->status ?? '',
            'comment' => $event->comment ?? '',
            'next1' => $event->next1 ?? '',
            'term' => $event->term ?? '',
            'note1' => $event->note1 ?? '',
        ];

        $this->isEditMode = true;
        $this->editingEventId = $eventId;
        $this->showEventModal = true;

        $this->dispatch('open-event-modal');
    }

    public function updateEvent()
    {
        // Validate the form data
        $this->validate([
            'eventFormData.event_date' => 'required|date',
            'eventFormData.type' => 'required',
        ]);

        $event = OppEvent::find($this->editingEventId);

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
            'feedback' => $this->eventFormData['feedback'],
            'status' => $this->eventFormData['status'],
            'comment' => $this->eventFormData['comment'],
            'next1' => $this->eventFormData['next1'],
            'term' => $this->eventFormData['term'],
            'note1' => $this->eventFormData['note1'],
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

            OppEvent::create([
                'opp_id' => $this->eventFormData['opp_id'],
                'event_date' => $this->eventFormData['event_date'],
                'type' => $this->eventFormData['type'],
                'io' => $this->eventFormData['io'],
                'object' => $this->eventFormData['object'],
                'feedback' => $this->eventFormData['feedback'],
                'status' => $this->eventFormData['status'],
                'comment' => $this->eventFormData['comment'],
                'next1' => $this->eventFormData['next1'],
                'term' => $this->eventFormData['term'],
                'note1' => $this->eventFormData['note1'],
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
                $selectedItem = \App\Models\Oppdashboard::find($this->selectedRows[0]);
            }

            if ($selectedItem) {
                $this->eventFormData = [
                    'opp_id' => $selectedItem->id,
                    'opp_code' => $selectedItem->opp_code,
                    'job_titles' => $selectedItem->job_titles,
                    'name' => $selectedItem->getKeyName,
                    'event_date' => date('Y-m-d'),
                    'type' => '',
                    'io' => '',
                    'object' => '',
                    'feedback' => '',
                    'status' => '',
                    'comment' => '',
                    'next1' => '',
                    'term' => '',
                    'note1' => ''
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
                $selectedItem = \App\Models\Oppdashboard::find($this->selectedRows[0]);
            }

            if ($selectedItem) {
                $this->eventFormData = [
                    'opp_id' => $selectedItem->id,
                    'opp_code' => $selectedItem->opp_code,
                    'job_titles' => $selectedItem->job_titles,
                    'name' => $selectedItem->getKeyName,
                    'event_date' => date('Y-m-d'),
                    'type' => '',
                    'io' => '',
                    'object' => '',
                    'feedback' => '',
                    'status' => '',
                    'comment' => '',
                    'next1' => '',
                    'term' => '',
                    'note1' => ''
                ];
            }
        }

        $this->dispatch('alert', type: 'success', message: "Form has been validated");
    }


    public function render()
    {
        $query = OppEvent::with('oppDashboard');

        if (request()->has('selectedRows')) {
            $selectedRows = request()->get('selectedRows');
            $query->whereIn('opp_id', $selectedRows);
        }

        // if (!empty($this->selectedRows)) {
        //     $query->whereIn('trg_id', $this->selectedRows);
        // }

        $data = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        return view('livewire.back.oppevtlist.admin', [
            'data' => $data
        ]);
    }
}
