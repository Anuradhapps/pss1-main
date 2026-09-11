<?php

use App\Models\Collector;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\User;

beforeEach(function () {
    Role::query()->delete();
    User::query()->delete();
    Collector::query()->delete();
});

function attachRole(User $user, string $roleName): void
{
    $role = Role::firstOrCreate([
        'name' => $roleName,
        'label' => ucfirst($roleName),
    ]);

    RoleUser::firstOrCreate([
        'role_id' => $role->id,
        'user_id' => $user->id,
    ]);
}

test('admin can view another collector record', function () {
    $owner = User::factory()->create();
    $admin = User::factory()->create();
    attachRole($admin, 'admin');

    $collector = Collector::create([
        'user_id' => $owner->id,
        'rice_season_id' => 2025,
        'phone_no' => '0771234567',
        'region_id' => 1,
        'province' => 1,
        'district' => 1,
        'asc' => 1,
        'ai_range' => 1,
        'village' => 'Sample Village',
        'gps_lati' => '6.9',
        'gps_long' => '79.9',
        'rice_variety' => 'Bg 300',
        'date_establish' => '2025-01-01',
        'established_method' => 'Manual',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.collector.edit', ['collector' => $collector->id]))
        ->assertOk();
});

test('collector cannot view another collector record', function () {
    $owner = User::factory()->create();
    $collectorUser = User::factory()->create();
    attachRole($collectorUser, 'collector');

    $collector = Collector::create([
        'user_id' => $owner->id,
        'rice_season_id' => 2025,
        'phone_no' => '0771234567',
        'region_id' => 1,
        'province' => 1,
        'district' => 1,
        'asc' => 1,
        'ai_range' => 1,
        'village' => 'Sample Village',
        'gps_lati' => '6.9',
        'gps_long' => '79.9',
        'rice_variety' => 'Bg 300',
        'date_establish' => '2025-01-01',
        'established_method' => 'Manual',
    ]);

    $this->actingAs($collectorUser)
        ->get(route('collector.edit', ['id' => $collector->id]))
        ->assertForbidden();
});

test('collector cannot update another collector record', function () {
    $owner = User::factory()->create();
    $collectorUser = User::factory()->create();
    attachRole($collectorUser, 'collector');

    $collector = Collector::create([
        'user_id' => $owner->id,
        'rice_season_id' => 2025,
        'phone_no' => '0771234567',
        'region_id' => 1,
        'province' => 1,
        'district' => 1,
        'asc' => 1,
        'ai_range' => 1,
        'village' => 'Sample Village',
        'gps_lati' => '6.9',
        'gps_long' => '79.9',
        'rice_variety' => 'Bg 300',
        'date_establish' => '2025-01-01',
        'established_method' => 'Manual',
    ]);

    $this->actingAs($collectorUser)
        ->put(route('collector.update', ['id' => $collector->id]), [
            'phone_no' => '0770000000',
            'region' => 1,
            'province' => 1,
            'district' => 1,
            'as_center' => 1,
            'ai_range' => 1,
            'village' => 'Other Village',
            'rice_variety' => 'Bg 400',
            'date_establish' => '01-01-2025',
            'established_method' => 'Manual',
        ])
        ->assertForbidden();
});

test('admin can delete another collector record', function () {
    $owner = User::factory()->create();
    $admin = User::factory()->create();
    attachRole($admin, 'admin');

    $collector = Collector::create([
        'user_id' => $owner->id,
        'rice_season_id' => 2025,
        'phone_no' => '0771234567',
        'region_id' => 1,
        'province' => 1,
        'district' => 1,
        'asc' => 1,
        'ai_range' => 1,
        'village' => 'Sample Village',
        'gps_lati' => '6.9',
        'gps_long' => '79.9',
        'rice_variety' => 'Bg 300',
        'date_establish' => '2025-01-01',
        'established_method' => 'Manual',
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.collector.destroy', ['collector' => $collector->id]))
        ->assertRedirect();
});
