<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Pest;
use Illuminate\Database\Eloquent\Factories\Factory;

class PestFactory extends Factory
{
    protected $model = Pest::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
