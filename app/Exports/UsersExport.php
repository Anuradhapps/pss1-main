<?php

namespace App\Exports;

use App\Models\AiRange;
use App\Models\As_center;
use App\Models\CommonDataCollect;
use App\Models\district;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
//com
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
       
        // Convert input dates to Carbon instances for comparison
        $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate)->endOfDay();

        $result = [];
        $commonDataCollect = CommonDataCollect::whereBetween('c_date', [$startDate, $endDate])->get();

        foreach ($commonDataCollect as $cdata) {
            // Flag to check if there's pest data for the current $cdata

            $hasPestData = false;
            $check = true;
            foreach ($cdata->pestDataCollect as $pdata) {
                if($check){
                    // $check = false;
                    $result[] = [
                        'Data Collected Date'      => $cdata->c_date,
                        'Name'                    => $cdata->user->name,
                        'Email'                   => $cdata->user->email,
                        'Phone Number'            => $cdata->user->collector ? $cdata->user->collector->phone_no : 'N/A',

                        
                        'Collector District'      => $cdata->user->collector ? district::where('id', $cdata->user->collector->getDistrict->id)->latest()->first()->name : 'N/A',
                        'Collector ASC'           => $cdata->user->collector ? As_center::where('id', $cdata->user->collector->getAsCenter->id)->latest()->first()->name : 'N/A',
                        'Collector Ai Range'      => $cdata->user->collector ? AiRange::where('id', $cdata->user->collector->getAiRange->id)->latest()->first()->name : 'N/A',
                        'Collector Village'        => $cdata->user->collector ? $cdata->user->collector->village : 'N/A',
                        'Collector GPS Latitude'   => $cdata->user->collector ? $cdata->user->collector->gps_lati : 'N/A',
                        'Collector GPS Longitude'   => $cdata->user->collector ? $cdata->user->collector->gps_long : 'N/A',
                        'Collector Rice Variety'   => $cdata->user->collector ? $cdata->user->collector->rice_variety : 'N/A',
                        'Date Established'         => $cdata->user->collector ? $cdata->user->collector->date_establish : 'N/A',
    
                        'Growth Stage'             => $cdata->growth_s_c,
                        'Temperature'              => $cdata->temperature,
                        'Number of Rainny Days'      => $cdata->numbrer_r_day,
                        'Pest Name'                => $pdata->pest_name,
                        'Location 01'              => $pdata->location_1?: '0',
                        'Location 02'              => $pdata->location_2?: '0',
                        'Location 03'              => $pdata->location_3?: '0',
                        'Location 04'              => $pdata->location_4?: '0',
                        'Location 05'              => $pdata->location_5?: '0',
                        'Location 06'              => $pdata->location_6?: '0',
                        'Location 07'              => $pdata->location_7?: '0',
                        'Location 08'              => $pdata->location_8?: '0',
                        'Location 09'              => $pdata->location_9?: '0',
                        'Location 10'              => $pdata->location_10?: '0',
                        'Total'                    => $pdata->total?: '0',
                        'Mean'                     => $pdata->mean?: '0',
                        'Code'                     => $pdata->code?: '0',
                        'Other Info'               => $cdata->otherinfo?: 'N/A',
                    ];
                }
                // else{
                //     $result[] = [
                //         'Data Collected Date'      => '',
                //         'Name'                    => '',
                //         'Email'                   => '',
                //         'Phone Number'            => '',
                //         'Collector District'      => '',
                //         'Collector ASC'           => '',
                //         'Collector Ai Range'      => '',
                //         'Collector Village'        => '',
                //         'Collector GPS Latitude'   => '',
                //         'Collector GPS Longitude'   =>'',
                //         'Collector Rice Variety'   => '',
                //         'Date Established'         => '',
    
                //         'Growth Stage'             => '',
                //         'Temperature'              => '',
                //         'Number of Rainny Days'      => '',
                //         'Pest Name'                => $pdata->pest_name,
                //         'Location 01'              => $pdata->location_1?: '0',
                //         'Location 02'              => $pdata->location_2?: '0',
                //         'Location 03'              => $pdata->location_3?: '0',
                //         'Location 04'              => $pdata->location_4?: '0',
                //         'Location 05'              => $pdata->location_5?: '0',
                //         'Location 06'              => $pdata->location_6?: '0',
                //         'Location 07'              => $pdata->location_7?: '0',
                //         'Location 08'              => $pdata->location_8?: '0',
                //         'Location 09'              => $pdata->location_9?: '0',
                //         'Location 10'              => $pdata->location_10?: '0',
                //         'Total'                    => $pdata->total?: '0',
                //         'Mean'                     => $pdata->mean?: '0',
                //         'Code'                     => $pdata->code?: '0',
                //         'Other Info'               => '',
                //     ];
                // }
                
                $hasPestData = true;
            }

            // Add an empty row if there was pest data for the current cdata
            // Add an empty row if there was pest data for the current cdata
            if ($hasPestData) {
                $result[] = [
                    'Data Collected Date' => '',
                    'Name' => '',
                    'Email' => '',
                    'Phone Number' => '',
                    'District' => '',
                    'ASC' => '',
                    'Ai Range' => '',
                    'Village' => '',
                    'GPS Latitude' => '',
                    'GPS Longitude' => '',
                    'Rice Variety' => '',
                    'Date Established' => '',

                    'Growth Stage' => '',
                    'Temperature' => '',
                    'Number of Rainny Days' => '',
                    'Pest Name' => '',
                    'Location 01' => '',
                    'Location 02' => '',
                    'Location 03' => '',
                    'Location 04' => '',
                    'Location 05' => '',
                    'Location 06' => '',
                    'Location 07' => '',
                    'Location 08' => '',
                    'Location 09' => '',
                    'Location 10' => '',
                    'Total' => '',
                    'Mean' => '',
                    'Code' => '',
                    'Other Info' => '',
                ]; // This will create an empty row with blank cells
            }
        }

        return collect($result);
    }


    public function headings(): array
    {
        return [
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
