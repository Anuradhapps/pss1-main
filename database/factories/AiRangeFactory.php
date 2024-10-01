<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AiRange;
use Illuminate\Database\Eloquent\Factories\Factory;

class AiRangeFactory extends Factory
{
    protected $model = AiRange::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'as_center_id'=>2
        ];
    }
}
