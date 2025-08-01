<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsBobineTissageResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsBobineTissageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBnsBobineTissage extends EditRecord
{
    protected static string $resource = BnsBobineTissageResource::class;

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
