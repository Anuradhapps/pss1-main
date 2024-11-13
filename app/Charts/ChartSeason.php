<?php

namespace App\Charts;

use App\Models\RiceSeason;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ChartSeason
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

        return $this->chart->barChart()
            ->setTitle($season->name.' ➔  All Island')
            ->setSubtitle('During season '.$season->name.'.')
            ->addData('Code', $pestCodes)
            ->setXAxis($pestNames)
            ->setGrid();
    }
}
