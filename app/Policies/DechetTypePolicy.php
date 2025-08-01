<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\DechetType;
use App\Models\User;

class DechetTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any DechetType');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DechetType $dechettype): bool
    {
        return $user->checkPermissionTo('view DechetType');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create DechetType');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DechetType $dechettype): bool
    {
        return $user->checkPermissionTo('update DechetType');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DechetType $dechettype): bool
    {
        return $user->checkPermissionTo('delete DechetType');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DechetType $dechettype): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DechetType $dechettype): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
