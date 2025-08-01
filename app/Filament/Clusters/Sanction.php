<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Sanction extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-face-frown';
    protected static ?string $navigationGroup = 'Ressource Humaines';
    // protected static ?string $navigationGroupSort = 0;
    protected static ?int $navigationSort = 0;


    protected static ?string $slug = 'rh/sanction';
}
