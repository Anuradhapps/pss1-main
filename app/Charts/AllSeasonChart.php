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
            ->setGrid()

            // Modern color palette
            ->setColors([
                '#10b981', // Emerald
                '#3b82f6', // Blue
                '#f59e0b', // Amber
                '#ef4444', // Red
                '#8b5cf6', // Violet
                '#06b6d4', // Cyan
            ])

            // Rounded / modern bars
            ->setDataLabels(false)

            // Responsive height
            ->setHeight(420);

        foreach ($pestData['data'] as $data) {
            $chart->addData(
                $data['seasonName'],
                $data['pestCodes']
            );
        }

        return $chart;
    }
}
