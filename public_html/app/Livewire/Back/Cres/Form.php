<?php

namespace App\Livewire\Back\Cres;

use App\Models\Candidate;
use App\Models\Cre;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $action;
    public $cre;
    public $response1;
    public $response2;
    public $response3;
    public $response4;
    public $response5;
    public $response6;
    public $response7;
    public $response8;
    public $response9;
    public $candidate;

    public function mount()
    {
        $this->candidate = Candidate::find($this->candidate);

        if ($this->action == 'update') {
            $this->cre = Cre::where('candidate_id', $this->candidate->id)->get();

            $this->response1 = $this->getResponseByNumber(1);
            $this->response2 = $this->getResponseByNumber(2);
            $this->response3 = $this->getResponseByNumber(3);
            $this->response4 = $this->getResponseByNumber(4);
            $this->response5 = $this->getResponseByNumber(5);
            $this->response6 = $this->getResponseByNumber(6);
            $this->response7 = $this->getResponseByNumber(7);
            $this->response8 = $this->getResponseByNumber(8);
            $this->response9 = $this->getResponseByNumber(9);
        }
    }

    protected function getResponseByNumber($number)
    {
        $cre = $this->cre->where('number', $number)->first();
        return $cre ? $cre->response : null;
    }

    public function storeData()
    {
        $questions = [
            1 => ' Statut professionnel',
            2 => 'Statut personnel',
            3 => 'Situation professionnelle',
            4 => 'Points incontournables',
            5 => 'Savoir-être du candidat',
            6 => 'Prise de référence(s)', 
            7 => 'Prétentions salariales',
            8 => 'Disponibilités candidat',
            9 => 'Résumé du parcours professionnel',
        ];

        $validatedData = $this->validate([
            'response1' => 'nullable',
            'response2' => 'nullable',
            'response3' => 'nullable',
            'response4' => 'nullable',
            'response5' => 'nullable',
            'response6' => 'nullable',
            'response7' => 'nullable',
            'response8' => 'nullable',
            'response9' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            foreach ($validatedData as $key => $value) {
                $number = substr($key, strlen('response'));
                $cre = Cre::where('candidate_id', $this->candidate->id)
                    ->where('number', $number)
                    ->first();

                if ($cre) {
                    // Si le CRE existe, le mettre à jour
                    $cre->update([
                        'response' => $value,
                        'question' => $questions[$number],
                    ]);
                } else {
                    // Si le CRE n'existe pas, le créer
                    Cre::create([
                        'response' => $value,
                        'number' => $number,
                        'candidate_id' => $this->candidate->id,
                        'question' => $questions[$number],
                    ]);
                }
            }

            // Mettre à jour les informations supplémentaires du candidat si nécessaire
            if ($this->action == 'create') {
                $this->candidate->update([
                    'cre_ref' => 'CRE' . rand(1, 99999),
                    'cre_created_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('candidates.show', $this->candidate->id);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->action == 'create' ? 'Erreur lors de la création du c.r.e' : 'Erreur lors de la modification du c.r.e' . $th->getMessage());

        }
    }

    public function render()
    {
        return view('livewire.back.cres.form');
    }
}
