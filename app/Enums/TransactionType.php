<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TransactionType: string implements HasColor, HasIcon, HasLabel
{
    case Entry = 'entrée';
    case Spend = 'dépense';
    case Return = 'retour';

    public function getLabel(): string
    {
        return match ($this) {
            self::Entry => 'Entrée',
            self::Spend => 'Dépense',
            self::Return => 'Retour',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Entry => 'success',
            self::Spend => 'danger',
            self::Return => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Entry => 'heroicon-o-arrow-up-circle',
            self::Spend => 'heroicon-o-arrow-down-circle',
            self::Return => 'heroicon-o-arrow-path',
        };
    }
}
