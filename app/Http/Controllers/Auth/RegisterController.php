<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    protected function recaptchaIsEnabled(): bool
    {
        return filled(config('services.recaptcha.site_key')) && filled(config('services.recaptcha.secret_key'));
    }

    public function index(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // ---------------------------------------------------------
        // 1. Validate registration data
        // ---------------------------------------------------------
        $rules = [
            'name'            => 'required',
            'email'           => 'required|email|unique:users,email',
            'password'        => [
                'required',
                Password::min(5),
            ],
            'confirmPassword' => 'required|same:password',
        ];

        $messages = [
            'password.required'        => 'Password is required',
            'confirmPassword.required' => 'Confirm password is required',
            'confirmPassword.same'     => 'Confirm password and new password must match',
        ];

        if ($this->recaptchaIsEnabled()) {
            $rules['recaptcha_token'] = 'required|string';
            $messages['recaptcha_token.required'] = 'Security verification failed. Please try again.';
        }

        $request->validate($rules, $messages);

        // ---------------------------------------------------------
        // 2. Verify Google reCAPTCHA v3
        // ---------------------------------------------------------
        if ($this->recaptchaIsEnabled()) {
            $captchaResponse = Http::asForm()->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'secret'   => config('services.recaptcha.secret_key'),
                    'response' => $request->input('recaptcha_token'),
                    'remoteip' => $request->ip(),
                ]
            );

            $captcha = $captchaResponse->json();

            // Check:
            // - Google request was successful
            // - CAPTCHA verification succeeded
            // - Action is "register"
            // - Score is above configured minimum
            if (
                !$captchaResponse->successful() ||
                !($captcha['success'] ?? false) ||
                ($captcha['action'] ?? '') !== 'register' ||
                ($captcha['score'] ?? 0) < config('services.recaptcha.min_score', 0.5)
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'recaptcha' => 'Security verification failed. Please try again.',
                    ]);
            }
        }

        // ---------------------------------------------------------
        // 3. Create user
        // ---------------------------------------------------------
        $user = User::create([
            'name'                 => $request->input('name'),
            'slug'                 => Str::slug($request->input('name')),
            'email'                => $request->input('email'),
            'password'             => bcrypt($request->input('password')),
            'is_active'            => 1,
            'is_office_login_only' => 0,
        ]);

        // ---------------------------------------------------------
        // 4. Generate user image
        // ---------------------------------------------------------
        $name      = get_initials($user->name);
        $id        = $user->id . '.png';
        $path      = 'users/';
        $imagePath = create_avatar($name, $id, $path);

        // ---------------------------------------------------------
        // 5. Save user image
        // ---------------------------------------------------------
        $user->image = $imagePath;
        $user->save();

        // ---------------------------------------------------------
        // 6. Assign collector role
        // ---------------------------------------------------------
        $role = Role::where('label', 'collector')->first();

        if ($role) {
            RoleUser::create([
                'role_id' => $role->id,
                'user_id' => $user->id,
            ]);
        }

        // ---------------------------------------------------------
        // 7. Add registration log
        // ---------------------------------------------------------
        add_user_log([
            'title'        => 'registered ' . $user->name,
            'reference_id' => $user->id,
            'section'      => 'Auth',
            'type'         => 'Register',
        ]);

        // ---------------------------------------------------------
        // 8. Login newly registered user
        // ---------------------------------------------------------
        Auth::loginUsingId($user->id);

        return redirect('dashboard');
    }
}
