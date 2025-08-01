<?php

namespace App\Filament\Clusters\Employee\Resources\CondidaturesResource\Pages;

use App\Filament\Clusters\Employee\Resources\CondidaturesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCondidatures extends EditRecord
{
    protected static string $resource = CondidaturesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
