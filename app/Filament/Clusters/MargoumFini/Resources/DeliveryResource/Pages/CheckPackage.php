<?php
namespace App\Filament\Clusters\MargoumFini\Resources\DeliveryResource\Pages;

use Filament\Resources\Pages\Page;
use App\Filament\Clusters\MargoumFini\Resources\DeliveryResource;

class CheckPackage extends Page
{
    protected static string $resource = DeliveryResource::class;

    protected static string $view = 'filament.resources.delivery-resource.pages.check-package';

    protected static ?string $navigationLabel = 'Check Package Location';
    protected static ?string $title = 'Package Location Check';
    protected static ?string $slug = 'check-package';
}
