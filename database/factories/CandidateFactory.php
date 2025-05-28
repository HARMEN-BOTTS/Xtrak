<?php

namespace Database\Factories;

use App\Models\Civ;
use App\Models\User;
use App\Models\Compagny;
use App\Models\Disponibility;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'civ_id' => Civ::inRandomOrder()->first()->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'phone_2' => $this->faker->phoneNumber,
            'compagny_id' =>Compagny::inRandomOrder()->first()->id,
            'postal_code' => $this->faker->postcode,
            'cdt_status' => $this->faker->randomElement(['open', 'close', 'In Progress']),
            'created_by' => User::inRandomOrder()->first()->id,
            'position_id' => Position::inRandomOrder()->first()->id,
            'certificate' => Str::random(10),
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'region' => $this->faker->region,
            'country' => $this->faker->country,
            'disponibility_id' => Disponibility::inRandomOrder()->first()->id,
            'url_ctc' => $this->faker->url,
        ];
    }
}
