<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Pest;
use Illuminate\Database\Seeder;

class PestSeeder extends Seeder
{
    public function run()
    {
        $pests = ['Thrips', 'Gall Midge', 'Leaffolder', 'Yellow Stem Borer', 'BPH+WBPH','Paddy Bug'];

        // Loop through each pest name and create a new Pest record
        foreach ($pests as $pestName) {
            Pest::create(['name' => $pestName]);
        }
    }
}
