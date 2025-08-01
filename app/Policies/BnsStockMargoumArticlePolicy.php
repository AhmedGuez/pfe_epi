<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnsStockMargoumArticle;
use App\Models\User;

class BnsStockMargoumArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnsStockMargoumArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnsStockMargoumArticle $bnsstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('view BnsStockMargoumArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnsStockMargoumArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnsStockMargoumArticle $bnsstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('update BnsStockMargoumArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnsStockMargoumArticle $bnsstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('delete BnsStockMargoumArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnsStockMargoumArticle $bnsstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnsStockMargoumArticle $bnsstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
