<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Exports\ClientsExporter;
use App\Filament\Imports\ClientsImporter;
use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ImportAction::make()
            // ->importer(ClientsImporter::class),
            // ExportAction::make()
            // ->exporter(exporter: ClientsExporter::class),
            Actions\CreateAction::make()->label('+'),
        ];
    }
}
