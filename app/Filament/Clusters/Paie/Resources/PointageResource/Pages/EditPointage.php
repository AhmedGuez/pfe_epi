<?php

namespace App\Filament\Clusters\Paie\Resources\PointageResource\Pages;

use App\Filament\Clusters\Paie\Resources\PointageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPointage extends EditRecord
{
    protected static string $resource = PointageResource::class;
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
