<?php

namespace App\Livewire\Back\Ctcform;

use Livewire\Component;
use App\Models\Ctcdashboard;

class Index extends Component
{
    public $date_ctc;
    public $ctc_code;
    public $trg_code;
    public $company_ctc;
    public $civ;
    public $first_name;
    public $last_name;
    public $function_ctc;
    public $std_ctc;
    public $ext_ctc;
    public $ld;
    public $remarks;
    public $cell;
    public $mail;
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
        $this->date_ctc = date('Y-m-d');
    }

    public function loadEntries()
    {
        $this->entries = Ctcdashboard::all();
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

        $codeExists = Ctcdashboard::where('ctc_code', $code)->exists();

        $attempts = 0;
        while ($codeExists && $attempts < 10) {
            $randomChars = '';
            for ($i = 0; $i < $remainingLength; $i++) {
                $randomChars .= chr(rand(65, 90));
            }

            $code = $baseCode . $randomChars;
            $codeExists = Ctcdashboard::where('ctc_code', $code)->exists();
            $attempts++;
        }

        if ($codeExists) {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= chr(rand(65, 90));
            }

            while (Ctcdashboard::where('ctc_code', $code)->exists()) {
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
        $this->ctc_code = $this->generateCode();


        if ($this->isEditing) {
            $entry = Ctcdashboard::find($this->editId);
            if ($entry) {
                $entry->update([
                    'date_ctc' => $this->date_ctc,
                    'ctc_code' => $this->ctc_code,
                    'trg_code' => $this->trg_code,
                    'company_ctc' => $this->company_ctc,
                    'civ' => $this->civ,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'function_ctc' => $this->function_ctc,
                    'std_ctc' => $this->std_ctc,
                    'ext_ctc' => $this->ext_ctc,
                    'ld' => $this->ld,
                    'remarks' => $this->remarks,
                    'cell' => $this->cell,
                    'mail' => $this->mail,
                    'notes' => $this->notes,
                ]);

                $this->dispatch('alert', type: 'success', message: "Record updated successfully!");
            }
        } else {
            Ctcdashboard::create([
                'date_ctc' => $this->date_ctc,
                'ctc_code' => $this->ctc_code,
                'trg_code' => $this->trg_code,
                'company_ctc' => $this->company_ctc,
                'civ' => $this->civ,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'function_ctc' => $this->function_ctc,
                'std_ctc' => $this->std_ctc,
                'ext_ctc' => $this->ext_ctc,
                'ld' => $this->ld,
                'remarks' => $this->remarks,
                'cell' => $this->cell,
                'mail' => $this->mail,
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

        $entry = Ctcdashboard::find($id);

        if ($entry) {
            $this->date_ctc = $entry->date_ctc;
            $this->ctc_code = $entry->ctc_code;
            $this->trg_code = $entry->trg_code;
            $this->company_ctc = $entry->company_ctc;
            $this->civ = $entry->civ;
            $this->first_name = $entry->first_name;
            $this->last_name = $entry->last_name;
            $this->function_ctc = $entry->function_ctc;
            $this->std_ctc = $entry->std_ctc;
            $this->ext_ctc = $entry->ext_ctc;
            $this->ld = $entry->ld;
            $this->remarks = $entry->remarks;
            $this->cell = $entry->cell;
            $this->mail = $entry->mail;
            $this->notes = $entry->notes;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'date_ctc',
            'ctc_code',
            'trg_code',
            'company_ctc',
            'civ',
            'first_name',
            'last_name',
            'function_ctc',
            'std_ctc',
            'ext_ctc',
            'ld',
            'remarks',
            'cell',
            'mail',
            'notes'
        ]);

        $this->isEditing = false;
        $this->editId = null;
        $this->date_ctc = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.back.ctcform.index');
    }
}
