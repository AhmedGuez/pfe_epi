<?php

namespace App\Filament\Clusters\Employee\Resources\EmployeesResource\Pages;

use App\Filament\Clusters\Employee\Resources\EmployeesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployees extends CreateRecord
{
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = EmployeesResource::class;
}
