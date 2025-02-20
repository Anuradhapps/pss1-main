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
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->integer('code')->nullable();
            $table->string('name');
            $table->foreignId('province_id')->constrained('provinces')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
        DB::statement("
INSERT INTO `districts` (`id`, `code`, `name`, `province_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Batticaloa', 1, '2024-10-10 05:38:57', '2024-10-10 05:38:57'),
(2, NULL, 'Ampara', 1, '2024-10-10 05:39:02', '2024-10-10 05:39:02'),
(3, NULL, 'Trincomalee', 1, '2024-10-10 05:39:06', '2024-10-10 05:39:06'),
(4, NULL, 'Anuradhapura', 2, '2024-10-10 05:39:19', '2024-10-10 05:39:19'),
(5, NULL, 'Polonnaruwa', 2, '2024-10-10 05:39:27', '2024-10-10 05:39:27'),
(6, NULL, 'Badulla', 3, '2024-10-10 05:39:30', '2024-10-10 05:39:30'),
(7, NULL, 'Monaragala', 3, '2024-10-10 05:39:34', '2024-10-10 05:39:34'),
(8, NULL, 'Kurunegala', 4, '2024-10-10 05:39:38', '2024-10-10 05:39:38'),
(9, NULL, 'Puttalam', 4, '2024-10-10 05:39:51', '2024-10-10 05:39:51'),
(10, NULL, 'Kegalle', 5, '2024-10-10 05:39:54', '2024-10-10 05:39:54'),
(11, NULL, 'Rathnapura', 5, '2024-10-10 05:40:00', '2024-10-10 05:40:00'),
(12, NULL, 'Mathale', 6, '2024-10-10 05:40:14', '2024-10-10 05:40:14'),
(13, NULL, 'Kandy', 6, '2024-10-10 05:40:18', '2024-10-10 05:40:18'),
(14, NULL, 'NuwaraEliya', 6, '2024-10-10 05:40:31', '2024-10-10 05:40:31'),
(15, NULL, 'Jaffna', 7, '2024-10-10 05:40:38', '2024-10-10 05:40:38'),
(16, NULL, 'Kilinochchi', 7, '2024-10-10 05:40:43', '2024-10-10 05:40:43'),
(17, NULL, 'Vavuniya', 7, '2024-10-10 05:40:48', '2024-10-10 05:40:48'),
(18, NULL, 'Mullaitivu', 7, '2024-10-10 05:40:52', '2024-10-10 05:40:52'),
(19, NULL, 'Mannar', 7, '2024-10-10 05:40:58', '2024-10-10 05:40:58'),
(20, NULL, 'Colombo', 8, '2024-10-10 05:41:05', '2024-10-10 05:41:05'),
(21, NULL, 'Gampaha', 8, '2024-10-10 05:41:06', '2024-10-10 05:41:06'),
(22, NULL, 'Kaluthara', 8, '2024-10-10 05:41:10', '2024-10-10 05:41:10'),
(23, NULL, 'Galle', 9, '2024-10-10 05:41:17', '2024-10-10 05:41:17'),
(24, NULL, 'Matara', 9, '2024-10-10 05:41:26', '2024-10-10 05:41:26'),
(25, NULL, 'Hambantota', 9, '2024-10-10 05:41:31', '2024-10-10 05:41:31');
        ");
    }

    public function down()
    {
        Schema::dropIfExists('districts');
    }
};
