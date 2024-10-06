<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ChartAi
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($collector): \ArielMejiaDev\LarapexCharts\BarChart
    {
        try {
            $pestData = $collector->user->commonDataCollect[0]->pestDataCollect->toArray();
        } catch (\Throwable $th) {
            return redirect()->route('chart.index')->with('error', 'No data found');
        }



        $pests = array_column($pestData, 'pest_name');
        array_shift($pests);

        $dataArray = [];
        $i = 0;
        $cdataCount = $collector->user->commonDataCollect->count();
        $colorArray = [];
        for ($j = 0; $j < $cdataCount; $j++) {
            $colorArray[] = '#' . substr(md5(mt_rand()), 0, 6);
        }
        foreach ($collector->user->commonDataCollect as $cdata) {
            // Initialize the c_data and an empty array for p_data
            $dataArray[] = [
                'c_data' => $cdata->c_date,
                'p_data' => [] // Initialize p_data as an empty array
            ];
            // Collect all p_data codes and append to the current item
            foreach ($cdata->pestDataCollect as $p_data) {

                if ($p_data->pest_name != 'Number_Of_Tillers') {
                    $dataArray[$i]['p_data'][] = $p_data->code; // Append each p_data code to the array
                }
            }
            $i++;
        }


        $chart = $this->chart->barChart()
            ->setTitle($collector->getProvince->name . ' > ' . $collector->getDistrict->name . ' > ' . $collector->getAsCenter->name . ' > ' . $collector->getAiRange->name . ' > ')
            ->setSubtitle('During Maha season 2024/25')
            ->setXAxis($pests)
            ->setColors($colorArray)
            ->setGrid('#3F51B5', 0.1)
            ;

        // Add data to the chart after initialization
        foreach ($dataArray as $data) {
            $chart->addData($data['c_data'], $data['p_data']);
        }



        // $chart->addData('kkk',[6, 9, 3]);
        return $chart;
    }
}
