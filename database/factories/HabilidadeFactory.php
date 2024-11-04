<?php
// database/factories/HabilidadeFactory.php

namespace Database\Factories;

use App\Models\Habilidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class HabilidadeFactory extends Factory
{
    protected $model = Habilidade::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
        ];
    }
}