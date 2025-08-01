<?php

namespace App\Filament\Resources\CommandeResource\Pages;

use App\Filament\Resources\CommandeResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListCommandes extends ListRecords
{
    protected static string $resource = CommandeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CommandeResource\Widgets\CommandeChart::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'En Attente' => Tab::make()->query(fn ($query) => $query->where('status', 'en attente')),
            'En Cours' => Tab::make()->query(fn ($query) => $query->where('status', 'en cours')),
            'Terminer' => Tab::make()->query(fn ($query) => $query->where('status', 'terminer')),
            'Annuler' => Tab::make()->query(fn ($query) => $query->where('status', 'annuler')),
            'Livrer' => Tab::make()->query(fn ($query) => $query->where('status', 'livrer')),
        ];
    }
}
