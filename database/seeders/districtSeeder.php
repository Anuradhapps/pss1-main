<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\district;
use Illuminate\Database\Seeder;

class districtSeeder extends Seeder
{
    public function run()
    {
        district::insert([
            ['name' => 'Ampara'],
            ['name' => 'Anuradhapura'],
            ['name' => 'Badulla'],
            ['name' => 'Batticaloa'],
            ['name' => 'Colombo'],
            ['name' => 'Galle'],
            ['name' => 'Gampaha'],
            ['name' => 'Hambantota'],
            ['name' => 'Jaffna'],
            ['name' => 'Kalutara'],
            ['name' => 'Kandy'],
            ['name' => 'Kegalle'],
            ['name' => 'Kilinochchi'],
            ['name' => 'Kurunegala'],
            ['name' => 'Mannar'],
            ['name' => 'Matale'],
            ['name' => 'Matara'],
            ['name' => 'Monaragala'],
            ['name' => 'Mullaitivu'],
            ['name' => 'Nuwaraeliya'],
            ['name' => 'Polonnaruwa'],
            ['name' => 'Puttalam'],
            ['name' => 'Ratnapura'],
            ['name' => 'Trincomalee'],
            ['name' => 'Vavuniya'],
        ]);
    }
}
