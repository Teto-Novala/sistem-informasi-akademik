<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nilai>
 */
class NilaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [    
            'mahasiswa_id' => Mahasiswa::factory(), 
            'dosen_id' => Dosen::factory(),
            'matakuliah_id' => MataKuliah::factory(),
            'nilai_angka' => $this->faker->numberBetween(0, 100),
            'nilai_huruf' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
        ];
    }
}
