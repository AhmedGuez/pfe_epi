<?php

namespace App\Filament\Clusters\MargoumFini\Resources\DepotResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\DepotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepots extends ListRecords
{
    protected static string $resource = DepotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
