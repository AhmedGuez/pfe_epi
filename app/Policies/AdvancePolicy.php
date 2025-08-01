<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Advance;
use App\Models\User;

class AdvancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Advance');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Advance $advance): bool
    {
        return $user->checkPermissionTo('view Advance');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Advance');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Advance $advance): bool
    {
        return $user->checkPermissionTo('update Advance');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Advance $advance): bool
    {
        return $user->checkPermissionTo('delete Advance');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Advance $advance): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Advance $advance): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
