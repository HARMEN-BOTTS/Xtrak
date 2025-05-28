<?php

namespace App\Livewire\Back\Cstform;

use Livewire\Component;
use App\Models\Cstdashboard;

class Index extends Component
{
    public $date_cst;
    public $cst_code;
    public $civ;
    public $first_name;
    public $last_name;
    public $cell;
    public $mail;
    public $status;
    public $notes;
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
        $this->date_cst = date('Y-m-d');
    }

    public function loadEntries()
    {
        $this->entries = Cstdashboard::all();
    }

    private function generateCode()
    {
        $civPart = $this->civ ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->civ), 0, 2)) : 'XX';

        $first_namePart = $this->first_name ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->first_name), 0, 2)) : 'YY';

        $last_namePart = $this->last_name ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->last_name), 0, 1)) : 'Z';

        $baseCode = $civPart . $first_namePart . $last_namePart;

        $remainingLength = 8 - strlen($baseCode);
        $randomChars = '';
        for ($i = 0; $i < $remainingLength; $i++) {
            $randomChars .= chr(rand(65, 90));
        }

        $code = $baseCode . $randomChars;

        $codeExists = Cstdashboard::where('cst_code', $code)->exists();

        $attempts = 0;
        while ($codeExists && $attempts < 10) {
            $randomChars = '';
            for ($i = 0; $i < $remainingLength; $i++) {
                $randomChars .= chr(rand(65, 90));
            }

            $code = $baseCode . $randomChars;
            $codeExists = Cstdashboard::where('cst_code', $code)->exists();
            $attempts++;
        }

        if ($codeExists) {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= chr(rand(65, 90));
            }

            while (Cstdashboard::where('cst_code', $code)->exists()) {
                $code = '';
                for ($i = 0; $i < 8; $i++) {
                    $code .= chr(rand(65, 90));
                }
            }
        }

        return $code;
    }



    public function save()
    {
        // $this->validate();
        $this->cst_code = $this->generateCode();

        if ($this->isEditing) {
            $entry = Cstdashboard::find($this->editId);
            if ($entry) {
                $entry->update([
                    'date_cst' => $this->date_cst,
                    'cst_code' => $this->cst_code,
                    'civ' => $this->civ,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'cell' => $this->cell,
                    'mail' => $this->mail,
                    'status' => $this->status,
                    'notes' => $this->notes,
                ]);

                $this->dispatch('alert', type: 'success', message: "Record updated successfully!");
            }
        } else {
            Cstdashboard::create([
                'date_cst' => $this->date_cst,
                'cst_code' => $this->cst_code,
                'civ' => $this->civ,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'cell' => $this->cell,
                'mail' => $this->mail,
                'status' => $this->status,
                'notes' => $this->notes,
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

        $entry = Cstdashboard::find($id);

        if ($entry) {
            $this->date_cst = $entry->date_cst;
            $this->cst_code = $entry->cst_code;
            $this->civ = $entry->civ;
            $this->first_name = $entry->first_name;
            $this->last_name = $entry->last_name;
            $this->cell = $entry->cell;
            $this->mail = $entry->mail;
            $this->status = $entry->status;
            $this->notes = $entry->notes;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'date_cst',
            'cst_code',
            'civ',
            'first_name',
            'last_name',
            'cell',
            'mail',
            'status',
            'notes',
        ]);

        $this->isEditing = false;
        $this->editId = null;
        $this->date_cst = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.back.cstform.index');
    }
}
