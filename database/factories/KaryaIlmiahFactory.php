<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KaryaIlmiah>
 */
class KaryaIlmiahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'title' => $this->faker->sentence(mt_rand(2, 8)),
            'slug' => $this->faker->slug(),
            'penerbit' => $this->faker->name(),
            'tanggal_terbit' => $this->faker->date(),
            'issn_online' => $this->faker->randomNumber(),
            'issn_cetak' => $this->faker->randomNumber(),
            'subyek' => $this->faker->sentence(mt_rand(1,2)),
            'abstract' => collect($this->faker->paragraphs(mt_rand(2,6)))->map(fn($p)=>"<p>$p</p>")->implode('')
        ];
    }
}
