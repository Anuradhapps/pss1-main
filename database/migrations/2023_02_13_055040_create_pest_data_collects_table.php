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
            $table->integer('location_1');
            $table->integer('location_2');
            $table->integer('location_3');
            $table->integer('location_4');
            $table->integer('location_5');
            $table->integer('location_6');
            $table->integer('location_7');
            $table->integer('location_8');
            $table->integer('location_9');
            $table->integer('location_10');
            $table->integer('total')->nullable();
            $table->integer('mean');
            $table->integer('code');
            $table->foreign('common_data_collectors_id')->references('id')->on('common_data_collects')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pest_data_collects');
    }
};
