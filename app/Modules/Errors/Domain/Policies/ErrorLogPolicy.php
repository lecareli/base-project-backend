<?php

namespace App\Modules\Errors\Domain\Policies;

use App\Modules\Users\Domain\Models\User;

class ErrorLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && $user->role === 'OWNER';
    }

    public function view(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function resolve(User $user): bool
    {
        return $this->viewAny($user);
    }
}
