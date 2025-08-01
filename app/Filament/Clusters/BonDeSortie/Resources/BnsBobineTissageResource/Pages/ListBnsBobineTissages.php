<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsBobineTissageResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsBobineTissageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBnsBobineTissages extends ListRecords
{
    protected static string $resource = BnsBobineTissageResource::class;

    protected ?string $heading = "Bon Sortie Bobine Surfilage";

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
