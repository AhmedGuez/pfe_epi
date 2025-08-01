<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnlMargoumArticle;
use App\Models\User;

class BnlMargoumArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnlMargoumArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnlMargoumArticle $bnlmargoumarticle): bool
    {
        return $user->checkPermissionTo('view BnlMargoumArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnlMargoumArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnlMargoumArticle $bnlmargoumarticle): bool
    {
        return $user->checkPermissionTo('update BnlMargoumArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnlMargoumArticle $bnlmargoumarticle): bool
    {
        return $user->checkPermissionTo('delete BnlMargoumArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnlMargoumArticle $bnlmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnlMargoumArticle $bnlmargoumarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
