<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\StockNonConforme;
use App\Models\User;

class StockNonConformePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any StockNonConforme');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StockNonConforme $stocknonconforme): bool
    {
        return $user->checkPermissionTo('view StockNonConforme');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create StockNonConforme');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StockNonConforme $stocknonconforme): bool
    {
        return $user->checkPermissionTo('update StockNonConforme');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StockNonConforme $stocknonconforme): bool
    {
        return $user->checkPermissionTo('delete StockNonConforme');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StockNonConforme $stocknonconforme): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StockNonConforme $stocknonconforme): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
