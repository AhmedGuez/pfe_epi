<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BneStockMargoumArticle;
use App\Models\User;

class BneStockMargoumArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BneStockMargoumArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BneStockMargoumArticle $bnestockmargoumarticle): bool
    {
        return $user->checkPermissionTo('view BneStockMargoumArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BneStockMargoumArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BneStockMargoumArticle $bnestockmargoumarticle): bool
    {
        return $user->checkPermissionTo('update BneStockMargoumArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BneStockMargoumArticle $bnestockmargoumarticle): bool
    {
        return $user->checkPermissionTo('delete BneStockMargoumArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BneStockMargoumArticle $bnestockmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BneStockMargoumArticle $bnestockmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
