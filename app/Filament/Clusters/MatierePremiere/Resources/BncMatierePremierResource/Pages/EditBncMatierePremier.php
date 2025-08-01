<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\BncMatierePremierResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\BncMatierePremierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBncMatierePremier extends EditRecord
{
    protected static string $resource = BncMatierePremierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
