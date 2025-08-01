<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsSemiFiniRecapResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsSemiFiniRecapResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBnsSemiFiniRecap extends EditRecord
{
    protected static string $resource = BnsSemiFiniRecapResource::class;

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
