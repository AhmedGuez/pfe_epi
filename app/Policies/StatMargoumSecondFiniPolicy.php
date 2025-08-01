<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\StatMargoumSecondFini;
use App\Models\User;

class StatMargoumSecondFiniPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any StatMargoumSecondFini');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StatMargoumSecondFini $statmargoumsecondfini): bool
    {
        return $user->checkPermissionTo('view StatMargoumSecondFini');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create StatMargoumSecondFini');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StatMargoumSecondFini $statmargoumsecondfini): bool
    {
        return $user->checkPermissionTo('update StatMargoumSecondFini');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StatMargoumSecondFini $statmargoumsecondfini): bool
    {
        return $user->checkPermissionTo('delete StatMargoumSecondFini');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StatMargoumSecondFini $statmargoumsecondfini): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StatMargoumSecondFini $statmargoumsecondfini): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
