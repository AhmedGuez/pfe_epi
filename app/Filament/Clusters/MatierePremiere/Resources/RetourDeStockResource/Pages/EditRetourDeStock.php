<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\RetourDeStockResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\RetourDeStockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRetourDeStock extends EditRecord
{
    protected static string $resource = RetourDeStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
