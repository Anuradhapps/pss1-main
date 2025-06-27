<?php

declare(strict_types=1);

use App\Models\RiceSeason;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('collectors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RiceSeason::class)->constrained('rice_seasons')->onDelete('cascade')->onUpdate('cascade');
            $table->string('phone_no');
            $table->uuid('user_id'); // Change to UUID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('region_id')->references('id')->on('regions')->onDelete('cascade')->onUpdate('cascade')->default(1);
            $table->foreignId('province')->constrained('provinces')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('district')->constrained('districts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('asc')->constrained('as_centers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('ai_range')->constrained('ai_ranges')->onDelete('cascade')->onUpdate('cascade');
            $table->string('village')->nullable(true);
            $table->string('gps_lati')->nullable(true);
            $table->string('gps_long')->nullable(true);
            $table->string('rice_variety')->nullable(true);
            $table->date('date_establish')->nullable(true);
            $table->string('established_method')->nullable(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collectors');
    }
};
