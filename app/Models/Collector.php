<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDistrict()
    {
        return $this->belongsTo(district::class, 'district');
    }
    public function getProvince()
    {
        return $this->belongsTo(Province::class, 'province');
    }

    public function getAsCenter()
    {
        return $this->belongsTo(As_center::class, 'asc');
    }
    public function getAiRange()
    {
        return $this->belongsTo(AiRange::class, 'ai_range');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function riceSeason(){
        return $this->belongsTo(RiceSeason::class);
    }
    public function commonDataCollect()
    {
        return $this->hasMany(CommonDataCollect::class);
    }
}
