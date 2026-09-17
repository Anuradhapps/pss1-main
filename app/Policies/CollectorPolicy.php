<?php

namespace App\Policies;

use App\Models\Collector;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollectorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Collector $collector): bool
    {
        return $user->hasRole('admin') || $collector->user_id === $user->id;
    }

    public function update(User $user, Collector $collector): bool
    {
        return $this->view($user, $collector);
    }

    public function delete(User $user, Collector $collector): bool
    {
        return $this->view($user, $collector);
    }

    public function viewUserCollectors(User $user, User $targetUser): bool
    {
        return $user->hasRole('admin') || $user->id === $targetUser->id;
    }
}
