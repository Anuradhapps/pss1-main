<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\district;
use Illuminate\Database\Eloquent\Factories\Factory;

class districtFactory extends Factory
{
    protected $model = district::class;

    public function definition(): array
    {
        return [
            
            'name' => $this->faker->unique()->city, // Use a unique city name for district
        
        ];
    }
}
