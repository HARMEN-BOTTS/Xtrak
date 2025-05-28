<?php

namespace Database\Seeders;

use App\Models\Civ;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CivSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $civs = ['Mr', 'Mme', 'Mlle'];

        foreach ($civs as $key => $civ) {
            Civ::create([
                'name' => $civ,
            ]);
        }
    }
}
