<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Paie extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Ressource Humaines';

    protected static ?string $slug = 'rh/paie';
    protected static ?int $navigationSort = 0;
}
