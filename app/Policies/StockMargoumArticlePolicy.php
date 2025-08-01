<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\StockMargoumArticle;
use App\Models\User;

class StockMargoumArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any StockMargoumArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StockMargoumArticle $stockmargoumarticle): bool
    {
        return $user->checkPermissionTo('view StockMargoumArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create StockMargoumArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StockMargoumArticle $stockmargoumarticle): bool
    {
        return $user->checkPermissionTo('update StockMargoumArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StockMargoumArticle $stockmargoumarticle): bool
    {
        return $user->checkPermissionTo('delete StockMargoumArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StockMargoumArticle $stockmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StockMargoumArticle $stockmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
