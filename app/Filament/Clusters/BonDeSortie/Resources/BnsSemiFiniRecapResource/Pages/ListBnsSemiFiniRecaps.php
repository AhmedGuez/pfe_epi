<?php

namespace App\Filament\Clusters\BonDeSortie\Resources\BnsSemiFiniRecapResource\Pages;

use App\Filament\Clusters\BonDeSortie\Resources\BnsSemiFiniRecapResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBnsSemiFiniRecaps extends ListRecords
{
    protected static string $resource = BnsSemiFiniRecapResource::class;

    protected ?string $heading = "Recap Margoum Semi Fini";


    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
