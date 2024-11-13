<?php

namespace App\Charts;

use App\Models\As_center;
use App\Models\RiceSeason;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ChartASC
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($pestData): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $pestNames = array_keys($pestData['pests']);
        $pestCodes = array_values($pestData['pests']);
        $season = RiceSeason::find($pestData['season']);
        $as_center = As_center::find($pestData['as_center']);

        return $this->chart->barChart()
            ->setTitle($season->name . ' ➔ ' . $as_center->name . ' ASC')
            ->addData('Code', $pestCodes)
            ->setXAxis($pestNames)
            ->setGrid();
    }
}
