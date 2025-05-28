<?php

namespace App\Livewire\Back\Oppform;

use Livewire\Component;
use App\Models\Oppdashboard;

class Index extends Component
{
    public $step = 1;
    public $action = '';
    public $opportunity_date;
    public $opp_code;
    public $auth;
    public $trg_code;
    public $name;
    public $postal_code_1;
    public $site_city;
    public $ctc1_code;
    public $civs;
    public $ctc1_first_name;
    public $ctc1_last_name;
    public $position;
    public $remarks;
    public $job_titles;
    public $specificities;
    public $domain;
    public $postal_code;
    public $town;
    public $country;
    public $experience;
    public $schooling;
    public $schedules;
    public $mobility;
    public $permission;
    public $type;
    public $vehicle;
    public $job_offer_date;
    public $skill_one;
    public $skill_two;
    public $skill_three;
    public $other_one;
    public $remarks_two;
    public $job_start_date;
    public $invoice_date;
    public $gross_salary;
    public $bonus_1;
    public $bonus_2;
    public $bonus_3;
    public $other_two;
    public $date_emb;
    public $editId;
    public $isEditing = false;
    public $entries;
    public function goToCre()
    {
        $this->step = 3;
    }
    // protected $rules = [
    //     'opportunity_date' => 'required|date',
    //     'opp_code' => 'required|string|max:255',
    //     'auth' => 'required|string|max:255',
    //     'name' => 'required|string|max:255',
    // ];

    public function mount()
    {
        $this->loadEntries();
        $this->opportunity_date = date('Y-m-d');
    }

