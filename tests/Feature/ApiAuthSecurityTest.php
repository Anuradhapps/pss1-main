<?php

use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    User::query()->delete();
});

test('invalid credentials return a safe generic response', function () {
    $user = User::factory()->create([
        'email' => 'alice@example.com',
        'password' => Hash::make('secret123'),
    ]);

    $this->postJson('/api/login', [
        'email' => 'alice@example.com',
        'password' => 'wrong-password',
    ])->assertStatus(401)
        ->assertJsonPath('message', 'Invalid credentials.');
});

test('validation errors return safe api responses', function () {
    $this->postJson('/api/login', [
        'email' => 'not-an-email',
        'password' => '',
    ])->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'email',
                'password',
            ],
        ]);
});

test('registered users receive a sanctum token with limited abilities', function () {
    $this->postJson('/api/register', [
        'name' => 'Alice Example',
        'email' => 'alice@example.com',
        'password' => 'SecretPass123',
    ])->assertStatus(201)
        ->assertJsonStructure(['status', 'message', 'token']);

    $user = User::where('email', 'alice@example.com')->firstOrFail();
    $this->assertNotNull($user->tokens()->first());
    $this->assertTrue($user->tokens()->first()->can('user:read'));
});

test('token access is denied without an authorized token', function () {
    $response = $this->getJson('/api/user');

    $response->assertStatus(401);
});

test('api registration is rate limited after repeated retries', function () {
    for ($i = 0; $i < 3; $i++) {
        $this->postJson('/api/register', [
            'name' => 'X',
            'email' => "user{$i}@example.com",
            'password' => 'SecretPass123',
        ]);
    }

    $this->postJson('/api/register', [
        'name' => 'Y',
        'email' => 'slow@example.com',
        'password' => 'SecretPass123',
    ])->assertStatus(429);
});
