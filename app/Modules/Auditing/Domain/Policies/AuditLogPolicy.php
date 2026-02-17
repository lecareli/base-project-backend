<?php

namespace App\Modules\Auditing\Domain\Policies;

use App\Modules\Users\Domain\Models\User;

class AuditLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && $user->role === 'OWNER';
    }

    public function view(User $user): bool
    {
        return $this->viewAny($user);
    }
}
