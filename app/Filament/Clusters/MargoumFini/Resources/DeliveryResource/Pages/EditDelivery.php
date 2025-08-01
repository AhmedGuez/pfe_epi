<?php

namespace App\Filament\Clusters\MargoumFini\Resources\DeliveryResource\Pages;

use App\Filament\Clusters\MargoumFini\Resources\DeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\Action;

class EditDelivery extends EditRecord
{
    protected static string $resource = DeliveryResource::class;

 

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('scan')
            ->url(fn ($record) => DeliveryResource::getUrl('deliverypage', ['record' => $record])),
        ];
    }
}
