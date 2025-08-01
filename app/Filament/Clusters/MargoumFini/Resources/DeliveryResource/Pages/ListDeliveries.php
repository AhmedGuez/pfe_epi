<?php

namespace App\Filament\Clusters\MargoumFini\Resources\DeliveryResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\DeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveries extends ListRecords
{
    protected static string $resource = DeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\Action::make('check-package')
            ->label('Check Package')
            ->color('success')
            ->icon('heroicon-o-qr-code')
            ->url(fn () => CheckPackage::getUrl()), 
            Actions\Action::make('Make Delivery')
            ->label('CreateDelivery')
            ->color('primary')
            ->icon('heroicon-o-truck')
            ->url('/admin/produit-fini/deliveries/deliverypage'),
        ];
    }
}
