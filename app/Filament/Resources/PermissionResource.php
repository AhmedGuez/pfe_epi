<?php

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource as BasePermissionResource;

class PermissionResource extends BasePermissionResource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('Super Admin') ||
            auth()->user()->hasRole('Superadmin') ||
            auth()->user()->hasPermissionTo('view-any Permission')
        );
    }
}