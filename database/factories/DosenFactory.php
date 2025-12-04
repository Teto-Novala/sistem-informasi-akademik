<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            // NIDN biasanya angka unik 10 digit
            'nidn' => $this->faker->unique()->numerify('##########'), 
            'no_hp' => $this->faker->phoneNumber(),
        ];
    }
}
