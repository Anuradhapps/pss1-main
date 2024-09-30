<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Carbon\Carbon;
use App\Models\OT_list;
use App\Models\temp_chart;
use App\Models\district;


class maindashboard extends Component
{

    public $chartyear;
    public $test;
    public $fromdate;
    public $year;

    public $from;
    public $to;

    public $selecteddistrict;
    public $selectedasc; 
    

    public function render()
    {     
        $from = date($this->fromdate);
        $to = date('2024-05-02');
        //dd($this->fromdate);
        return view('livewire.maindashboard',[
                    
            'PaddyBug'=>DB::table('users')
            ->select('districts.name', 'pest_name', DB::raw('SUM(location_one) AS L1'))
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
            ->join('districts','districts.id','=','collectors.district')
            ->groupBy('pest_name','districts.name')
            ->where('pest_name','=','Paddy Bug')
            ->whereBetween('pest_data_collects.created_at', [$from, $to])
            //->where('pest_data_collects.created_at','=',$this->fromdate)
            ->get(),

            'BHPWBHP'=>DB::table('users')
            ->select('districts.name', 'pest_name', DB::raw('SUM(location_one) AS L1'))
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
            ->join('districts','districts.id','=','collectors.district')
            ->groupBy('pest_name','districts.name')
            ->where('pest_name','=','BHP+WBHP')
            ->get(),

            'dis'=>district::orderBy('name')->get(),

            'asc'=>DB::table("as_centers")->select('as_centers.id','as_centers.name')->

            when((Auth::user()) == null, (function ($a) {
                $a->where('as_centers.id','!=','0');
            }))->
            when($this->selecteddistrict != null, (function ($a) {
                $a->where('as_centers.district_id', '=', $this->selecteddistrict );
            }))->
            when($this->selecteddistrict == null, (function ($a) {
                $a->where('as_centers.district_id', '=', '0' );
            }))->get(),
         
        ]);

        
    }

    public function test1(){
    dd($this->selecteddistrict);
    }

}
