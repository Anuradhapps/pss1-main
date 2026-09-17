<?php

use App\Models\Notification;
use App\Models\Roles\Role;
use App\Models\User;
use App\Services\PestAlertNotificationService;

test('a notification belongs to a user with assigned to', function () {

    $user = User::factory()->create();
    $notification = Notification::factory()->create([
        'assigned_from_user_id' => $user->id,
        'assigned_to_user_id' => $user->id
    ]);

    expect($notification->assigned_to_user_id)->toEqual($user->id);
    $this->assertInstanceOf(User::class, $notification->assignedTo);
});

test('a notification belongs to a user with assigned from', function () {
    $user = User::factory()->create();
    $notification = Notification::factory()->create([
        'assigned_from_user_id' => $user->id,
        'assigned_to_user_id' => $user->id
    ]);

    expect($notification->assigned_from_user_id)->toEqual($user->id);
    $this->assertInstanceOf(User::class, $notification->assignedFrom);
});

test('it creates a notification when a pest code reaches 7 or 9', function () {
    $collector = User::factory()->create(['name' => 'Collector A']);
    $adminUser = User::factory()->create(['name' => 'Admin User']);
    $adminRole = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Admin']);
    $adminUser->roles()->attach($adminRole->id);

    $service = new PestAlertNotificationService();

    $service->notifyIfHighRisk('Gall Midge', 7, $collector->id, 'Collector A', '0771234567', 'Matara');
    $service->notifyIfHighRisk('Gall Midge', 9, $collector->id, 'Collector A', '0771234567', 'Matara');

    expect(Notification::where('assigned_to_user_id', $adminUser->id)->count())->toBe(2)
        ->and(Notification::where('assigned_to_user_id', $adminUser->id)->where('title', 'LIKE', '%code 7%')->count())->toBe(1)
        ->and(Notification::where('assigned_to_user_id', $adminUser->id)->where('title', 'LIKE', '%code 9%')->count())->toBe(1)
        ->and(Notification::where('assigned_to_user_id', $adminUser->id)->first()->title)->toContain('Collector A')
        ->toContain('0771234567')
        ->toContain('Matara');
});

test('it sends critical alerts only to deputy director, pda, etd, and admin roles', function () {
    $collector = User::factory()->create(['name' => 'Collector A']);
    $admin = User::factory()->create(['name' => 'Admin User']);
    $deputy = User::factory()->create(['name' => 'Deputy Director']);
    $pda = User::factory()->create(['name' => 'PDA User']);
    $etd = User::factory()->create(['name' => 'ETD User']);
    $random = User::factory()->create(['name' => 'Other User']);

    $adminRole = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Admin']);
    $deputyRole = Role::firstOrCreate(['name' => 'deputyDirector'], ['label' => 'Deputy Director']);
    $pdaRole = Role::firstOrCreate(['name' => 'pda'], ['label' => 'PDA']);
    $etdRole = Role::firstOrCreate(['name' => 'extensionAndTrainingDirector'], ['label' => 'ETD']);

    $admin->roles()->attach($adminRole->id);
    $deputy->roles()->attach($deputyRole->id);
    $pda->roles()->attach($pdaRole->id);
    $etd->roles()->attach($etdRole->id);
    $service = new PestAlertNotificationService();

    $service->notifyIfHighRisk('Gall Midge', 9, $collector->id, 'Collector A', '0771234567', 'Matara');

    expect(Notification::count())->toBe(4)
        ->and(Notification::where('assigned_to_user_id', $admin->id)->count())->toBe(1)
        ->and(Notification::where('assigned_to_user_id', $deputy->id)->count())->toBe(1)
        ->and(Notification::where('assigned_to_user_id', $pda->id)->count())->toBe(1)
        ->and(Notification::where('assigned_to_user_id', $etd->id)->count())->toBe(1)
        ->and(Notification::where('assigned_to_user_id', $random->id)->count())->toBe(0);
});
