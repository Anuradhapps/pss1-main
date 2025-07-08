<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Exception;

class ChartAi
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($collector): \ArielMejiaDev\LarapexCharts\BarChart
    {
        try {
            if ($collector->commonDataCollect->isEmpty()) {
                throw new Exception('No data available');
            }
        } catch (Exception $e) {
            return redirect()->route('chart.index')->with('error', 'No pest data available for this AI range.');
        }

        // Get pest names (excluding 'Number_Of_Tillers')
        $firstEntry = $collector->commonDataCollect->first();
        $pestNames = $firstEntry->pestDataCollect
            ->where('pest_name', '!=', 'Number_Of_Tillers')
            ->pluck('pest_name')
            ->map(function ($name) {
                return match ($name) {
                    'BPH+WBPH' => 'Brown Planthopper / WBPH',
                    'Gall Midge' => 'Gall Midge',
                    'Leaffolder' => 'Leaf Folder',
                    'Yellow Stem Borer' => 'YSB',
                    default => $name,
                };
            })
            ->unique()
            ->values()
            ->toArray();

        $colorPalette = [
            '#FF6384',
            '#36A2EB',
            '#FFCE56',
            '#4BC0C0',
            '#9966FF',
            '#FF9F40',
            '#C9CBCF',
            '#607D8B'
        ];

        $chart = $this->chart->barChart()
            ->setTitle("Pest Infestation Levels")
            ->setSubtitle(
                "{$collector->getProvince->name} > {$collector->getDistrict->name} > {$collector->getAsCenter->name} > {$collector->getAiRange->name} ({$collector->riceSeason->name})"
            )
            ->setXAxis($pestNames)
            ->setColors($colorPalette)
            ->setGrid('#888', 0.3);

        // Prepare data: each dataset is one date (c_date)
        foreach ($collector->commonDataCollect as $dataEntry) {
            $label = $dataEntry->c_date;
            $pestCodes = [];

            foreach ($pestNames as $pest) {
                $pestRaw = $this->normalizePestName($pest);
                $code = $dataEntry->pestDataCollect
                    ->where('pest_name', $pestRaw)
                    ->first()
                    ->code ?? 0;

                $pestCodes[] = $code;
            }

            $chart->addData($label, $pestCodes);
        }

        return $chart;
    }

    private function normalizePestName($name)
    {
        return match ($name) {
            'Brown Planthopper / WBPH' => 'BPH+WBPH',
            'Leaf Folder' => 'Leaffolder',
            'YSB' => 'Yellow Stem Borer',
            default => $name,
        };
    }
}
