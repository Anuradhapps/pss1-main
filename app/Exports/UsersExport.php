<?php

namespace App\Exports;

use App\Models\CommonDataCollect;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function collection()
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate   = Carbon::parse($this->endDate)->endOfDay();

        $result = [];

        // Eager load relationships to avoid N+1 problem
        $commonDataCollects = CommonDataCollect::with([
            'user.collector.getDistrict',
            'user.collector.getAsCenter',
            'user.collector.getAiRange',
            'pestDataCollect'
        ])->whereBetween('c_date', [$startDate, $endDate])->get();

        foreach ($commonDataCollects as $cdata) {
            $userCollector = $cdata->user->collector;

            foreach ($cdata->pestDataCollect as $pdata) {
                $result[] = [
                    'Created At'             => $cdata->created_at,
                    'Data Collected Date'    => $cdata->c_date,
                    'Name'                   => $cdata->user->name,
                    'Email'                  => $cdata->user->email,
                    'Phone Number'           => $userCollector->phone_no ?? 'N/A',
                    'District'               => $userCollector->getDistrict->name ?? 'N/A',
                    'ASC'                    => $userCollector->getAsCenter->name ?? 'N/A',
                    'Ai Range'               => $userCollector->getAiRange->name ?? 'N/A',
                    'Village'                => $userCollector->village ?? 'N/A',
                    'GPS Latitude'           => $userCollector->gps_lati ?? 'N/A',
                    'GPS Longitude'          => $userCollector->gps_long ?? 'N/A',
                    'Rice Variety'           => $userCollector->rice_variety ?? 'N/A',
                    'Date Established'       => $userCollector->date_establish ?? 'N/A',
                    'Established Method'     => $userCollector->established_method ?? 'N/A',
                    'Growth Stage'           => $cdata->growth_s_c ?? 'N/A',
                    'Temperature'            => $cdata->temperature ?? 'N/A',
                    'Number of Rainny Days'  => $cdata->numbrer_r_day ?? 'N/A',
                    'Pest Name'              => $pdata->pest_name ?? 'N/A',
                    'Location 01'            => $pdata->location_1 ?? 0,
                    'Location 02'            => $pdata->location_2 ?? 0,
                    'Location 03'            => $pdata->location_3 ?? 0,
                    'Location 04'            => $pdata->location_4 ?? 0,
                    'Location 05'            => $pdata->location_5 ?? 0,
                    'Location 06'            => $pdata->location_6 ?? 0,
                    'Location 07'            => $pdata->location_7 ?? 0,
                    'Location 08'            => $pdata->location_8 ?? 0,
                    'Location 09'            => $pdata->location_9 ?? 0,
                    'Location 10'            => $pdata->location_10 ?? 0,
                    'Total'                  => $pdata->total ?? 0,
                    'Mean'                   => $pdata->mean ?? 0,
                    'Code'                   => $pdata->code ?? 0,
                    'Other Info'             => $cdata->otherinfo ?? 'N/A',
                ];
            }

            // Optional: add empty row for spacing
            if ($cdata->pestDataCollect->isNotEmpty()) {
                $result[] = array_fill_keys(array_keys($result[0]), '');
            }
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Created At',
            'Data Collected Date',
            'Name',
            'Email',
            'Phone Number',
            'District',
            'ASC',
            'Ai Range',
            'Village',
            'GPS Latitude',
            'GPS Longitude',
            'Rice Variety',
            'Date Established',
            'Established Method',
            'Growth Stage',
            'Temperature',
            'Number of Rainny Days',
            'Pest Name',
            'Location 01',
            'Location 02',
            'Location 03',
            'Location 04',
            'Location 05',
            'Location 06',
            'Location 07',
            'Location 08',
            'Location 09',
            'Location 10',
            'Total',
            'Mean',
            'Code',
            'Other Info',
        ];
    }
}
