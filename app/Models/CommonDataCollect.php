<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonDataCollect extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pestDataCollect()
    {
        return $this->hasMany(PestDataCollect::class, 'common_data_collectors_id');
    }
    public function collector(){
        return $this->belongsTo(Collector::class);
    }
}
