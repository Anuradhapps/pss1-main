<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AiRange;
use App\Models\As_center;
use App\Models\district;
use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceDistrictAscAiRangeSeeder extends Seeder
{
    public function run()
    {
        // Path to your CSV file
        $csvFile = base_path('database/dbai.csv');
        
        // Open and read the CSV file
        $file = fopen($csvFile, 'r');
        $firstline = true; // To skip the header

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            if (!$firstline) {
                // Get the Province, District, ASC, and AI Range from the CSV
                $provinceName = $data[0];
                $districtName = $data[1];
                $ascName = $data[2];
                $aiRangeName = $data[3];

                // Insert or retrieve Province
                $province = Province::firstOrCreate(['name' => $provinceName]);

                // Insert or retrieve District
                $district = district::firstOrCreate([
                    'name' => $districtName,
                    'province_id' => $province->id, // Link with the province
                ]);

                // Insert or retrieve ASC (Agricultural Service Center)
                $asc = As_center::firstOrCreate([
                    'name' => $ascName,
                    'district_id' => $district->id, // Link with the district
                ]);

                // Insert AI Range
                AiRange::firstOrCreate([
                    'name' => $aiRangeName,
                    'as_center_id' => $asc->id, // Link with the ASC
                ]);
            }
            $firstline = false; // Skip the first row (header)
        }

        fclose($file);
    }
}
