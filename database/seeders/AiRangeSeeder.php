<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\AiRangeFactory;
use Illuminate\Database\Seeder;

class AiRangeSeeder extends Seeder
{
    public function run()
    {
        AiRangeFactory::times(10)->create();
    }
}
