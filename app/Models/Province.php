<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function district() {
        return $this->hasMany(District::class);
    }

    public function collector(){
        return $this->hasMany(Collector::class);
    }
    
}
