<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ProductionMargoumArticle;
use App\Models\User;

class ProductionMargoumArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any ProductionMargoumArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductionMargoumArticle $productionmargoumarticle): bool
    {
        return $user->checkPermissionTo('view ProductionMargoumArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create ProductionMargoumArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductionMargoumArticle $productionmargoumarticle): bool
    {
        return $user->checkPermissionTo('update ProductionMargoumArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductionMargoumArticle $productionmargoumarticle): bool
    {
        return $user->checkPermissionTo('delete ProductionMargoumArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductionMargoumArticle $productionmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductionMargoumArticle $productionmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
