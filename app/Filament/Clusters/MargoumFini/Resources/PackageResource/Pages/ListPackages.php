<?php

namespace App\Filament\Clusters\MargoumFini\Resources\PackageResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
