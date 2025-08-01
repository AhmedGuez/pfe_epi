<?php

namespace App\Filament\Clusters\Paie\Resources\SalaryResource\Pages;

use App\Filament\Clusters\Paie\Resources\SalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalaries extends ListRecords
{
    protected static string $resource = SalaryResource::class;

    protected ?string $heading = "Salaires";


    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
