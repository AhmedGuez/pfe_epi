<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsBobineResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsBobineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBnsBobines extends ListRecords
{
    protected static string $resource = BnsBobineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
