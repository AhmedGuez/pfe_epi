<?php

namespace App\Filament\Clusters\Sanction\Resources\QuestionnaireResource\Pages;

use App\Filament\Clusters\Sanction\Resources\QuestionnaireResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestionnaire extends CreateRecord
{
    protected static string $resource = QuestionnaireResource::class;
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
