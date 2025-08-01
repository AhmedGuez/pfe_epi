<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DemandeAchatStatus: string implements HasColor, HasIcon, HasLabel
{
    case Annuler = 'annuler';
    case EnCours = 'en cours';
    case Confirmer = 'confirmer';

    public function getLabel(): string
    {
        return match ($this) {
            self::EnCours => 'En Cours',
            self::Annuler => 'Annuler',
            self::Confirmer => 'Confirmer',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::EnCours => 'info',
            self::Annuler => 'danger',
            self::Confirmer => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::EnCours => 'heroicon-m-clock',
            self::Annuler => 'heroicon-m-x-circle',
            self::Confirmer => 'heroicon-m-check-circle',
        };
    }
}
