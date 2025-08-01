<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeesResource\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeesResource;
use App\Filament\Exports\EmployeesExporter;
use App\Filament\Imports\EmployeesImporter;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ImportAction::make()
            // ->importer(EmployeesImporter::class)->label('Import Excel'),
            // ExportAction::make()
            // ->exporter(exporter: EmployeesExporter::class)->label('Export Excel'),
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
