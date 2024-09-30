<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temp1 extends Model
{
    use HasFactory;
    protected$table='temp01';
    protected $fillable=[
        'id','district','ascenter','ai','tillers','thrips','gallmidge','leaffolder',
        'yellowerstemborer','bhp','paddybug','reccount'
    ];
}
