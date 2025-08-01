<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsMargoumSemiFiniResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsMargoumSemiFiniResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBnsMargoumSemiFinis extends ListRecords
{
    protected static string $resource = BnsMargoumSemiFiniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
