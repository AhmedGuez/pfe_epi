<?php

namespace App\Filament\Clusters\Requetes\Resources\PrimeResource\Pages;

use App\Filament\Clusters\Requetes\Resources\PrimeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrime extends EditRecord
{
    protected static string $resource = PrimeResource::class;
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
