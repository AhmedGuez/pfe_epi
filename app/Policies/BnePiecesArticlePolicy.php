<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BnePiecesArticle;
use App\Models\User;

class BnePiecesArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BnePiecesArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BnePiecesArticle $bnepiecesarticle): bool
    {
        return $user->checkPermissionTo('view BnePiecesArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BnePiecesArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BnePiecesArticle $bnepiecesarticle): bool
    {
        return $user->checkPermissionTo('update BnePiecesArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BnePiecesArticle $bnepiecesarticle): bool
    {
        return $user->checkPermissionTo('delete BnePiecesArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BnePiecesArticle $bnepiecesarticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BnePiecesArticle $bnepiecesarticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
