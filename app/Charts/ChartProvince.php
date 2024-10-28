<?php

namespace App\Charts;

use App\Models\Province;
use App\Models\RiceSeason;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ChartProvince
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($pestData): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $pestNames = array_keys($pestData['pests']);
        $pestCounts = array_values($pestData['pests']);
        $season = RiceSeason::find($pestData['season']);
        $province = Province::find($pestData['province']);

        return $this->chart->barChart()
            ->setTitle($season->name.' '.$province->name.' Province')
            ->addData('San Francisco', $pestCounts)
            ->setXAxis($pestNames);
    }
}
