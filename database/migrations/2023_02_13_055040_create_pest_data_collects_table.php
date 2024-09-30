<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pest_data_collects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('common_data_collectors_id');
            $table->string('pest_name');    
            $table->integer('location_one');
            $table->integer('location_two');
            $table->integer('location_three');
            $table->integer('location_four');
            $table->integer('location_five');
            $table->integer('location_six');
            $table->integer('location_seven');
            $table->integer('location_eight');
            $table->integer('location_nine');
            $table->integer('location_ten');
            $table->integer('total')->nullable();
            $table->foreign('common_data_collectors_id')->references('id')->on('common_data_collects')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pest_data_collects');
    }
};
