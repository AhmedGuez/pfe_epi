<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\MargoumFini;
use App\Models\User;

class MargoumFiniPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any MargoumFini');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MargoumFini $margoumfini): bool
    {
        return $user->checkPermissionTo('view MargoumFini');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create MargoumFini');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MargoumFini $margoumfini): bool
    {
        return $user->checkPermissionTo('update MargoumFini');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MargoumFini $margoumfini): bool
    {
        return $user->checkPermissionTo('delete MargoumFini');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MargoumFini $margoumfini): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MargoumFini $margoumfini): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
