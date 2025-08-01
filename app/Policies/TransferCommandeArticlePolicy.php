<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TransferCommandeArticle;
use App\Models\User;

class TransferCommandeArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any TransferCommandeArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TransferCommandeArticle $transfercommandearticle): bool
    {
        return $user->checkPermissionTo('view TransferCommandeArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create TransferCommandeArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TransferCommandeArticle $transfercommandearticle): bool
    {
        return $user->checkPermissionTo('update TransferCommandeArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TransferCommandeArticle $transfercommandearticle): bool
    {
        return $user->checkPermissionTo('delete TransferCommandeArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TransferCommandeArticle $transfercommandearticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TransferCommandeArticle $transfercommandearticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
