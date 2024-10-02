<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PestDataCollect extends Model
{
    use HasFactory;

    protected $fillable = [

        'common_data_collectors_id', 'pest_name', 'location_one', 'location_two', 'location_three', 'location_four', 'location_five', 'location_six', 'location_seven', 'location_eight', 'location_nine', 'location_ten','total','mean','code',
    ];
    public function commonDataCollect()
    {
        return $this->belongsTo(CommonDataCollect::class, 'common_data_collectors_id');
    }
}
