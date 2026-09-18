<?php

use App\Models\User;

use function Pest\Faker\faker;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('can see register page', function () {
    get('register')->assertOk();
});

test('users cannot register with invalid password', function () {

    post('register', [
        'name'     => faker()->name(),
        'email'    => faker()->email(),
        'password' => '',
    ]);

    $this->assertGuest();
});

test('users cannot register with existing email', function () {
    $user = User::factory()->create();
    $password = 'ght73A3!$^DS';

    post('register', [
        'name'     => faker()->name(),
        'email'    => $user->email,
        'password' => $password,
        'confirmPassword' => $password,
    ])->assertInvalid();

    $this->assertGuest();
});

test('users cannot register without matching password', function () {
    $user = User::factory()->create();
    $password = 'ght73A3!$^DS';

    post('register', [
        'name'     => faker()->name(),
        'email'    => $user->email,
        'password' => $password,
        'confirmPassword' => 'other',
    ])->assertInvalid();

    $this->assertGuest();
});

test('users can register', function () {
    config()->set('services.recaptcha.site_key', null);
    config()->set('services.recaptcha.secret_key', null);

    $password = 'ght73A3!$^DS';

    post('register', [
        'name'     => faker()->name(),
        'email'    => faker()->email,
        'password' => $password,
        'confirmPassword' => $password,
    ])->assertRedirect('/dashboard');
});

test('registration does not fail when reCAPTCHA is not configured', function () {
    config()->set('services.recaptcha.site_key', null);
    config()->set('services.recaptcha.secret_key', null);

    $email = 'jane@example.com';
    $password = 'ght73A3!$^DS';

    post('register', [
        'name'     => 'Jane Doe',
        'email'    => $email,
        'password' => $password,
        'confirmPassword' => $password,
    ])->assertRedirect('/dashboard');

    $this->assertDatabaseHas('users', ['email' => $email]);
});
