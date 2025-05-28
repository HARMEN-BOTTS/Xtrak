<?php

namespace Database\Seeders;

use App\Models\CandidateState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuts = ['Certifié', 'Attente', 'Doublon'];

        foreach ($statuts as $statut) {
            CandidateState::create(['name' => $statut]);
        }
    }
}
