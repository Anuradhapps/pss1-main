<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\As_center;
use Illuminate\Database\Eloquent\Factories\Factory;

class As_CenterFactory extends Factory
{
    protected $model = As_center::class;

    public function definition(): array
    {
        return [
           'name' => $this->faker->unique()->city,
           'district_id'=>1
        ];
    }
}
