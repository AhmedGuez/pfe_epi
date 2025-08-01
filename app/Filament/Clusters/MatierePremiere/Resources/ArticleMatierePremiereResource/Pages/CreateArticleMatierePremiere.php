<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\ArticleMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\ArticleMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticleMatierePremiere extends CreateRecord
{
    protected static string $resource = ArticleMatierePremiereResource::class;

    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
}
