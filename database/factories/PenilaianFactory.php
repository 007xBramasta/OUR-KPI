<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penilaian>
 */
class PenilaianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "penilaian_indikator" => fake()->sentence(),
            "penilaian_target" => 1,
            "penilaian_aktual"  => fake()->sentence(),
            "penilaian_keterangan" => fake()->sentence(20)
        ];
    }
}
