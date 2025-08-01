<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Prime;
use App\Models\User;

class PrimePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Prime');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Prime $prime): bool
    {
        return $user->checkPermissionTo('view Prime');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Prime');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Prime $prime): bool
    {
        return $user->checkPermissionTo('update Prime');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Prime $prime): bool
    {
        return $user->checkPermissionTo('delete Prime');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Prime $prime): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Prime $prime): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
