<?php

namespace App\Livewire\Back\Rtform;

use Livewire\Component;
use App\Models\Rtdashboard;

class Index extends Component
{
    public $date_rt;
    public $auth;
    public $task_code;
    public $destination;
    public $type_input;
    public $subject;
    public $position;
    public $re;
    public $problems;
    public $corrective_actions;
    public $delay;
    public $remarks;
    public $priority;
    public $status;
    public $note_one;
    public $note_two;
    public $rk;
    public $vol;


    public $editId;
    public $isEditing = false;

    public $entries;

    // protected $rules = [
    //     'date_ctc' => 'required|date',
    //     'ctc_code' => 'required|string|max:255',
    //     'first_name' => 'required|string|max:255',
    //     'last_name' => 'required|string|max:255',
    // ];

    public function mount()
    {
        $this->loadEntries();
        $this->date_rt = date('Y-m-d');
    }

    public function loadEntries()
    {
        $this->entries = Rtdashboard::all();
    }

    public function save()
    {
        // $this->validate();

        if ($this->isEditing) {
            $entry = Rtdashboard::find($this->editId);
            if ($entry) {
                $entry->update([
                    'date_rt' => $this->date_rt,
                    'auth' => $this->auth,
                    'task_code' => $this->task_code,
                    'destination' => $this->destination,
                    'type_input' => $this->type_input,
                    'subject' => $this->subject,
                    'position' => $this->position,
                    're' => $this->re,
                    'problems' => $this->problems,
                    'corrective_actions' => $this->corrective_actions,
                    'delay' => $this->delay,
                    'remarks' => $this->remarks,
                    'priority' => $this->priority,
                    'status' => $this->status,
                    'note_one' => $this->note_one,
                    'note_two' => $this->note_two,
                    'rk' => $this->rk,
                    'vol' => $this->vol,
                ]);

                $this->dispatch('alert', type: 'success', message: "Record updated successfully!");
            }
        } else {
            Rtdashboard::create([
                'date_rt' => $this->date_rt,
                'auth' => $this->auth,
                'task_code' => $this->task_code,
                'destination' => $this->destination,
                'type_input' => $this->type_input,
                'subject' => $this->subject,
                'position' => $this->position,
                're' => $this->re,
                'problems' => $this->problems,
                'corrective_actions' => $this->corrective_actions,
                'delay' => $this->delay,
                'remarks' => $this->remarks,
                'priority' => $this->priority,
                'status' => $this->status,
                'note_one' => $this->note_one,
                'note_two' => $this->note_two,
                'rk' => $this->rk,
                'vol' => $this->vol,
            ]);

            $this->dispatch('alert', type: 'success', message: "Form Submitted Successfully");
        }

        $this->resetForm();
        $this->loadEntries();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->editId = $id;

        $entry = Rtdashboard::find($id);

        if ($entry) {
            $this->date_rt = $entry->date_rt;
            $this->auth = $entry->auth;
            $this->task_code = $entry->task_code;
            $this->destination = $entry->destination;
            $this->type_input = $entry->type_input;
            $this->subject = $entry->subject;
            $this->position = $entry->position;
            $this->re = $entry->re;
            $this->problems = $entry->problems;
            $this->corrective_actions = $entry->corrective_actions;
            $this->delay = $entry->delay;
            $this->remarks = $entry->remarks;
            $this->priority = $entry->priority;
            $this->status = $entry->status;
            $this->note_one = $entry->note_one;
            $this->note_two = $entry->note_two;
            $this->rk = $entry->rk;
            $this->vol = $entry->vol;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'date_rt',
            'auth',
            'task_code',
            'destination',
            'type_input',
            'subject',
            'position',
            're',
            'problems',
            'corrective_actions',
            'delay',
            'remarks',
            'priority',
            'status',
            'note_one',
            'note_two',
            'rk',
            'vol'
        ]);

        $this->isEditing = false;
        $this->editId = null;
        $this->date_rt = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.back.rtform.index');
    }
}
