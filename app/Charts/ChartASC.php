<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class ChartASC
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($collectors): \ArielMejiaDev\LarapexCharts\BarChart
    {
        

        return $this->chart->barChart()
            ->setTitle('test')
            ->setSubtitle('During season 2024.')
            ->addData('test 1', [6, 9, 3, 4, 10, 8])
            ->addData('test 2', [7, 3, 8, 2, 6, 4])
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
    }
}
