<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('collectors', function (Blueprint $table) {
            $table->string('established_method')->nullable()->after('date_establish');
        });
    }

    public function down()
    {
        Schema::table('collectors', function (Blueprint $table) {
            $table->dropColumn('established_method');
        });
    }
};
