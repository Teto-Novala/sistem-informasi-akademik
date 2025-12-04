<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MatakKuliah>
 */
class MataKuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->words(2, true), // Contoh: "Pemrograman Web"
            // Kode MK biasanya gabungan huruf dan angka unik (misal: "TI101")
            'kode_mk' => strtoupper($this->faker->unique()->lexify('??') . $this->faker->numerify('###')),
            'sks' => $this->faker->numberBetween(1, 4), // SKS biasanya 1-4
        ];
    }
}
