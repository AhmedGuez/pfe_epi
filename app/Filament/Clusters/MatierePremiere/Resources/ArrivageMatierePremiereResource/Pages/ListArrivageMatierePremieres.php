<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\ArrivageMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\ArrivageMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArrivageMatierePremieres extends ListRecords
{
    protected static string $resource = ArrivageMatierePremiereResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
