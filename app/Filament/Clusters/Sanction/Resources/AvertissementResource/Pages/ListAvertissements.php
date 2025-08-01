<?php

namespace App\Filament\Clusters\Sanction\Resources\AvertissementResource\Pages;

use App\Filament\Clusters\Sanction\Resources\AvertissementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvertissements extends ListRecords
{
    protected static string $resource = AvertissementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
