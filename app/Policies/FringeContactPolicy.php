<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\FringeContact;
use App\Models\User;

class FringeContactPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any FringeContact');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FringeContact $fringecontact): bool
    {
        return $user->checkPermissionTo('view FringeContact');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create FringeContact');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FringeContact $fringecontact): bool
    {
        return $user->checkPermissionTo('update FringeContact');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FringeContact $fringecontact): bool
    {
        return $user->checkPermissionTo('delete FringeContact');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FringeContact $fringecontact): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FringeContact $fringecontact): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
