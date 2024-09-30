<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use App\Models\district;
use App\Models\temp1;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Report2 extends Component
{

    

    //public $dis;
    public $selectedasc;
    public $selecteddistrict;
    public $selectedgs;
    public $fromdate;
    public $todate;
    public $showingSoilModal;

    public $selectedState = NULL;


    public $soildata;
    
    public $editmode;
    public $editmodeferti;
    public $editmodeins;

    public $tillerstemp;
    public $thripstemp;
    Public $gallmidgetemp;
    public $leaffoldertemp;
    public  $yellowertemp;
    public  $bhptemp;
    public $paddybugtemp;

    public $selectedrange;
    public $end_date;


    public function test1(){
        dd($this->selecteddistrict);
        }

    public function mount(){
        $this->fromdate = Carbon::now()->addDay(-7)->format('Y-m-d');
        $this->todate = Carbon::now()->addDay(1)->format('Y-m-d');
        $this->selectedrange='1';
    }

    public function render()
    { 
        return view('livewire.report2',
            
            //['ds'=>province::get()],

            [
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
            

            'airange'=>DB::table("collectors")->select('collectors.asc','collectors.ai_range')->

            when((Auth::user()) == null, (function ($a) {
                $a->where('collectors.asc','!=','0');
            }))->
            when($this->selectedasc != null, (function ($a) {
                $a->where('collectors.asc', '=', $this->selectedasc );
            }))->
            when($this->selectedasc == null, (function ($a) {
                $a->where('collectors.asc', '=', '0' );
            }))->get(),
            

            'alldata'=>DB::table('users')
            ->select('temperature','numbrer_r_day','growth_s_c','otherdet','districts.name as dname','as_centers.name as ascname','collectors.ai_range as airange')
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('districts','districts.id','=','collectors.district')
            ->join('as_centers','as_centers.id','=','collectors.asc')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->where('otherdet','<>','')
            ->whereBetween('common_data_collects.created_at', [$this->fromdate, $this->todate])
            
            ->when($this->selecteddistrict != null, (function ($a) {
                $a->where('as_centers.district_id', '=', $this->selecteddistrict );
            }))
            ->when($this->selectedasc != null, (function ($a) {
                $a->where('collectors.asc', '=', $this->selectedasc );
            }))

            ->get(),

            'selrange'=>$this->selectedrange,          
            
            ]

        );

    }


    public function clear1()
    {           
        $this->selectedasc=''; 
        
        
    }

    public function clear2()
    {           
        
        //$this->selecteddistrict='0';
        //$this->selectedgs='0'; 
    }

    public function clear3()
    {           
        
        $this->selectedgs='0'; 
    }



}
