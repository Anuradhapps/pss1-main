<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\RiceSeason;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiceSeasonController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(RiceSeason $riceSeason)
    {
        //
    }

    public function edit(RiceSeason $riceSeason)
    {
        //
    }

    public function update(Request $request, RiceSeason $riceSeason)
    {
        //
    }

    public function destroy(RiceSeason $riceSeason)
    {
        //
    }

    public function getSeasson($year=null) {
        $date=0;
        // Get the current date
        if($year==null){
            $date = Carbon::now();
        }else{
            $date = Carbon::create($year, 7, 1);
        }
        
        // $date = Carbon::create(2022-01-01);
        
        // Extract the current year and month
        $currentYear = $date->year;
        $currentMonth = $date->month;
        
        // Check if the date is between February 1 and September 30
        if ($date->between(Carbon::create($currentYear, 2, 1), Carbon::create($currentYear, 9, 30))) {
            // Yala season (March 1 to September 30)
            return [
                'startDate' => "$currentYear-03-01",
                'endDate' => "$currentYear-09-30",
                'seasonName' => "$currentYear Yala",
                'seasonId'=>$currentYear
            ];
        } else {
            // Maha season (October 1 to February 28/29)
            if ($currentMonth === 1) {
                // If it's January, we are still in the previous year's Maha season
                $previousYear = $currentYear - 1;
                return [
                    'startDate' => "$previousYear-10-01",
                    'endDate' => "$currentYear-02-28",
                    'seasonName' => "$previousYear/$currentYear Maha",
                    'seasonId'=>"$previousYear$currentYear"
                ];
            } else {
                // Otherwise, we are in the current year's Maha season
                $nextYear = $currentYear + 1;
                return [
                    'startDate' => "$currentYear-10-01",
                    'endDate' => Carbon::create($nextYear, 2, 28)->isLeapYear() ? "$nextYear-02-29" : "$nextYear-02-28",
                    'seasonName' => "$currentYear/$nextYear Maha",
                    'seasonId'=>"$currentYear$nextYear"
                ];
            }
        }
    }
}
