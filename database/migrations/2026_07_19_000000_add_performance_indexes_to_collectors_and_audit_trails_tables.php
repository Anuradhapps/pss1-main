<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collectors', function (Blueprint $table) {
            $table->index('district', 'collectors_district_index');
            $table->index('rice_season_id', 'collectors_rice_season_id_index');
            $table->index('region_id', 'collectors_region_id_index');
            $table->index('user_id', 'collectors_user_id_index');
            $table->index('created_at', 'collectors_created_at_index');
        });

        Schema::table('audit_trails', function (Blueprint $table) {
            $table->index('user_id', 'audit_trails_user_id_index');
        });

        Schema::table('common_data_collects', function (Blueprint $table) {
            $table->index('collector_id', 'common_data_collects_collector_id_index');
            $table->index('user_id', 'common_data_collects_user_id_index');
            $table->index('c_date', 'common_data_collects_c_date_index');
        });

        Schema::table('pest_data_collects', function (Blueprint $table) {
            $table->index('common_data_collectors_id', 'pest_data_collects_common_data_collectors_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('pest_data_collects', function (Blueprint $table) {
            $table->dropIndex('pest_data_collects_common_data_collectors_id_index');
        });

        Schema::table('common_data_collects', function (Blueprint $table) {
            $table->dropIndex('common_data_collects_c_date_index');
            $table->dropIndex('common_data_collects_user_id_index');
            $table->dropIndex('common_data_collects_collector_id_index');
        });

        Schema::table('audit_trails', function (Blueprint $table) {
            $table->dropIndex('audit_trails_user_id_index');
        });

        Schema::table('collectors', function (Blueprint $table) {
            $table->dropIndex('collectors_created_at_index');
            $table->dropIndex('collectors_user_id_index');
            $table->dropIndex('collectors_region_id_index');
            $table->dropIndex('collectors_rice_season_id_index');
            $table->dropIndex('collectors_district_index');
        });
    }
};