<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\SuiviStockRebobinageArticle;
use App\Models\User;

class SuiviStockRebobinageArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any SuiviStockRebobinageArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SuiviStockRebobinageArticle $suivistockrebobinagearticle): bool
    {
        return $user->checkPermissionTo('view SuiviStockRebobinageArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create SuiviStockRebobinageArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SuiviStockRebobinageArticle $suivistockrebobinagearticle): bool
    {
        return $user->checkPermissionTo('update SuiviStockRebobinageArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SuiviStockRebobinageArticle $suivistockrebobinagearticle): bool
    {
        return $user->checkPermissionTo('delete SuiviStockRebobinageArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SuiviStockRebobinageArticle $suivistockrebobinagearticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SuiviStockRebobinageArticle $suivistockrebobinagearticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
