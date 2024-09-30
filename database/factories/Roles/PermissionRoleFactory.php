<?php

declare(strict_types=1);

namespace Database\Factories\Roles;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Roles\PermissionRole;

class PermissionRoleFactory extends Factory
{
    protected $model = PermissionRole::class;

    public function definition(): array
    {
        return [
            'permission_id' => $this->faker->uuid(),
            'role_id'       => $this->faker->uuid(),
        ];
    }
}
