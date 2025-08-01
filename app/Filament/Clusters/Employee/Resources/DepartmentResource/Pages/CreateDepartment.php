<?php

namespace App\Filament\Clusters\Employee\Resources\DepartmentResource\Pages;

use App\Filament\Clusters\Employee\Resources\DepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected function getRedirectUrl(): string 
    {
        return $this->getResource()::getUrl('index');
    }
    protected static string $resource = DepartmentResource::class;
}
