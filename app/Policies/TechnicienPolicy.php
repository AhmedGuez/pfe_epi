<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Technicien;
use App\Models\User;

class TechnicienPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Technicien');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Technicien $technicien): bool
    {
        return $user->checkPermissionTo('view Technicien');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Technicien');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Technicien $technicien): bool
    {
        return $user->checkPermissionTo('update Technicien');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Technicien $technicien): bool
    {
        return $user->checkPermissionTo('delete Technicien');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Technicien $technicien): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Technicien $technicien): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
