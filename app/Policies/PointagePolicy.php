<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Pointage;
use App\Models\User;

class PointagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Pointage');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pointage $pointage): bool
    {
        return $user->checkPermissionTo('view Pointage');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Pointage');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pointage $pointage): bool
    {
        return $user->checkPermissionTo('update Pointage');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pointage $pointage): bool
    {
        return $user->checkPermissionTo('delete Pointage');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pointage $pointage): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pointage $pointage): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
