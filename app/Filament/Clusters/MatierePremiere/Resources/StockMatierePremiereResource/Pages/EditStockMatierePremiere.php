<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\StockMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\StockMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockMatierePremiere extends EditRecord
{
    protected static string $resource = StockMatierePremiereResource::class;

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
