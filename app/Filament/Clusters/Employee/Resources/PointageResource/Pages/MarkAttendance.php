<?php

namespace App\Filament\Clusters\Employee\Resources\PointageResource\Pages;

use App\Filament\Clusters\Paie\Resources\PointageResource as ResourcesPointageResource;
use Filament\Resources\Pages\Page;

class MarkAttendance extends Page
{
    protected static string $resource = ResourcesPointageResource::class;

    protected ?string $heading = "Pointage";


    protected static string $view = 'filament.clusters.employee.resources.pointage-resource.pages.mark-attendance';

}
