<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('common_data_collects', function (Blueprint $table) {
            $table->id();
            $table->char('user_id')->nullable(false);
            $table->date('c_date')->nullable(false);
            $table->string('temperature')->nullable(false);
            $table->string('numbrer_r_day')->nullable(false);
            $table->string('growth_s_c')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('otherinfo')->nullable()->default('No Other Info');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('common_data_collects');
    }
};
