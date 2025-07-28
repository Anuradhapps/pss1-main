<?php

declare(strict_types=1);

namespace App\Http\Livewire\Admin\Users;

use App\Http\Livewire\Base;
use App\Mail\Users\SendInviteMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;

use function abort_if_cannot;
use function now;
use function view;

class Users extends Base
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    public $paginate;
    public $checked = [];
    public $name = '';
    public $email = '';
    public $joined = '';
    public $sortField = 'name';
    public $sortAsc = true;
    public $openFilter = false;
    public $sentEmail = false;

    protected $listeners = ['refreshUsers' => '$refresh'];

    public function mount(): void
    {
        $this->paginate = 12;
    }

    public function render(): View
    {
        abort_if_cannot('view_users');

        $users = User::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        if ($this->name) {
            $users->where('name', 'like', '%' . $this->name . '%');
        }

        if ($this->email) {
            $this->openFilter = true;
            $users->where('email', 'like', '%' . $this->email . '%');
        }

        if ($this->joined) {
            $this->openFilter = true;
            $parts = explode(' to ', $this->joined);
            if (count($parts) === 2) {
                try {
                    $from = Carbon::parse($parts[0])->startOfDay();
                    $to   = Carbon::parse($parts[1])->endOfDay();
                    $users->whereBetween('created_at', [$from, $to]);
                } catch (\Exception $e) {
                    // invalid date range
                }
            }
        }

        return view('livewire.admin.users.index', [
            'users' => $users->paginate($this->paginate),
        ]);
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function resetFilters(): void
    {
        $this->reset();
        $this->paginate = 10; // Restore default
    }

    public function deleteUser($id): void
    {
        $user = User::findOrFail($id);

        if ($user->forceDelete()) {
            $this->dispatchBrowserEvent('close-modal');
        } else {
            dd('Delete operation failed');
        }
    }

    public function resendInvite($id): void
    {
        $user = User::findOrFail($id);
        Mail::send(new SendInviteMail($user));

        $user->invited_at = now();
        $user->save();

        $this->sentEmail = true;
    }
}
