<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnlStockMargoumArticle;
use App\Models\User;

class BnlStockMargoumArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnlStockMargoumArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnlStockMargoumArticle $bnlstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('view BnlStockMargoumArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnlStockMargoumArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnlStockMargoumArticle $bnlstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('update BnlStockMargoumArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnlStockMargoumArticle $bnlstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('delete BnlStockMargoumArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnlStockMargoumArticle $bnlstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnlStockMargoumArticle $bnlstockmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
