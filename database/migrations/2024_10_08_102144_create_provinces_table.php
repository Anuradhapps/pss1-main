<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::statement("
        INSERT INTO `provinces` (`id`, `name`, `created_at`, `updated_at`) VALUES
        (1, 'EASTERN', '2024-10-10 05:38:57', '2024-10-10 05:38:57'),
        (2, 'NORTH CENTRAL', '2024-10-10 05:39:18', '2024-10-10 05:39:18'),
        (3, 'UVA PROVINCE', '2024-10-10 05:39:30', '2024-10-10 05:39:30'),
        (4, 'NORTH WESTERN', '2024-10-10 05:39:38', '2024-10-10 05:39:38'),
        (5, 'SABARAGAMUWA', '2024-10-10 05:39:54', '2024-10-10 05:39:54'),
        (6, 'CENTRAL', '2024-10-10 05:40:14', '2024-10-10 05:40:14'),
        (7, 'NORTHERN', '2024-10-10 05:40:37', '2024-10-10 05:40:37'),
        (8, 'WESTERN', '2024-10-10 05:41:05', '2024-10-10 05:41:05'),
        (9, 'SOUTHERN', '2024-10-10 05:41:17', '2024-10-10 05:41:17');

        ");
    }

    public function down()
    {
        Schema::dropIfExists('provinces');
    }
};
