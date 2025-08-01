<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\BncMatierePremierResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\BncMatierePremierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBncMatierePremiers extends ListRecords
{
    protected static string $resource = BncMatierePremierResource::class;

    protected ?string $heading = "Bon de Commande Matière Première";


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