    public function loadEntries()
    {
        $this->entries = Oppdashboard::all();
    }

    
    private function generateCode()
    {
        $namePart = $this->name ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->name), 0, 2)) : 'XX';

        $townPart = $this->town ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->town), 0, 2)) : 'YY';

        $postal_codePart = $this->postal_code ? strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $this->postal_code), 0, 1)) : 'Z';

        $baseCode = $namePart . $townPart . $postal_codePart;

        $remainingLength = 8 - strlen($baseCode);
        $randomChars = '';
        for ($i = 0; $i < $remainingLength; $i++) {
            $randomChars .= chr(rand(65, 90));
        }

        $code = $baseCode . $randomChars;

        $codeExists = Oppdashboard::where('opp_code', $code)->exists();

        $attempts = 0;
        while ($codeExists && $attempts < 10) {
            $randomChars = '';
            for ($i = 0; $i < $remainingLength; $i++) {
                $randomChars .= chr(rand(65, 90));
            }

            $code = $baseCode . $randomChars;
            $codeExists = Oppdashboard::where('opp_code', $code)->exists();
            $attempts++;
        }

        if ($codeExists) {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= chr(rand(65, 90));
            }

            while (Oppdashboard::where('opp_code', $code)->exists()) {
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
        $this->opp_code = $this->generateCode();

        if ($this->isEditing) {
            $entry = Oppdashboard::find($this->editId);
            if ($entry) {
                $entry->update([
                    'opportunity_date' => $this->opportunity_date,
                    'opp_code' => $this->opp_code,
                    'auth' => $this->auth,
                    'trg_code' => $this->trg_code,
                    'name' => $this->name,
                    'postal_code_1' => $this->postal_code_1,
                    'site_city' => $this->site_city,
                    'ctc1_code' => $this->ctc1_code,
                    'civs' => $this->civs,
                    'ctc1_first_name' => $this->ctc1_first_name,
                    'ctc1_last_name' => $this->ctc1_last_name,
                    'position' => $this->position,
                    'remarks' => $this->remarks,
                    'job_titles' => $this->job_titles,
                    'specificities' => $this->specificities,
                    'domain' => $this->domain,
                    'postal_code' => $this->postal_code,
                    'town' => $this->town,
                    'country' => $this->country,
                    'experience' => $this->experience,
                    'schooling' => $this->schooling,
                    'schedules' => $this->schedules,
                    'mobility' => $this->mobility,
                    'permission' => $this->permission,
                    'type' => $this->type,
                    'vehicle' => $this->vehicle,
                    'job_offer_date' => $this->job_offer_date,
                    'skill_one' => $this->skill_one,
                    'skill_two' => $this->skill_two,
                    'skill_three' => $this->skill_three,
                    'other_one' => $this->other_one,
                    'remarks_two' => $this->remarks_two,
                    'job_start_date' => $this->job_start_date,
                    'invoice_date' => $this->invoice_date,
                    'gross_salary' => $this->gross_salary,
                    'bonus_1' => $this->bonus_1,
                    'bonus_2' => $this->bonus_2,
                    'bonus_3' => $this->bonus_3,
                    'other_two' => $this->other_two,
                    'date_emb' => $this->date_emb,
                ]);

                // session()->flash('message', 'Record updated successfully!');
                $this->dispatch('alert', type: 'success', message: "Record updated successfully");
    
            }
        } else {
            Oppdashboard::create([
                'opportunity_date' => $this->opportunity_date,
                'opp_code' => $this->opp_code,
                'auth' => $this->auth,
                'trg_code' => $this->trg_code,
                'name' => $this->name,
                'postal_code_1' => $this->postal_code_1,
                'site_city' => $this->site_city,
                'ctc1_code' => $this->ctc1_code,
                'civs' => $this->civs,
                'ctc1_first_name' => $this->ctc1_first_name,
                'ctc1_last_name' => $this->ctc1_last_name,
                'position' => $this->position,
                'remarks' => $this->remarks,
                'job_titles' => $this->job_titles,
                'specificities' => $this->specificities,
                'domain' => $this->domain,
                'postal_code' => $this->postal_code,
                'town' => $this->town,
                'country' => $this->country,
                'experience' => $this->experience,
                'schooling' => $this->schooling,
                'schedules' => $this->schedules,
                'mobility' => $this->mobility,
                'permission' => $this->permission,
                'type' => $this->type,
                'vehicle' => $this->vehicle,
                'job_offer_date' => $this->job_offer_date,
                'skill_one' => $this->skill_one,
                'skill_two' => $this->skill_two,
                'skill_three' => $this->skill_three,
                'other_one' => $this->other_one,
                'remarks_two' => $this->remarks_two,
                'job_start_date' => $this->job_start_date,
                'invoice_date' => $this->invoice_date,
                'gross_salary' => $this->gross_salary,
                'bonus_1' => $this->bonus_1,
                'bonus_2' => $this->bonus_2,
                'bonus_3' => $this->bonus_3,
                'other_two' => $this->other_two,
                'date_emb' => $this->date_emb,
            ]);

            // session()->flash('message', 'Form Submitted Successfully ✅');
            $this->dispatch('alert', type: 'success', message: "Form Submitted successfully");
    
        }

        $this->resetForm();
        $this->loadEntries();
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->editId = $id;

        $entry = Oppdashboard::find($id);

        if ($entry) {
            $this->opportunity_date = $entry->opportunity_date;
            $this->opp_code = $entry->opp_code;
            $this->auth = $entry->auth;
            $this->trg_code = $entry->trg_code;
            $this->name = $entry->name;
            $this->postal_code_1 = $entry->postal_code_1;
            $this->site_city = $entry->site_city;
            $this->ctc1_code = $entry->ctc1_code;
            $this->civs = $entry->civs;
            $this->ctc1_first_name = $entry->ctc1_first_name;
            $this->ctc1_last_name = $entry->ctc1_last_name;
            $this->position = $entry->position;
            $this->remarks = $entry->remarks;
            $this->job_titles = $entry->job_titles;
            $this->specificities = $entry->specificities;
            $this->domain = $entry->domain;
            $this->postal_code = $entry->postal_code;
            $this->town = $entry->town;
            $this->country = $entry->country;
            $this->experience = $entry->experience;
            $this->schooling = $entry->schooling;
            $this->schedules = $entry->schedules;
            $this->mobility = $entry->mobility;
            $this->permission = $entry->permission;
            $this->type = $entry->type;
            $this->vehicle = $entry->vehicle;
            $this->job_offer_date = $entry->job_offer_date;
            $this->skill_one = $entry->skill_one;
            $this->skill_two = $entry->skill_two;
            $this->skill_three = $entry->skill_three;
            $this->other_one = $entry->other_one;
            $this->remarks_two = $entry->remarks_two;
            $this->job_start_date = $entry->job_start_date;
            $this->invoice_date = $entry->invoice_date;
            $this->gross_salary = $entry->gross_salary;
            $this->bonus_1 = $entry->bonus_1;
            $this->bonus_2 = $entry->bonus_2;
            $this->bonus_3 = $entry->bonus_3;
            $this->other_two = $entry->other_two;
            $this->date_emb = $entry->date_emb;
        }
    }

    public function resetForm()
    {
        $this->reset(
            [
                'opportunity_date',
                'opp_code',
                'auth',
                'trg_code',
                'name',
                'postal_code_1',
                'site_city',
                'ctc1_code',
                'civs',
                'ctc1_first_name',
                'ctc1_last_name',
                'position',
                'remarks',
                'job_titles',
                'specificities',
                'domain',
                'postal_code',
                'town',
                'country',
                'experience',
                'schooling',
                'schedules',
                'mobility',
                'permission',
                'type',
                'vehicle',
                'job_offer_date',
                'skill_one',
                'skill_two',
                'skill_three',
                'other_one',
                'remarks_two',
                'job_start_date',
                'invoice_date',
                'gross_salary',
                'bonus_1',
                'bonus_2',
                'bonus_3',
                'other_two',
                'date_emb',
            ]
        );

        $this->isEditing = false;
        $this->editId = null;
        $this->opportunity_date = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.back.oppform.index');
    }

}


