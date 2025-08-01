<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\DeliveryItems;
use App\Models\User;

class DeliveryItemsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any DeliveryItems');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DeliveryItems $deliveryitems): bool
    {
        return $user->checkPermissionTo('view DeliveryItems');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create DeliveryItems');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DeliveryItems $deliveryitems): bool
    {
        return $user->checkPermissionTo('update DeliveryItems');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeliveryItems $deliveryitems): bool
    {
        return $user->checkPermissionTo('delete DeliveryItems');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DeliveryItems $deliveryitems): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DeliveryItems $deliveryitems): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
