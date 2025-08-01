<?php

namespace App\Filament\Clusters\Requetes\Resources\PrimeResource\Pages;

use App\Filament\Clusters\Requetes\Resources\PrimeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrimes extends ListRecords
{
    protected static string $resource = PrimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
