<?php

namespace App\Policies;

use App\Models\User;
use App\Models\promoteAdmin;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromoteAdminPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, promoteAdmin $promoteAdmin): bool
    {
        return $user->hasRole('super admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, promoteAdmin $promoteAdmin): bool
    {
        return $user->hasRole('super admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, promoteAdmin $promoteAdmin): bool
    {
        return $user->hasRole('super admin');
    }

}
