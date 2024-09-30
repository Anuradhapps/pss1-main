<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonDataCollect extends Model
{
    use HasFactory;
    protected $fillable = [

        'user_id', 'c_date', 'temperature', 'numbrer_r_day', 'growth_s_c','otherdet','otherinfo'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pestDataCollect()
    {
        return $this->hasMany(PestDataCollect::class, 'common_data_collectors_id');
    }
}
