<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnePieces;
use App\Models\User;

class BnePiecesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnePieces');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnePieces $bnepieces): bool
    {
        return $user->checkPermissionTo('view BnePieces');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnePieces');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnePieces $bnepieces): bool
    {
        return $user->checkPermissionTo('update BnePieces');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnePieces $bnepieces): bool
    {
        return $user->checkPermissionTo('delete BnePieces');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnePieces $bnepieces): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnePieces $bnepieces): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
