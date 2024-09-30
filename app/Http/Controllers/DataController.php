<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommonDataCollect;
use App\Models\PestDataCollect;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $common_id=0;
    try {   
        $common=CommonDataCollect::Create([
            'user_id' =>$request->u_name,
            'c_date'=>$request->c_date ,
            'temperature' =>$request->temperature,
            'numbrer_r_day'=>$request->numbrer_r_day ,
             'growth_s_c'=>$request->growth_s_c,
             'otherdet'=>$request->loc_10_any_bug
         ]);
         
         $common_id=$common->id;
     
        
         $common_id=$common->id;
         $pest_1=PestDataCollect::Create([
            'common_data_collectors_id' =>$common_id,
            'pest_name' =>"Tillers",
            'location_one' =>$request->loc_1_tillers,
            'location_two'=>$request-> loc_2_tillers, 
            'location_three'=>$request->loc_3_tillers,
            'location_four' =>$request->loc_4_tillers, 
            'location_five'=>$request->loc_5_tillers, 
            'location_six'=>$request->loc_6_tillers,
            'location_seven' =>$request->loc_7_tillers,
            'location_eight' =>$request->loc_8_tillers,
            'location_nine'=>$request-> loc_9_tillers,
            'location_ten'=>$request->loc_10_tillers

         ]);
         $pest_2=PestDataCollect::Create([
            'common_data_collectors_id' =>$common_id,
            'pest_name' =>'Thrips',
            'location_one' =>$request->loc_1_thrips,
            'location_two'=>$request-> loc_2_thrips, 
            'location_three'=>$request->loc_3_thrips,
            'location_four' =>$request->loc_4_thrips, 
            'location_five'=>$request->loc_5_thrips, 
            'location_six'=>$request->loc_6_thrips,
            'location_seven' =>$request->loc_7_thrips,
            'location_eight' =>$request->loc_8_thrips,
            'location_nine'=>$request-> loc_9_thrips,
            'location_ten'=>$request->loc_10_thrips

         ]);
         $pest_3=PestDataCollect::Create([
            'common_data_collectors_id' =>$common_id,
            'pest_name' =>'Gall Midge',
            'location_one' =>$request->loc_1_gall_midge,
            'location_two'=>$request-> loc_2_gall_midge, 
            'location_three'=>$request->loc_3_gall_midge,
            'location_four' =>$request->loc_4_gall_midge, 
            'location_five'=>$request->loc_5_gall_midge, 
            'location_six'=>$request->loc_6_gall_midge,
            'location_seven' =>$request->loc_7_gall_midge,
            'location_eight' =>$request->loc_8_gall_midge,
            'location_nine'=>$request-> loc_9_gall_midge,
            'location_ten'=>$request->loc_10_gall_midge

         ]);
         $pest_4=PestDataCollect::Create([
            'common_data_collectors_id' =>$common_id,
            'pest_name' =>'Leaf Folder',
            'location_one' =>$request->loc_1_leaffolder,
            'location_two'=>$request-> loc_2_leaffolder, 
            'location_three'=>$request->loc_3_leaffolder,
            'location_four' =>$request->loc_4_leaffolder, 
            'location_five'=>$request->loc_5_leaffolder, 
            'location_six'=>$request->loc_6_leaffolder,
            'location_seven' =>$request->loc_7_leaffolder,
            'location_eight' =>$request->loc_8_leaffolder,
            'location_nine'=>$request-> loc_9_leaffolder,
            'location_ten'=>$request->loc_10_leaffolder

         ]);
          $pest_5=PestDataCollect::Create([
            'common_data_collectors_id' =>$common_id,
            'pest_name' =>'Yellower Stem Borer',
            'location_one' =>$request->loc_1_yellower_stem_borer,
            'location_two'=>$request-> loc_2_yellower_stem_borer, 
            'location_three'=>$request->loc_3_yellower_stem_borer,
            'location_four' =>$request->loc_4_yellower_stem_borer, 
            'location_five'=>$request->loc_5_yellower_stem_borer, 
            'location_six'=>$request->loc_6_yellower_stem_borer,
            'location_seven' =>$request->loc_7_yellower_stem_borer,
            'location_eight' =>$request->loc_8_yellower_stem_borer,
            'location_nine'=>$request-> loc_9_yellower_stem_borer,
            'location_ten'=>$request->loc_10_yellower_stem_borer

         ]); 
         $pest_6=PestDataCollect::Create([
            'common_data_collectors_id' =>$common_id,
            'pest_name' =>'BHP+WBHP',
            'location_one' =>$request->loc_1_bhp_wbph,
            'location_two'=>$request-> loc_2_bhp_wbph, 
            'location_three'=>$request->loc_3_bhp_wbph,
            'location_four' =>$request->loc_4_bhp_wbph, 
            'location_five'=>$request->loc_5_bhp_wbph, 
            'location_six'=>$request->loc_6_bhp_wbph,
            'location_seven' =>$request->loc_7_bhp_wbph,
            'location_eight' =>$request->loc_8_bhp_wbph,
            'location_nine'=>$request-> loc_9_bhp_wbph,
            'location_ten'=>$request->loc_10_bhp_wbph

         ]);
         $pest_7=PestDataCollect::Create([
            'common_data_collectors_id' =>$common_id,
            'pest_name' =>'Paddy Bug',
            'location_one' =>$request->loc_1_paddy_bug,
            'location_two'=>$request-> loc_2_paddy_bug, 
            'location_three'=>$request->loc_3_paddy_bug,
            'location_four' =>$request->loc_4_paddy_bug, 
            'location_five'=>$request->loc_5_paddy_bug, 
            'location_six'=>$request->loc_6_paddy_bug,
            'location_seven' =>$request->loc_7_paddy_bug,
            'location_eight' =>$request->loc_8_paddy_bug,
            'location_nine'=>$request-> loc_9_paddy_bug,
            'location_ten'=>$request->loc_10_paddy_bug

         ]);
         return response()->json([
            'status'=>true,
            'message'=>'Send data Successfully',
           
         ],200 );

      } catch (\Throwable $th) {
         return response()->json([
            'status'=>false,
            'message'=>$th->getMessage()
           
         ],500 );
      }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
