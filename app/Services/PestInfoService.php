<?php

namespace App\Services;

use App\Models\Collector;
use App\Models\CommonDataCollect;
use Carbon\Carbon;

class PestInfoService
{
    protected $textService;

    public function __construct(TextCorrectionService $textService)
    {
        $this->textService = $textService;
    }


    //Pest code generate---------------------------------------------------------------------------------------------


    private function calculatePestCode(string $pestName, int $totalTillers, int $totalPests): array
    {
        switch ($pestName) {
            case 'Gall Midge':
                $result = $this->getGallMidgeCode($totalTillers, $totalPests);
                break;
            case 'Leaffolder':
                $result = $this->getLeaffolderCode($totalTillers, $totalPests);
                break;
            case 'Yellow Stem Borer':
                $result = $this->getYellowStemBorerCode($totalTillers, $totalPests);
                break;
            case 'BPH+WBPH':
                $result = $this->getBphWbphCode($totalTillers, $totalPests);
                break;
            case 'Paddy Bug':
                $result = $this->getPaddyBugCode($totalTillers, $totalPests);
                break;
            default:
                $result = ['mean' => 0, 'code' => 0];
        }

        return [$result['mean'], $result['code']];
    }

    public function getGallMidgeCode($tillerTotal, $pestTotal)
    {
        if ($tillerTotal == 0) {
            return ['mean' => 0, 'code' => 0];
        }

        // Calculate mean as a percentage
        $mean = ($pestTotal / $tillerTotal) * 100;

        // Determine the code based on mean ranges
        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean <= 1) {
            $code = 1;
        } elseif ($mean > 1 && $mean < 6) {
            $code = 3;
        } elseif ($mean >= 6 && $mean < 11) {
            $code = 5;
        } elseif ($mean >= 11 && $mean < 26) {
            $code = 7;
        } else { // mean >= 26
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    public function getLeaffolderCode($tillerTotal, $pestTotal)
    {
        if ($tillerTotal == 0) {
            return ['mean' => 0, 'code' => 0];
        }

        $mean = ($pestTotal / $tillerTotal) * 100;
        $code = 0;

        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean < 6) {
            $code = 1;
        } elseif ($mean >= 6 && $mean < 11) {
            $code = 3;
        } elseif ($mean >= 11 && $mean < 21) {
            $code = 5;
        } elseif ($mean >= 21 && $mean < 51) {
            $code = 7;
        } else { // mean >= 51
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    public function getYellowStemBorerCode($tillerTotal, $pestTotal)
    {
        if ($tillerTotal == 0) {
            return ['mean' => 0, 'code' => 0];
        }

        $mean = ($pestTotal / $tillerTotal) * 100;
        $code = 0;

        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean < 2) {
            $code = 1;
        } elseif ($mean >= 2 && $mean < 4) {
            $code = 3;
        } elseif ($mean >= 4 && $mean < 11) {
            $code = 5;
        } elseif ($mean >= 11 && $mean < 51) {
            $code = 7;
        } else { // mean >= 51
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    public function getBphWbphCode($tillerTotal, $pestTotal)
    {
        if ($tillerTotal == 0) {
            return ['mean' => 0, 'code' => 0];
        }

        // Note: mean here is pest per tiller (not multiplied by 100)
        $mean = $pestTotal / $tillerTotal;
        $code = 0;

        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean < 2) {
            $code = 1;
        } elseif ($mean >= 2 && $mean < 6) {
            $code = 3;
        } elseif ($mean >= 6 && $mean < 11) {
            $code = 5;
        } elseif ($mean >= 11 && $mean < 21) {
            $code = 7;
        } else { // mean >= 21
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    public function getPaddyBugCode($tillerTotal, $pestTotal)
    {
        // Since mean is pestTotal / 10, check if pestTotal is numeric and > 0
        if ($pestTotal === 0) {
            return ['mean' => 0, 'code' => 0];
        }

        $mean = $pestTotal / 10;
        $code = 0;

        if ($mean == 0) {
            $code = 0;
        } elseif ($mean > 0 && $mean < 2) {
            $code = 1;
        } elseif ($mean >= 2 && $mean < 5) {
            $code = 3;
        } elseif ($mean >= 5 && $mean < 16) {
            $code = 5;
        } elseif ($mean >= 16 && $mean < 21) {
            $code = 7;
        } else { // mean >= 21
            $code = 9;
        }

        return [
            'mean' => round($mean, 2),
            'code' => $code,
        ];
    }

    //when input collector
    public function avarageCalculate($collectors)
    {

        if ($collectors->count() == 0) {
            return [
                "pests" => [
                    "thrips" => 0,
                    "gallMidge" => 0,
                    "leaffolder" => 0,
                    "yellowStemBorer" => 0,
                    "bphWbph" => 0,
                    "paddyBug" => 0
                ]
            ];
        }
        $noOfTillers = 0;
        $thrips = 0;
        $gallMidge = 0;
        $leaffolder = 0;
        $yellowStemBorer = 0;
        $bphWbph = 0;
        $paddyBug = 0;

        $thripscount = 0;

        $otherInfo = [];
        foreach ($collectors as $collector) {

            foreach ($collector->commonDataCollect as $commonData) {
                foreach ($commonData->pestDataCollect as $pestData) {

                    if ($pestData->pest_name == 'Number_Of_Tillers') {
                        $noOfTillers += $pestData->total;
                    } elseif ($pestData->pest_name == 'Thrips') {
                        $thripscount++;
                        $thrips += $pestData->code;
                    } elseif ($pestData->pest_name == 'Gall Midge') {
                        $gallMidge += $pestData->total;
                    } elseif ($pestData->pest_name == 'Leaffolder') {
                        $leaffolder += $pestData->total;
                    } elseif ($pestData->pest_name == 'Yellow Stem Borer') {
                        $yellowStemBorer += $pestData->total;
                    } elseif ($pestData->pest_name == 'BPH+WBPH') {
                        $bphWbph += $pestData->total;
                    } elseif ($pestData->pest_name == 'Paddy Bug') {
                        $paddyBug += $pestData->total;
                    }
                }


                if (!empty($commonData->otherinfo)) {
                    $aiRange = $this->textService->correctText($collector->getAiRange->name);
                    $otherinfo = $this->textService->correctText($commonData->otherinfo);
                    $otherInfo[] = $aiRange . ' --> ' . $otherinfo;
                }
            }
        }
        $possibleCodes = [0, 1, 3, 5, 7, 9];
        $thripsC = 0;
        if ($thripscount == 0) {
            $thripsC = 0;
        } else {
            $thripsC = $thrips / $thripscount;
        }


        $thripsCode = $this->getNearestCode($thripsC, $possibleCodes);
        $gallMidgeCode = 0;
        $leaffolderCode = 0;
        $yellowStemBorerCode = 0;
        $bphWbphCode = 0;
        $paddyBugCode = 0;
        if ($noOfTillers != 0) {
            $gallMidgeCode = $this->getgallMidgeCode($noOfTillers, $gallMidge)['code'];
            $leaffolderCode = $this->getLeaffolderCode($noOfTillers, $leaffolder)['code'];
            $yellowStemBorerCode = $this->getYellowStemBorerCode($noOfTillers, $yellowStemBorer)['code'];
            $bphWbphCode = $this->getBphWbphCode($noOfTillers, $bphWbph)['code'];
            $paddyBugCode = $this->getPaddyBugCode($noOfTillers, $paddyBug)['code'];
        }
        return [
            "pests" => [
                "thrips" => $thripsCode,
                "gallMidge" => $gallMidgeCode,
                "leaffolder" => $leaffolderCode,
                "yellowStemBorer" => $yellowStemBorerCode,
                "bphWbph" => $bphWbphCode,
                "paddyBug" => $paddyBugCode
            ],
            "OtherInfo" => $otherInfo
        ];
    }
    public function avarageCalculateByCommonData($commonDatas)
    {

        if ($commonDatas->count() == 0) {
            return [
                "pests" => [
                    "thrips" => 0,
                    "gallMidge" => 0,
                    "leaffolder" => 0,
                    "yellowStemBorer" => 0,
                    "bphWbph" => 0,
                    "paddyBug" => 0
                ]
            ];
        }
        $noOfTillers = 0;
        $thrips = 0;
        $gallMidge = 0;
        $leaffolder = 0;
        $yellowStemBorer = 0;
        $bphWbph = 0;
        $paddyBug = 0;
        $temperature = 0;
        $rainnyDays = 0;
        $tempCount = 0;
        $rainCount = 0;


        $thripscount = 0;



        foreach ($commonDatas as $commonData) {
            if ($commonData->temperature != null || 0) {
                $tempCount++;
                $temperature += $commonData->temperature;
            }
            if ($commonData->numbrer_r_day != null || 0) {
                $rainCount++;
                $rainnyDays += $commonData->numbrer_r_day;
            }

            foreach ($commonData->pestDataCollect as $pestData) {

                if ($pestData->pest_name == 'Number_Of_Tillers') {
                    $noOfTillers += $pestData->total;
                } elseif ($pestData->pest_name == 'Thrips') {
                    $thripscount++;
                    $thrips += $pestData->code;
                } elseif ($pestData->pest_name == 'Gall Midge') {
                    $gallMidge += $pestData->total;
                } elseif ($pestData->pest_name == 'Leaffolder') {
                    $leaffolder += $pestData->total;
                } elseif ($pestData->pest_name == 'Yellow Stem Borer') {
                    $yellowStemBorer += $pestData->total;
                } elseif ($pestData->pest_name == 'BPH+WBPH') {
                    $bphWbph += $pestData->total;
                } elseif ($pestData->pest_name == 'Paddy Bug') {
                    $paddyBug += $pestData->total;
                }
            }
        }

        $possibleCodes = [0, 1, 3, 5, 7, 9];
        $thripsC = 0;
        if ($thripscount == 0) {
            $thripsC = 0;
        } else {
            $thripsC = $thrips / $thripscount;
        }


        $thripsCode = $this->getNearestCode($thripsC, $possibleCodes);
        $gallMidgeCode = 0;
        $leaffolderCode = 0;
        $yellowStemBorerCode = 0;
        $bphWbphCode = 0;
        $paddyBugCode = 0;
        if ($noOfTillers != 0) {
            $gallMidgeCode = $this->getgallMidgeCode($noOfTillers, $gallMidge)['code'];
            $leaffolderCode = $this->getLeaffolderCode($noOfTillers, $leaffolder)['code'];
            $yellowStemBorerCode = $this->getYellowStemBorerCode($noOfTillers, $yellowStemBorer)['code'];
            $bphWbphCode = $this->getBphWbphCode($noOfTillers, $bphWbph)['code'];
            $paddyBugCode = $this->getPaddyBugCode($noOfTillers, $paddyBug)['code'];
        }
        return [
            "pests" => [
                "thrips" => $thripsCode,
                "gallMidge" => $gallMidgeCode,
                "leaffolder" => $leaffolderCode,
                "yellowStemBorer" => $yellowStemBorerCode,
                "bphWbph" => $bphWbphCode,
                "paddyBug" => $paddyBugCode
            ],
            "temperature" => $temperature / $tempCount,
            "rainnyDays" => round($rainnyDays / $rainCount),

        ];
    }
    // Function to find the nearest number
    function getNearestCode($value, $possibleCodes)
    {
        return array_reduce($possibleCodes, function ($carry, $item) use ($value) {
            return (abs($item - $value) < abs($carry - $value)) ? $item : $carry;
        }, $possibleCodes[0]);
    }

    public function filterCollectorsByDistrictAndDuration(?int $districtId = null, ?int $days = null)
    {

        $query = Collector::query();

        // Filter by district (via collectors relationship)
        if (!empty($districtId) && $districtId !== 0) {
            $query->where('district', $districtId);
        }

        // Filter by duration (last N days)
        if (!empty($days) && $days > 0) {
            $query->whereHas('commonDataCollect', function ($q) use ($days) {
                $startDate = Carbon::now()->subDays($days)->startOfDay();
                $q->where('c_date', '>=', $startDate);
            });
        }

        // Example: get average pest code (adjust your column name)
        $collectors = $query->get();

        return  $collectors;
    }


    public function avaragePestCodeByDistrictAndDuration(?int $districtId = null, ?int $days = null)
    {
        $collectors =  $this->filterCollectorsByDistrictAndDuration($districtId, $days);
        return $this->avarageCalculate($collectors);
    }
}
