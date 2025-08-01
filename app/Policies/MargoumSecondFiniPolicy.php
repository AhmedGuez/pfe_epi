<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\MargoumSecondFini;
use App\Models\User;

class MargoumSecondFiniPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any MargoumSecondFini');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MargoumSecondFini $margoumsecondfini): bool
    {
        return $user->checkPermissionTo('view MargoumSecondFini');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create MargoumSecondFini');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MargoumSecondFini $margoumsecondfini): bool
    {
        return $user->checkPermissionTo('update MargoumSecondFini');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MargoumSecondFini $margoumsecondfini): bool
    {
        return $user->checkPermissionTo('delete MargoumSecondFini');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MargoumSecondFini $margoumsecondfini): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MargoumSecondFini $margoumsecondfini): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
