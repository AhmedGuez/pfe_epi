<?php

namespace App\Filament\Imports;

use App\Models\Employee;
use App\Models\Employees;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class EmployeesImporter extends Importer
{
    protected static ?string $model = Employees::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('code'),        // Full Name column
            ImportColumn::make('full_name'),        // Full Name column
            ImportColumn::make('contract_type'),   // Contract Type column
            ImportColumn::make('affected'),   // Contract Type column
            ImportColumn::make('prix_heure'),      // Hourly Rate column
            ImportColumn::make('post'),            // Post column
            ImportColumn::make('hire_date'),       // Hire Date column
            ImportColumn::make('phone_number'),    // Phone Number column
            ImportColumn::make('cin'),             // CIN column
            ImportColumn::make('address'),         // Address column
            ImportColumn::make('situation'),         // Address column
            ImportColumn::make('nombre_enfants'),         // Address columngit 
        ];
    }

    public function resolveRecord(): ?Employees
    {
        $employee = new Employees();

        // Map the imported data to the model fields
        $employee->code = $this->data['code'] ?? null;
        $employee->full_name = $this->data['full_name'] ?? null;
        $employee->contract_type = $this->data['contract_type'] ?? null;
        $employee->affected = $this->data['affected'] ?? null;
        $employee->prix_heure = $this->data['prix_heure'] ?? null;
        $employee->post = $this->data['post'] ?? null;
        $employee->hire_date = $this->data['hire_date'] ?? null;
        $employee->phone_number = $this->data['phone_number'] ?? null;
        $employee->cin = $this->data['cin'] ?? null;
        $employee->address = $this->data['address'] ?? null;

        return $employee;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employee import has completed, and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported successfully.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' However, ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
