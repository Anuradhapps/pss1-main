<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('collectors', function (Blueprint $table) {
            $table->id();
            $table->char('user_id');
            $table->string('phone_no')->unique();
            $table->unsignedBigInteger('district')->nullable(true);
            $table->unsignedBigInteger('asc')->nullable(true);
            $table->string('ai_range')->nullable(true);
            $table->string('village')->nullable(true);
            $table->string('gps_lati')->nullable(true);
            $table->string('gps_long')->nullable(true);
            $table->string('rice_variety')->nullable(true);
            $table->date('date_establish')->nullable(true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('district')->references('id')->on('districts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('asc')->references('id')->on('as_centers')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collectors');
    }
};
