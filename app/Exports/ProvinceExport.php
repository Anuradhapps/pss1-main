<?php

namespace App\Exports;

use App\Models\Province;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProvinceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Province::with('district.As_center.AiRange') // ✅ Match your model method names
            ->get()
            ->flatMap(function ($province) {
                return $province->district->flatMap(function ($district) use ($province) {
                    return $district->As_center->flatMap(function ($asCenter) use ($province, $district) {
                        return $asCenter->AiRange->map(function ($aiRange) use ($province, $district, $asCenter) {
                            return [
                                'province'  => $province->name,
                                'district'  => $district->name,
                                'as_center' => $asCenter->name,
                                'ai_range'  => $aiRange->name,
                            ];
                        });
                    });
                });
            });
    }

    public function headings(): array
    {
        return ['Province', 'District', 'AS Center', 'AI Range'];
    }
}
