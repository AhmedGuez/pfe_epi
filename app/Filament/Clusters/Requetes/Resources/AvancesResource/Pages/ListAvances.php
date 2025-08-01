<?php

namespace App\Filament\Clusters\Requetes\Resources\AvancesResource\Pages;

use App\Filament\Clusters\Requetes\Resources\AvancesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvances extends ListRecords
{
    protected static string $resource = AvancesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
