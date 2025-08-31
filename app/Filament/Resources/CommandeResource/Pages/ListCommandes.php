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
        // Only show create action for admin roles
        if (auth()->check() && (
            auth()->user()->hasRole('Superadmin') ||
            auth()->user()->hasRole('Superviseur') ||
            auth()->user()->hasRole('rh') ||
            auth()->user()->hasRole('Agent Commercial')
        )) {
            return [
                Actions\CreateAction::make()->label('+'),
            ];
        }

        // Return empty array for client users
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        // Only show header widgets for admin and agent commercial roles
        if (auth()->check() && (
            auth()->user()->hasRole('Superadmin') ||
            auth()->user()->hasRole('Superviseur') ||
            auth()->user()->hasRole('rh') ||
            auth()->user()->hasRole('Agent Commercial')
        )) {
            return [
                CommandeResource\Widgets\CommandeChart::class,
            ];
        }

        // Return empty array for client users
        return [];
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
