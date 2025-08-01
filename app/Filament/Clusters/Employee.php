<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Employee extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Ressource Humaines';

    protected static ?string $navigationLabel = 'Gestion des employés';

    protected static ?string $slug = 'rh/employee';
    protected static ?int $navigationSort = 0;
}
