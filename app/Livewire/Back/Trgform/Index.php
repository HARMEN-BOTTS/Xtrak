<?php

namespace App\Livewire\Back\Trgform;

use Livewire\Component;
use App\Models\Trgdashboard;

class Index extends Component
{
    public $creation_date;
    public $auth;
    public $company;
    public $standard_phone;
    public $website_url;
    public $trg_code;
    public $address;
    public $address_one;
    public $postal_code_department;
    public $region;
    public $town;
    public $country;
    public $ca_k;
    public $employees;
    public $activity;
    public $type;
    public $siret;
    public $rcs;
    public $filiation;
    public $off;
    public $legal_form;
    public $vat_number;
    public $trg_status;
    public $remarks;
    public $notes;
    public $last_modification_date;
    public $priority;
    public $editId;
    public $isEditing = false;

    public $entries;
    // protected $rules = [
    //     'creation_date' => 'required|date',
    //     'trg_code' => 'required|string|max:255',
    //     'auth' => 'required|string|max:255',
    //     'company' => 'required|string|max:255',
    // ];

    public function mount()
    {
        $this->loadEntries();
        $this->creation_date = date('Y-m-d');
    }

    public function loadEntries()
    {
        $this->entries = Trgdashboard::all();
    }

    private function generateCode()
    {
        $companyPart = $this->company ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->company), 0, 2)) : 'XX';

        $postal_code_departmentPart = $this->postal_code_department ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->postal_code_department), 0, 2)) : 'YY';

        $townPart = $this->town ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->town), 0, 1)) : 'Z';

        $baseCode = $companyPart . $postal_code_departmentPart . $townPart;

        $remainingLength = 8 - strlen($baseCode);
        $randomChars = '';
        for ($i = 0; $i < $remainingLength; $i++) {
            $randomChars .= chr(rand(65, 90));
        }

        $code = $baseCode . $randomChars;

        $codeExists = Trgdashboard::where('trg_code', $code)->exists();

        $attempts = 0;
        while ($codeExists && $attempts < 10) {
            $randomChars = '';
            for ($i = 0; $i < $remainingLength; $i++) {
                $randomChars .= chr(rand(65, 90));
            }

            $code = $baseCode . $randomChars;
            $codeExists = Trgdashboard::where('trg_code', $code)->exists();
            $attempts++;
        }

        if ($codeExists) {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= chr(rand(65, 90));
            }

            while (Trgdashboard::where('trg_code', $code)->exists()) {
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
        $this->trg_code = $this->generateCode();

        if ($this->isEditing) {
            $entry = Trgdashboard::find($this->editId);
            if ($entry) {
                $entry->update([
                    'creation_date' => $this->creation_date,
                    'auth' => $this->auth,
                    'company' => $this->company,
                    'standard_phone' => $this->standard_phone,
                    'website_url' => $this->website_url,
                    'trg_code' => $this->trg_code,
                    'address' => $this->address,
                    'address_one' => $this->address_one,
                    'postal_code_department' => $this->postal_code_department,
                    'region' => $this->region,
                    'town' => $this->town,
                    'country' => $this->country,
                    'ca_k' => $this->ca_k,
                    'employees' => $this->employees,
                    'activity' => $this->activity,
                    'type' => $this->type,
                    'siret' => $this->siret,
                    'rcs' => $this->rcs,
                    'filiation' => $this->filiation,
                    'off' => $this->off,
                    'legal_form' => $this->legal_form,
                    'vat_number' => $this->vat_number,
                    'trg_status' => $this->trg_status,
                    'remarks' => $this->remarks,
                    'notes' => $this->notes,
                    'last_modification_date' => $this->last_modification_date,
                    'priority' => $this->priority
                ]);

                // session()->flash('message', 'Record updated successfully!');
                $this->dispatch('alert', type: 'success', message: "Record updated successfully!");
   
            }
        } else {
            Trgdashboard::create([
                'creation_date' => $this->creation_date,
                'auth' => $this->auth,
                'company' => $this->company,
                'standard_phone' => $this->standard_phone,
                'website_url' => $this->website_url,
                'trg_code' => $this->trg_code,
                'address' => $this->address,
                'address_one' => $this->address_one,
                'postal_code_department' => $this->postal_code_department,
                'region' => $this->region,
                'town' => $this->town,
                'country' => $this->country,
                'ca_k' => $this->ca_k,
                'employees' => $this->employees,
                'activity' => $this->activity,
                'type' => $this->type,
                'siret' => $this->siret,
                'rcs' => $this->rcs,
                'filiation' => $this->filiation,
                'off' => $this->off,
                'legal_form' => $this->legal_form,
                'vat_number' => $this->vat_number,
                'trg_status' => $this->trg_status,
                'remarks' => $this->remarks,
                'notes' => $this->notes,
                'last_modification_date' => $this->last_modification_date,
                'priority' => $this->priority

            ]);

            // session()->flash('message', 'Form Submitted Successfully ✅');
            $this->dispatch('alert', type: 'success', message: "Form Submitted Successfully");
   
        }

        $this->resetForm();
        $this->loadEntries();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->editId = $id;

        $entry = Trgdashboard::find($id);

        if ($entry) {
            $this->creation_date = $entry->creation_date;
            $this->auth = $entry->auth;
            $this->company = $entry->company;
            $this->standard_phone = $entry->standard_phone;
            $this->website_url = $entry->website_url;
            $this->trg_code = $entry->trg_code;
            $this->address = $entry->address;
            $this->address_one = $entry->address_one;
            $this->postal_code_department = $entry->postal_code_department;
            $this->region = $entry->region;
            $this->town = $entry->town;
            $this->country = $entry->country;
            $this->ca_k = $entry->ca_k;
            $this->employees = $entry->employees;
            $this->activity = $entry->activity;
            $this->type = $entry->type;
            $this->siret = $entry->siret;
            $this->rcs = $entry->rcs;
            $this->filiation = $entry->filiation;
            $this->off = $entry->off;
            $this->legal_form = $entry->legal_form;
            $this->vat_number = $entry->vat_number;
            $this->trg_status = $entry->trg_status;
            $this->remarks = $entry->remarks;
            $this->notes = $entry->notes;
            $this->last_modification_date = $entry->last_modification_date;
            $this->priority = $entry->priority;
        }
    }

    public function resetForm()
    {
        $this->reset(
            [
                'creation_date',
                'auth',
                'company',
                'standard_phone',
                'website_url',
                'trg_code',
                'address',
                'address_one',
                'postal_code_department',
                'region',
                'town',
                'country',
                'ca_k',
                'employees',
                'activity',
                'type',
                'siret',
                'rcs',
                'filiation',
                'off',
                'legal_form',
                'vat_number',
                'trg_status',
                'remarks',
                'notes',
                'last_modification_date',
                'priority'
            ]
        );

        $this->isEditing = false;
        $this->editId = null;
        $this->creation_date = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.back.trgform.index');
    }
}




