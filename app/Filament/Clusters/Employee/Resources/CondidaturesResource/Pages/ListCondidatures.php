<?php

namespace App\Filament\Clusters\Employee\Resources\CondidaturesResource\Pages;

use App\Filament\Clusters\Employee\Resources\CondidaturesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCondidatures extends ListRecords
{
    protected static string $resource = CondidaturesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
