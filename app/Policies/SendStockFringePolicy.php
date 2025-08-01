<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\SendStockFringe;
use App\Models\User;

class SendStockFringePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any SendStockFringe');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SendStockFringe $sendstockfringe): bool
    {
        return $user->checkPermissionTo('view SendStockFringe');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create SendStockFringe');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SendStockFringe $sendstockfringe): bool
    {
        return $user->checkPermissionTo('update SendStockFringe');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SendStockFringe $sendstockfringe): bool
    {
        return $user->checkPermissionTo('delete SendStockFringe');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SendStockFringe $sendstockfringe): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SendStockFringe $sendstockfringe): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
