<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiRange extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function as_center()
    {
        return $this->belongsTo(As_center::class);
    }
}
