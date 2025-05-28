<?php

namespace Database\Seeders;

use App\Models\Compagny;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompagnySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $compagnies = ['Dessinateur Indépendant', 'Electrolev', 'Cassese'];
        foreach ($compagnies as $compagny) {
            Compagny::create(['name' => $compagny]);
        }
    }
}
