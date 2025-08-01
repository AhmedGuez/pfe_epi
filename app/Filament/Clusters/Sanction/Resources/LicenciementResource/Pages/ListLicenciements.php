<?php

namespace App\Filament\Clusters\Sanction\Resources\LicenciementResource\Pages;

use App\Filament\Clusters\Sanction\Resources\LicenciementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLicenciements extends ListRecords
{
    protected static string $resource = LicenciementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
