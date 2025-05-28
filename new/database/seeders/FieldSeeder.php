<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            'Autres',
            'Etude',
            'Electricité',
            'Electronique',
            'Généraliste',
            'Génie civil',
            'Génie industriel',
            'Génie chimique',
            'Industrialisation',
            'Maintenance',
            'Matériaux',
            'Mécanique',
            'Méthode',
            'MOEX',
            'Process/ projet',
            'Production',
            'Projet industriel',
            'QHSE',
            'R&D',
            'Nucléaire',
            'Travaux',
            'Robotique',
            'Chantiers',
            'Structure',
            'Projets',
            'Construction',
            'Sureté',
            'BTP',
            'CVC',
            'Eolien',
            'de ligne',
            'de travaux',
            'de travaux (cordiste)',
            'de travaux FTTH',
            'atelier TP',
            'mise en service',
            'Maintenance',
            'ferroviaire',
            'levage',
            'machine outil',
            'machine tournante',
            'moteur',
            'moteur diésel',
            'PL',
            'PL et TP',
            'itinérant',
            'VL',
            'électrogéne',
            'indusriel',
            'roboticien'
        ];
        
        foreach ($fields as $field) {
            Field::create(['name' => $field]);
        }
    }
}
