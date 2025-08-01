<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsPieces;
use App\Models\User;

class BnsPiecesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsPieces');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsPieces $bnspieces): bool
    {
        return $user->checkPermissionTo('view BnsPieces');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsPieces');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsPieces $bnspieces): bool
    {
        return $user->checkPermissionTo('update BnsPieces');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsPieces $bnspieces): bool
    {
        return $user->checkPermissionTo('delete BnsPieces');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsPieces $bnspieces): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsPieces $bnspieces): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
