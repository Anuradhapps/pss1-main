<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conducted_programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->string('district');
            $table->date('conducted_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('participants_count');
            $table->string('other_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conducted_programs');
    }
};
