<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnlStockMargoum;
use App\Models\User;

class BnlStockMargoumPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnlStockMargoum');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnlStockMargoum $bnlstockmargoum): bool
    {
        return $user->checkPermissionTo('view BnlStockMargoum');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnlStockMargoum');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnlStockMargoum $bnlstockmargoum): bool
    {
        return $user->checkPermissionTo('update BnlStockMargoum');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnlStockMargoum $bnlstockmargoum): bool
    {
        return $user->checkPermissionTo('delete BnlStockMargoum');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnlStockMargoum $bnlstockmargoum): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnlStockMargoum $bnlstockmargoum): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
