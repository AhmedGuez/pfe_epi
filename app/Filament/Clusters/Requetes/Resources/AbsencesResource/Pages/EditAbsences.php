<?php

namespace App\Filament\Clusters\Requetes\Resources\AbsencesResource\Pages;

use App\Filament\Clusters\Requetes\Resources\AbsencesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbsences extends EditRecord
{
    protected static string $resource = AbsencesResource::class;
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
