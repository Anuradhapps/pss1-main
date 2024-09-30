<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class district extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $fillable = [
        'id',
        'code',
        'name',
        'p_id'
    ];
    public function As_center()
    {
        return $this->hasMany(As_center::class);
    }
}
