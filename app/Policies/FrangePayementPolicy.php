<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\FrangePayement;
use App\Models\User;

class FrangePayementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any FrangePayement');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FrangePayement $frangepayement): bool
    {
        return $user->checkPermissionTo('view FrangePayement');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create FrangePayement');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FrangePayement $frangepayement): bool
    {
        return $user->checkPermissionTo('update FrangePayement');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FrangePayement $frangepayement): bool
    {
        return $user->checkPermissionTo('delete FrangePayement');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FrangePayement $frangepayement): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FrangePayement $frangepayement): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
