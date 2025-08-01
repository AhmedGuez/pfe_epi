<?php
namespace App\Filament\Imports;

use App\Models\Pointage;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PointageImporter extends Importer
{
    protected static ?string $model = Pointage::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('employee_id'), // Employee ID column (use the correct key)
            ImportColumn::make('date'),           // Date column
            ImportColumn::make('hours_worked'),   // Hours Worked column
            ImportColumn::make('overtime_hours'), // Overtime Hours column
            ImportColumn::make('is_weekend'),     // Weekend column (boolean)
        ];
    }

    public function resolveRecord(): ?Pointage
    {
        $pointage = new Pointage();
    
        // Map the imported data to the model fields using the associative array keys
        $pointage->employee_id = $this->data['employee_name'] ?? null; // Use 'employee_name' as the key
        $pointage->date = $this->data['date'] ?? null;                   // Use 'date' as the key
        $pointage->hours_worked = $this->data['hours_worked'] ?? null;   // Use 'hours_worked' as the key
        $pointage->overtime_hours = $this->data['overtime_hours'] ?? null; // Use 'overtime_hours' as the key
        $pointage->is_weekend = strtolower($this->data['is_weekend'] ?? '') === 'yes' || $this->data['is_weekend'] == 1; // Use 'is_weekend' as the key
    
        return $pointage;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your pointage import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
