<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class AllSeasonChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($pestData): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $chart = $this->chart->barChart()
            ->setTitle($pestData['location'])
            ->setXAxis($pestData['pestNames'])
            ->setGrid();

        foreach ($pestData['data'] as $data) {
            $chart->addData($data['seasonName'], $data['pestCodes']);
        }
        return $chart;
    }
}
