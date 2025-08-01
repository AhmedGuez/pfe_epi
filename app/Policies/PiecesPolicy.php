<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Pieces;
use App\Models\User;

class PiecesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Pieces');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pieces $pieces): bool
    {
        return $user->checkPermissionTo('view Pieces');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Pieces');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pieces $pieces): bool
    {
        return $user->checkPermissionTo('update Pieces');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pieces $pieces): bool
    {
        return $user->checkPermissionTo('delete Pieces');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pieces $pieces): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pieces $pieces): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
