<?php

declare(strict_types=1);

use App\Models\As_center;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ai_ranges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('as_center_id')->constrained()->onDelete('cascade'); // Foreign key to as_centers table
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_ranges');
    }
};
