<?php

namespace Database\Seeders;

use App\Models\CandidateStatut;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CandidateStatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuts = ['Intéressé', 'Pas intéressé', 'A voir', 'A l\'écoute', 'Recherche active', 'En poste', 'Disponible'];

        foreach ($statuts as $statut) {
           CandidateStatut::create(
                ['name' => $statut]
           );
        }
    }
}
