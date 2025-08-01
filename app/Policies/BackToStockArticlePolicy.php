<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BackToStockArticle;
use App\Models\User;

class BackToStockArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BackToStockArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BackToStockArticle $backtostockarticle): bool
    {
        return $user->checkPermissionTo('view BackToStockArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BackToStockArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BackToStockArticle $backtostockarticle): bool
    {
        return $user->checkPermissionTo('update BackToStockArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BackToStockArticle $backtostockarticle): bool
    {
        return $user->checkPermissionTo('delete BackToStockArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BackToStockArticle $backtostockarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BackToStockArticle $backtostockarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
