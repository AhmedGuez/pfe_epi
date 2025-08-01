<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TransferStatus: string implements HasColor, HasIcon, HasLabel
{
    case EnCours = 'en cours';
    case EnAttente = 'en attente';
    case Livrer = 'livrer';

    public function getLabel(): string
    {
        return match ($this) {
            self::EnCours => 'En Cours',
            self::EnAttente => 'En Attente',
            self::Livrer => 'Livrer',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::EnCours => 'warning',
            self::EnAttente => 'info',
            self::Livrer => 'success',

        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::EnCours => 'heroicon-m-arrow-path',
            self::EnAttente => 'heroicon-m-clock',
            self::Livrer => 'heroicon-m-truck',
        };
    }
}
