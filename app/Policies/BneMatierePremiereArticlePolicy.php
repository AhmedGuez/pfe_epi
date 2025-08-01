<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\BneMatierePremiereArticle;
use App\Models\User;

class BneMatierePremiereArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any BneMatierePremiereArticle');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BneMatierePremiereArticle $bnematierepremierearticle): bool
    {
        return $user->checkPermissionTo('view BneMatierePremiereArticle');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create BneMatierePremiereArticle');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BneMatierePremiereArticle $bnematierepremierearticle): bool
    {
        return $user->checkPermissionTo('update BneMatierePremiereArticle');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BneMatierePremiereArticle $bnematierepremierearticle): bool
    {
        return $user->checkPermissionTo('delete BneMatierePremiereArticle');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BneMatierePremiereArticle $bnematierepremierearticle): bool
    {
        return $user->checkPermissionTo('{{ restorePermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BneMatierePremiereArticle $bnematierepremierearticle): bool
    {
        return $user->checkPermissionTo('{{ forceDeletePermission }}');
    }
}
