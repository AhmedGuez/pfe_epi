<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\ArticleMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\ArticleMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticleMatierePremiere extends EditRecord
{
    protected static string $resource = ArticleMatierePremiereResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
