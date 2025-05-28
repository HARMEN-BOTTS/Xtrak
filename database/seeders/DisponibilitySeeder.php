<?php

namespace Database\Seeders;

use App\Models\Disponibility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisponibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $disponibilities = [
            'Immédiatement',
            'Préavis en cours',
            '1 mois',
            '2 mois',
            '3 mois',
            'A négocier',
            'Indisponible'
        ];
        
        foreach ($disponibilities as $disponibility) {
            Disponibility::create([
                'name' => $disponibility,
            ]);
        }
    }
}
