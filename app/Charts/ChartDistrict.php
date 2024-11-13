<?php

namespace App\Charts;

use App\Models\district;
use App\Models\RiceSeason;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ChartDistrict
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
        $district = district::find($pestData['district']);

        return $this->chart->barChart()
            ->setTitle($season->name . ' ➔ ' . $district->name . ' Province')
            ->addData('Code', $pestCodes)
            ->setXAxis($pestNames)
            ->setGrid();
    }
}
