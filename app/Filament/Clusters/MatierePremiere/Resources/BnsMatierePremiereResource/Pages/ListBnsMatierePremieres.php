<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\BnsMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\BnsMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBnsMatierePremieres extends ListRecords
{
    protected static string $resource = BnsMatierePremiereResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
