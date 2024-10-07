<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ChartDistrict
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($collector): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle($collector->getProvince->name . ' > ' . $collector->getDistrict->name )
            ->setSubtitle('During season 2024.')
            ->addData('Test', [6, 9, 3, 4, 10, 8])
            ->addData('Test', [7, 3, 8, 2, 6, 4])
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
    }
}
