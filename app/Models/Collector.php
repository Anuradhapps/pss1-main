<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function district(){
        return $this->belongsTo(District::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

public function asCenter()
{
    return $this->belongsTo(As_center::class, 'asc');
}


public function aiRange()
{
    return $this->belongsTo(AiRange::class);
}
}
