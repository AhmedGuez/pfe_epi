<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CommandeStatus: string implements HasColor, HasIcon, HasLabel
{
    case EnCours = 'en cours';
    case EnAttente = 'en attente';
    case Terminer = 'terminer';
    case Annuler = 'annuler';
    case Livrer = 'livrer'; // Change this line


    public function getLabel(): string
    {
        return match ($this) {
            self::EnCours => 'En Cours',
            self::EnAttente => 'En Attente',
            self::Terminer => 'Terminer',
            self::Annuler => 'Annuler',
            self::Livrer => 'Livrer',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::EnCours => 'warning',
            self::EnAttente => 'info',
            self::Terminer => 'success',
            self::Annuler => 'danger',
            self::Livrer => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::EnCours => 'heroicon-m-arrow-path',
            self::EnAttente => 'heroicon-m-clock',
            self::Terminer => 'heroicon-m-check-circle',
            self::Annuler => 'heroicon-m-x-circle',
            self::Livrer => 'heroicon-m-truck',
        };
    }

    
}
