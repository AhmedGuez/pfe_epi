<?php

namespace App\Filament\Clusters\Sanction\Resources\QuestionnaireResource\Pages;

use App\Filament\Clusters\Sanction\Resources\QuestionnaireResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestionnaires extends ListRecords
{
    protected static string $resource = QuestionnaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
