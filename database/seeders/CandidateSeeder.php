<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Field;
use App\Models\Speciality;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        for ($i = 0; $i < 10; $i++) {
           $candidate=  Candidate::factory()->create();
           $candidate->specialities()->attach( Speciality::inRandomOrder()->first()->id,);
           $candidate->fields()->attach( Field::inRandomOrder()->first()->id,);

        }
        
    }
}
