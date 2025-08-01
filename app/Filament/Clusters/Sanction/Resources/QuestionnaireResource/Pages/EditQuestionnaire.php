<?php

namespace App\Filament\Clusters\Sanction\Resources\QuestionnaireResource\Pages;

use App\Filament\Clusters\Sanction\Resources\QuestionnaireResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestionnaire extends EditRecord
{
    protected static string $resource = QuestionnaireResource::class;
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
