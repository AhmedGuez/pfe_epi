<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\DechetContact;
use App\Models\User;

class DechetContactPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any DechetContact');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DechetContact $dechetcontact): bool
    {
        return $user->checkPermissionTo('view DechetContact');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create DechetContact');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DechetContact $dechetcontact): bool
    {
        return $user->checkPermissionTo('update DechetContact');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DechetContact $dechetcontact): bool
    {
        return $user->checkPermissionTo('delete DechetContact');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DechetContact $dechetcontact): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DechetContact $dechetcontact): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
