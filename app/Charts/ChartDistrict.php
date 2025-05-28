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
        $pestNamess = collect($pestNames)->map(function ($item) {
            return match ($item) {
                'thrips' => 'Thrips',
                'gallMidge' => 'Gall Midge',
                'leaffolder' => 'Leaffolder',
                'yellowStemBorer' => 'Yellow Stem Borer',
                'bphWbph' => 'Brown Planthopper/WBPH',
                'paddyBug' => 'Paddy Bug',
                default => $item,
            };
        })->toArray();
        return $this->chart->barChart()
            ->setTitle($season->name . ' ➔ ' . $district->name . ' District')
            ->addData('Code', $pestCodes)
            ->setXAxis($pestNamess)
            ->setGrid();
    }
}
