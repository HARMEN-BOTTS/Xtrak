<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CivSeeder::class,
            DisponibilitySeeder::class,
            PositionSeeder::class,
            CompagnySeeder::class,
            // SpecialitySeeder::class,
            // FieldSeeder::class,
            PermissionRoleSeeder::class,
            // CandidateSeeder::class,
            CandidateStatutSeeder::class,
            CandidateStateSeeder::class,
        ]);

    }
}
