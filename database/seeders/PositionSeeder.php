<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'Autres',
            'Responsable de site',
            'Chargé d\'exploitation',
            'Travaux publics',
            'Chef d\'atelier',
            'Chef d\'agence',
            'Chef de groupe',
            'Chargé d\'étude',
            'Chef de projet',
            'Chef d\'équipe',
            'Commercial',
            'Coordinateur',
            'Dessinateur',
            'Directeur',
            'Ingénieur',
            'Génie',
            'Formateur',
            'Projeteur',
            'Responsable',
            'Superviseur',
            'Technicien'
        ];
        
        
        foreach ($positions as $position) {
            Position::create(['name' => $position]);
        }

    }
}
