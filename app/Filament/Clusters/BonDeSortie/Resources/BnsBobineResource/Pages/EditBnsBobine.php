<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsBobineResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsBobineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBnsBobine extends EditRecord
{
    protected static string $resource = BnsBobineResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
