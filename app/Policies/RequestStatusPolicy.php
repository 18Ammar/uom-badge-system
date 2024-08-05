<?php

namespace App\Policies;

use App\Models\User;
use App\Models\requestStatus;
use Illuminate\Auth\Access\Response;

class RequestStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, requestStatus $requestStatus)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, requestStatus $requestStatus)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, requestStatus $requestStatus)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, requestStatus $requestStatus)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, requestStatus $requestStatus)
    {
        //
    }
}
