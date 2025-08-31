<?php

namespace App\Filament\Imports;

use App\Models\Client;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ClientsImporter extends Importer
{
    protected static ?string $model = Client::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code_client')
                ->requiredMapping()
                ->rules(['required', 'integer', 'unique:clients,code_client'])
                ->example('123'),

            ImportColumn::make('nom_client')
                ->requiredMapping()
                ->rules(['required', 'string', 'max:255'])
                ->example('John Doe'),
            ImportColumn::make('cin')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('12345678'),
            ImportColumn::make('phone')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('+216 123 456'),
            ImportColumn::make('adresse')
                ->rules(['nullable', 'string', 'max:255'])
                ->example('123 Main Street'),
            ImportColumn::make('about_client')
                ->rules(['nullable', 'string', 'max:1000'])
                ->example('Preferred client with special requirements'),
        ];
    }

    public function resolveRecord(): ?Client
    {
        return Client::firstOrNew([
            'code_client' => $this->data['code_client'], // Ensure uniqueness based on code_client
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your clients import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
