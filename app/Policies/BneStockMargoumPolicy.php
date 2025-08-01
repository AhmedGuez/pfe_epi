<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BneStockMargoum;
use App\Models\User;

class BneStockMargoumPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BneStockMargoum');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BneStockMargoum $bnestockmargoum): bool
    {
        return $user->checkPermissionTo('view BneStockMargoum');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BneStockMargoum');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BneStockMargoum $bnestockmargoum): bool
    {
        return $user->checkPermissionTo('update BneStockMargoum');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BneStockMargoum $bnestockmargoum): bool
    {
        return $user->checkPermissionTo('delete BneStockMargoum');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BneStockMargoum $bnestockmargoum): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BneStockMargoum $bnestockmargoum): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
