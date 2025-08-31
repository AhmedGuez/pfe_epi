<?php

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource as BaseRoleResource;

class RoleResource extends BaseRoleResource
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('Super Admin') || 
            auth()->user()->hasRole('Superadmin') ||
            auth()->user()->hasPermissionTo('view-any Role')
        );
    }
} 