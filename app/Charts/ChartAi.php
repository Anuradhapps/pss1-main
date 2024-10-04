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
        $pestData = $collector->user->commonDataCollect[0]->pestDataCollect->toArray();
        $pests = array_column($pestData, 'pest_name');
        $dataArray = [];
        $i = 0;
        foreach ($collector->user->commonDataCollect as $cdata) {
            // Initialize the c_data and an empty array for p_data
            $dataArray[] = [
                'c_data' => $cdata->c_date,
                'p_data' => [] // Initialize p_data as an empty array
            ];
            // Collect all p_data codes and append to the current item
            foreach ($cdata->pestDataCollect as $p_data) {
                $dataArray[$i]['p_data'][] = $p_data->code; // Append each p_data code to the array
            }
            $i++;
        }

        foreach ($pests as $pest) {
        }
        $chart = $this->chart->barChart()
            ->setTitle($collector->getProvince->name . ' > ' . $collector->getDistrict->name . ' > ' . $collector->getAsCenter->name . ' > ' . $collector->getAiRange->name . ' > ')
            ->setSubtitle('During season 2024')
            ->setXAxis($pests);

        // Add data to the chart after initialization
        foreach ($dataArray as $data) {
            $chart->addData($data['c_data'], $data['p_data']);
        }



        // $chart->addData('kkk',[6, 9, 3]);
        return $chart;
    }
}
