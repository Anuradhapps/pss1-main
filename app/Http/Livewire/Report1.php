<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use App\Models\district;
use App\Models\temp1;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Report1 extends Component
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
    
        $tillerstemp=DB::table('users')
        ->select('districts.name as dname','ai_range', 'pest_name','collectors.asc','as_centers.name as ascname' 
        , DB::raw('SUM(location_one) AS L1') 
        , DB::raw('SUM(location_two) AS L2')
        , DB::raw('SUM(location_three) AS L3')
        , DB::raw('SUM(location_four) AS L4')
        , DB::raw('SUM(location_five) AS L5')
        , DB::raw('SUM(location_six) AS L6')
        , DB::raw('SUM(location_seven) AS L7')
        , DB::raw('SUM(location_eight) AS L8')
        , DB::raw('SUM(location_nine) AS L9')
        , DB::raw('SUM(location_ten) AS L10')
        ,DB::raw('count(location_one) AS reccount') 
        )
        ->join('collectors','users.id','=','collectors.user_id')
        ->join('as_centers','as_centers.id','=','collectors.asc')
        ->join('common_data_collects','users.id','=','common_data_collects.user_id')
        ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
        ->join('districts','districts.id','=','collectors.district')
        ->groupBy('pest_name','districts.name','collectors.asc','as_centers.name','ai_range')
        ->where('pest_name','=','Tillers')
        ->
        when($this->selecteddistrict != null, (function ($a) {
            $a->where('collectors.district', '=', $this->selecteddistrict );
        }))
        ->
        when($this->selectedasc != null, (function ($a) {
            $a->where('collectors.asc', '=', $this->selectedasc );
        }))
        ->
        when($this->fromdate != null, (function ($a) {
            $a->whereBetween('pest_data_collects.created_at', [$this->fromdate, $this->todate]) ;
        }))
        //->whereBetween('pest_data_collects.created_at', [$from, $to])
        //->where('pest_data_collects.created_at','=',$this->fromdate)
        ->get();  

        $thripstemp=DB::table('users')
            ->select('districts.name as dname','ai_range', 'pest_name','collectors.asc','as_centers.name as ascname' 
            , DB::raw('SUM(location_one) AS L1') 
            , DB::raw('SUM(location_two) AS L2')
            , DB::raw('SUM(location_three) AS L3')
            , DB::raw('SUM(location_four) AS L4')
            , DB::raw('SUM(location_five) AS L5')
            , DB::raw('SUM(location_six) AS L6')
            , DB::raw('SUM(location_seven) AS L7')
            , DB::raw('SUM(location_eight) AS L8')
            , DB::raw('SUM(location_nine) AS L9')
            , DB::raw('SUM(location_ten) AS L10')
            ,DB::raw('count(location_one) AS reccount') 
            )
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('as_centers','as_centers.id','=','collectors.asc')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
            ->join('districts','districts.id','=','collectors.district')
            ->groupBy('pest_name','districts.name','collectors.asc','as_centers.name','ai_range')
            ->where('pest_name','=','Thrips')
            ->
            when($this->selecteddistrict != null, (function ($a) {
                $a->where('collectors.district', '=', $this->selecteddistrict );
            }))
            ->
            when($this->selectedasc != null, (function ($a) {
                $a->where('collectors.asc', '=', $this->selectedasc );
            }))
            ->
            when($this->fromdate != null, (function ($a) {
                $a->whereBetween('pest_data_collects.created_at', [$this->fromdate, $this->todate]) ;
            }))
            //->whereBetween('pest_data_collects.created_at', [$from, $to])
            //->where('pest_data_collects.created_at','=',$this->fromdate)
            ->get();

            $gallmidgetemp=DB::table('users')
            ->select('districts.name as dname','ai_range', 'pest_name','collectors.asc','as_centers.name as ascname' 
            , DB::raw('SUM(location_one) AS L1') 
            , DB::raw('SUM(location_two) AS L2')
            , DB::raw('SUM(location_three) AS L3')
            , DB::raw('SUM(location_four) AS L4')
            , DB::raw('SUM(location_five) AS L5')
            , DB::raw('SUM(location_six) AS L6')
            , DB::raw('SUM(location_seven) AS L7')
            , DB::raw('SUM(location_eight) AS L8')
            , DB::raw('SUM(location_nine) AS L9')
            , DB::raw('SUM(location_ten) AS L10')
            ,DB::raw('count(location_one) AS reccount') 
            )
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('as_centers','as_centers.id','=','collectors.asc')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
            ->join('districts','districts.id','=','collectors.district')
            ->groupBy('pest_name','districts.name','collectors.asc','as_centers.name','ai_range')
            ->where('pest_name','=','Gall Midge')
            ->
            when($this->selecteddistrict != null, (function ($a) {
                $a->where('collectors.district', '=', $this->selecteddistrict );
            }))
            ->
            when($this->selectedasc != null, (function ($a) {
                $a->where('collectors.asc', '=', $this->selectedasc );
            }))
            ->
            when($this->fromdate != null, (function ($a) {
                $a->whereBetween('pest_data_collects.created_at', [$this->fromdate, $this->todate]) ;
            }))
            //->whereBetween('pest_data_collects.created_at', [$from, $to])
            //->where('pest_data_collects.created_at','=',$this->fromdate)
            ->get();


            $leaffoldertemp=DB::table('users')
            ->select('districts.name as dname','ai_range', 'pest_name','collectors.asc','as_centers.name as ascname' 
            , DB::raw('SUM(location_one) AS L1') 
            , DB::raw('SUM(location_two) AS L2')
            , DB::raw('SUM(location_three) AS L3')
            , DB::raw('SUM(location_four) AS L4')
            , DB::raw('SUM(location_five) AS L5')
            , DB::raw('SUM(location_six) AS L6')
            , DB::raw('SUM(location_seven) AS L7')
            , DB::raw('SUM(location_eight) AS L8')
            , DB::raw('SUM(location_nine) AS L9')
            , DB::raw('SUM(location_ten) AS L10')
            ,DB::raw('count(location_one) AS reccount') 
            )
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('as_centers','as_centers.id','=','collectors.asc')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
            ->join('districts','districts.id','=','collectors.district')
            ->groupBy('pest_name','districts.name','collectors.asc','as_centers.name','ai_range')
            ->where('pest_name','=','Leaf Folder')
            ->
            when($this->selecteddistrict != null, (function ($a) {
                $a->where('collectors.district', '=', $this->selecteddistrict );
            }))
            ->
            when($this->selectedasc != null, (function ($a) {
                $a->where('collectors.asc', '=', $this->selectedasc );
            }))
            ->
            when($this->fromdate != null, (function ($a) {
                $a->whereBetween('pest_data_collects.created_at', [$this->fromdate, $this->todate]) ;
            }))
            //->whereBetween('pest_data_collects.created_at', [$from, $to])
            //->where('pest_data_collects.created_at','=',$this->fromdate)
            ->get();


            $yellowertemp=DB::table('users')
            ->select('districts.name as dname','ai_range', 'pest_name','collectors.asc','as_centers.name as ascname' 
            , DB::raw('SUM(location_one) AS L1') 
            , DB::raw('SUM(location_two) AS L2')
            , DB::raw('SUM(location_three) AS L3')
            , DB::raw('SUM(location_four) AS L4')
            , DB::raw('SUM(location_five) AS L5')
            , DB::raw('SUM(location_six) AS L6')
            , DB::raw('SUM(location_seven) AS L7')
            , DB::raw('SUM(location_eight) AS L8')
            , DB::raw('SUM(location_nine) AS L9')
            , DB::raw('SUM(location_ten) AS L10')
            ,DB::raw('count(location_one) AS reccount') 
            )
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('as_centers','as_centers.id','=','collectors.asc')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
            ->join('districts','districts.id','=','collectors.district')
            ->groupBy('pest_name','districts.name','collectors.asc','as_centers.name','ai_range')
            ->where('pest_name','=','Yellower Stem Borer')
            ->
            when($this->selecteddistrict != null, (function ($a) {
                $a->where('collectors.district', '=', $this->selecteddistrict );
            }))
            ->
            when($this->selectedasc != null, (function ($a) {
                $a->where('collectors.asc', '=', $this->selectedasc );
            }))
            ->
            when($this->fromdate != null, (function ($a) {
                $a->whereBetween('pest_data_collects.created_at', [$this->fromdate, $this->todate]) ;
            }))
            //->whereBetween('pest_data_collects.created_at', [$from, $to])
            //->where('pest_data_collects.created_at','=',$this->fromdate)
            ->get();

            $bhptemp=DB::table('users')
            ->select('districts.name as dname','ai_range', 'pest_name','collectors.asc','as_centers.name as ascname' 
            , DB::raw('SUM(location_one) AS L1') 
            , DB::raw('SUM(location_two) AS L2')
            , DB::raw('SUM(location_three) AS L3')
            , DB::raw('SUM(location_four) AS L4')
            , DB::raw('SUM(location_five) AS L5')
            , DB::raw('SUM(location_six) AS L6')
            , DB::raw('SUM(location_seven) AS L7')
            , DB::raw('SUM(location_eight) AS L8')
            , DB::raw('SUM(location_nine) AS L9')
            , DB::raw('SUM(location_ten) AS L10')
            ,DB::raw('count(location_one) AS reccount') 
            )
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('as_centers','as_centers.id','=','collectors.asc')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
            ->join('districts','districts.id','=','collectors.district')
            ->groupBy('pest_name','districts.name','collectors.asc','as_centers.name','ai_range')
            ->where('pest_name','=','BHP+WBHP')
            ->
            when($this->selecteddistrict != null, (function ($a) {
                $a->where('collectors.district', '=', $this->selecteddistrict );
            }))
            ->
            when($this->selectedasc != null, (function ($a) {
                $a->where('collectors.asc', '=', $this->selectedasc );
            }))
            ->
            when($this->fromdate != null, (function ($a) {
                $a->whereBetween('pest_data_collects.created_at', [$this->fromdate, $this->todate]) ;
            }))
            //->whereBetween('pest_data_collects.created_at', [$from, $to])
            //->where('pest_data_collects.created_at','=',$this->fromdate)
            ->get();

            $paddybugtemp=DB::table('users')
            ->select('districts.name as dname','ai_range', 'pest_name','collectors.asc','as_centers.name as ascname' 
            , DB::raw('SUM(location_one) AS L1') 
            , DB::raw('SUM(location_two) AS L2')
            , DB::raw('SUM(location_three) AS L3')
            , DB::raw('SUM(location_four) AS L4')
            , DB::raw('SUM(location_five) AS L5')
            , DB::raw('SUM(location_six) AS L6')
            , DB::raw('SUM(location_seven) AS L7')
            , DB::raw('SUM(location_eight) AS L8')
            , DB::raw('SUM(location_nine) AS L9')
            , DB::raw('SUM(location_ten) AS L10')
            ,DB::raw('count(location_one) AS reccount') 
            )
            ->join('collectors','users.id','=','collectors.user_id')
            ->join('as_centers','as_centers.id','=','collectors.asc')
            ->join('common_data_collects','users.id','=','common_data_collects.user_id')
            ->join('pest_data_collects','pest_data_collects.common_data_collectors_id','=','common_data_collects.id')
            ->join('districts','districts.id','=','collectors.district')
            ->groupBy('pest_name','districts.name','collectors.asc','as_centers.name','ai_range')
            ->where('pest_name','=','Paddy Bug')
            ->
            when($this->selecteddistrict != null, (function ($a) {
                $a->where('collectors.district', '=', $this->selecteddistrict );
            }))
            ->
            when($this->selectedasc != null, (function ($a) {
                $a->where('collectors.asc', '=', $this->selectedasc );
            }))
            ->
            when($this->fromdate != null, (function ($a) {
                $a->whereBetween('pest_data_collects.created_at', [$this->fromdate, $this->todate]) ;
            }))
            //->whereBetween('pest_data_collects.created_at', [$from, $to])
            //->where('pest_data_collects.created_at','=',$this->fromdate)
            ->get();



        temp1::truncate();

        foreach($tillerstemp as $row) {
            temp1::create([
                
                'district'=>$row->dname,
                'ascenter'=>$row->ascname,
                'ai'=>$row->ai_range,
                'tillers'=>($row->L1+$row->L2+$row->L3+$row->L4+$row->L5+$row->L6+$row->L7+$row->L8+$row->L9+$row->L10),   
                'reccount'  =>   $row->reccount,        

            ]);
        }

        foreach($thripstemp as $row) {            
                $UpdateDetails = temp1::where('district', '=',  $row->dname)->where('ascenter', '=',  $row->ascname)->where('ai', '=',  $row->ai_range)->first();
                $UpdateDetails->thrips = ($row->L10);
                $UpdateDetails->reccount = ($row->reccount);
                $UpdateDetails->save();           
        }
        foreach($gallmidgetemp as $row) {            
                $UpdateDetails = temp1::where('district', '=',  $row->dname)->where('ascenter', '=',  $row->ascname)->where('ai', '=',  $row->ai_range)->first();
                $UpdateDetails->gallmidge = ($row->L1+$row->L2+$row->L3+$row->L4+$row->L5+$row->L6+$row->L7+$row->L8+$row->L9+$row->L10);
                $UpdateDetails->reccount = ($row->reccount);
                $UpdateDetails->save();           
        }
        foreach($leaffoldertemp as $row) {            
                $UpdateDetails = temp1::where('district', '=',  $row->dname)->where('ascenter', '=',  $row->ascname)->where('ai', '=',  $row->ai_range)->first();
                $UpdateDetails->leaffolder = ($row->L1+$row->L2+$row->L3+$row->L4+$row->L5+$row->L6+$row->L7+$row->L8+$row->L9+$row->L10);
                $UpdateDetails->reccount = ($row->reccount);
                $UpdateDetails->save();           
        }
        foreach($yellowertemp as $row) {            
            $UpdateDetails = temp1::where('district', '=',  $row->dname)->where('ascenter', '=',  $row->ascname)->where('ai', '=',  $row->ai_range)->first();
            $UpdateDetails->yellowerstemborer = ($row->L1+$row->L2+$row->L3+$row->L4+$row->L5+$row->L6+$row->L7+$row->L8+$row->L9+$row->L10);
            $UpdateDetails->reccount = ($row->reccount);
            $UpdateDetails->save();           
        }

        foreach($bhptemp as $row) {            
            $UpdateDetails = temp1::where('district', '=',  $row->dname)->where('ascenter', '=',  $row->ascname)->where('ai', '=',  $row->ai_range)->first();
            $UpdateDetails->bhp = ($row->L1+$row->L2+$row->L3+$row->L4+$row->L5+$row->L6+$row->L7+$row->L8+$row->L9+$row->L10);
            $UpdateDetails->reccount = ($row->reccount);
            $UpdateDetails->save();           
        }
        foreach($paddybugtemp as $row) {            
            $UpdateDetails = temp1::where('district', '=',  $row->dname)->where('ascenter', '=',  $row->ascname)->where('ai', '=',  $row->ai_range)->first();
            $UpdateDetails->paddybug = ($row->L1+$row->L2+$row->L3+$row->L4+$row->L5+$row->L6+$row->L7+$row->L8+$row->L9+$row->L10);
            $UpdateDetails->reccount = ($row->reccount);
            $UpdateDetails->save();           
        }
        




        
        //sleep(seconds:5);
        //dd(Auth::user());
        //dd($this->selectedprovince);
        return view('livewire.report1',
            
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
            

            'alldata'=>DB::table('temp01')->select('district','ascenter','ai','reccount'
            ,DB::raw('SUM(tillers) AS tillers') 
            ,DB::raw('SUM(thrips) AS thrips') 
            ,DB::raw('SUM(gallmidge) AS gallmidge') 
            ,DB::raw('SUM(leaffolder) AS leaffolder') 
            ,DB::raw('SUM(yellowerstemborer) AS yellowerstemborer') 
            ,DB::raw('SUM(bhp) AS bhp') 
            ,DB::raw('SUM(paddybug) AS paddybug') 
            )->groupby('district','ascenter','ai','reccount')->get(),

            'alldatadis'=>DB::table('temp01')->select('district'
            ,DB::raw('SUM(tillers) AS tillers') 
            ,DB::raw('SUM(thrips) AS thrips') 
            ,DB::raw('SUM(gallmidge) AS gallmidge') 
            ,DB::raw('SUM(leaffolder) AS leaffolder') 
            ,DB::raw('SUM(yellowerstemborer) AS yellowerstemborer') 
            ,DB::raw('SUM(bhp) AS bhp') 
            ,DB::raw('SUM(paddybug) AS paddybug') 
            ,DB::raw('SUM(reccount) AS reccount') 
            )->groupby('district')->get(),

            'alldataasc'=>DB::table('temp01')->select('district','ascenter'
            ,DB::raw('SUM(tillers) AS tillers') 
            ,DB::raw('SUM(thrips) AS thrips') 
            ,DB::raw('SUM(gallmidge) AS gallmidge') 
            ,DB::raw('SUM(leaffolder) AS leaffolder') 
            ,DB::raw('SUM(yellowerstemborer) AS yellowerstemborer') 
            ,DB::raw('SUM(bhp) AS bhp') 
            ,DB::raw('SUM(paddybug) AS paddybug') 
            ,DB::raw('SUM(reccount) AS reccount') 
            )->groupby('district','ascenter')->get(),

            'selrange'=>$this->selectedrange,            

            
            ]

        );

    }



    public function test()
    {
    
        dd( $this->fromdate);     

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
