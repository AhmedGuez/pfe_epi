<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\DemandeAchat;
use App\Models\User;

class DemandeAchatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any DemandeAchat');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DemandeAchat $demandeachat): bool
    {
        return $user->checkPermissionTo('view DemandeAchat');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create DemandeAchat');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DemandeAchat $demandeachat): bool
    {
        return $user->checkPermissionTo('update DemandeAchat');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DemandeAchat $demandeachat): bool
    {
        return $user->checkPermissionTo('delete DemandeAchat');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DemandeAchat $demandeachat): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DemandeAchat $demandeachat): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
