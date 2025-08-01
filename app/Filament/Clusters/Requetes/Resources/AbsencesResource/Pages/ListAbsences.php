<?php

namespace App\Filament\Clusters\Requetes\Resources\AbsencesResource\Pages;

use App\Filament\Clusters\Requetes\Resources\AbsencesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsences extends ListRecords
{
    protected static string $resource = AbsencesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
