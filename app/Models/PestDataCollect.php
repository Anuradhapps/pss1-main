<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PestDataCollect extends Model
{
    use HasFactory;

    protected $fillable = [

        'common_data_collectors_id', 'pest_name', 'location_1', 'location_2', 'location_3', 'location_4', 'location_5', 'location_6', 'location_7', 'location_8', 'location_9', 'location_10','total','mean','code',
    ];
    public function commonDataCollect()
    {
        return $this->belongsTo(CommonDataCollect::class, 'common_data_collectors_id');
    }

    public function pest(){
        return $this->belongsTo(Pest::class);
    }
}
