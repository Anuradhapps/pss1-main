<?php


declare(strict_types=1);

namespace App\Http\Livewire\Admin\Users\Edit;

use App\Http\Livewire\Base;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Base
{
    public User $user;
    public string $newPassword = '';
    public string $confirmPassword = '';
    public string $message = '';

    public function render(): View
    {
        return view('livewire.admin.users.edit.change-password');
    }

    protected function rules(): array
    {
        return [
            'newPassword' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers(),
            ],
            'confirmPassword' => 'required|same:newPassword',
        ];
    }

    protected array $messages = [
        'newPassword.required'     => 'New password is required',
        'confirmPassword.required' => 'Confirm password is required',
        'confirmPassword.same'     => 'Passwords do not match',
    ];

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    public function update(): void
    {
        $this->validate();

        $this->user->password = Hash::make($this->newPassword);
        $this->user->save();

        add_user_log([
            'title'        => "Updated {$this->user->name}'s password",
            'reference_id' => $this->user->id,
            'link'         => route('admin.users.edit', ['user' => $this->user->id]),
            'section'      => 'Users',
            'type'         => 'Update',
        ]);
        $this->reset(['newPassword', 'confirmPassword']);

        $this->message = "Password updated successfully.";
    }
}
