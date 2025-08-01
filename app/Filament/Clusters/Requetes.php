<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Requetes extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationGroup = 'Ressource Humaines';

    protected static ?string $slug = 'rh/requetes';
    protected static ?int $navigationSort = 0;

}
