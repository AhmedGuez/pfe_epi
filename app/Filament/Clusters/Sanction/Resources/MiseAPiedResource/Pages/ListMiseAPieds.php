<?php

namespace App\Filament\Clusters\Sanction\Resources\MiseAPiedResource\Pages;

use App\Filament\Clusters\Sanction\Resources\MiseAPiedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMiseAPieds extends ListRecords
{
    protected static string $resource = MiseAPiedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
