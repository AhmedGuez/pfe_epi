<?php

namespace App\Filament\Clusters\MatierePremiere\Resources\ArticleMatierePremiereResource\Pages;

use App\Filament\Clusters\MatierePremiere\Resources\ArticleMatierePremiereResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticleMatierePremieres extends ListRecords
{
    protected static string $resource = ArticleMatierePremiereResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
