<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TransferMargoumFini;
use App\Models\User;

class TransferMargoumFiniPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any TransferMargoumFini');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TransferMargoumFini $transfermargoumfini): bool
    {
        return $user->checkPermissionTo('view TransferMargoumFini');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create TransferMargoumFini');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TransferMargoumFini $transfermargoumfini): bool
    {
        return $user->checkPermissionTo('update TransferMargoumFini');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TransferMargoumFini $transfermargoumfini): bool
    {
        return $user->checkPermissionTo('delete TransferMargoumFini');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TransferMargoumFini $transfermargoumfini): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TransferMargoumFini $transfermargoumfini): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
