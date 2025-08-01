<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\StatMargoumFini;
use App\Models\User;

class StatMargoumFiniPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any StatMargoumFini');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StatMargoumFini $statmargoumfini): bool
    {
        return $user->checkPermissionTo('view StatMargoumFini');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create StatMargoumFini');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StatMargoumFini $statmargoumfini): bool
    {
        return $user->checkPermissionTo('update StatMargoumFini');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StatMargoumFini $statmargoumfini): bool
    {
        return $user->checkPermissionTo('delete StatMargoumFini');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StatMargoumFini $statmargoumfini): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StatMargoumFini $statmargoumfini): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
