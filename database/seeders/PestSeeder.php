<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Collector;
use App\Models\CommonDataCollect;
use App\Models\Pest;
use App\Models\PestDataCollect;
use Illuminate\Database\Seeder;

class PestSeeder extends Seeder
{

    // public function run()
    // {
    //     $collectors = Collector::all();

    //     foreach ($collectors as $collector) {
    //         $newCollector = $collector->replicate();
    //         $newCollector->id = $collector->id + 222;
    //         $CommonDataCollect = CommonDataCollect::find($collector->id);
    //         foreach ($CommonDataCollect as $commonData) {
    //             $newCommonData = $commonData->replicate();
    //             $newCommonData->collector_id = $newCollector->id;
    //             $estDataCollect = PestDataCollect::find($commonData->id);
    //             foreach ($estDataCollect as $estData) {
    //                 $newestData = $estData->replicate();
    //                 $newestData->common_data_collectors_id = $newCommonData->id;
    //                 $newestData->save();
    //             }
    //             $newCommonData->save();
    //         }

    //         $newCollector->save();
    //     }
    // }
    public function run()
    {
        $pests = ['Thrips', 'Gall Midge', 'Leaffolder', 'Yellow Stem Borer', 'BPH+WBPH', 'Paddy Bug'];

        // Loop through each pest name and create a new Pest record
        foreach ($pests as $pestName) {
            Pest::create(['name' => $pestName]);
        }
    }
}
