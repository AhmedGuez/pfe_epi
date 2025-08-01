<?php

namespace App\Filament\Resources\DemandeAchatsResource\Pages;

use App\Filament\Resources\DemandeAchatsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDemandeAchats extends ListRecords
{
    protected static string $resource = DemandeAchatsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
