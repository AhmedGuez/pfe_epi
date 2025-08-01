<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Affected: string implements HasColor, HasIcon, HasLabel
{
    case USINE_1 = 'USINE_1';
    case USINE_2 = 'USINE_2';

    public function getLabel(): string
    {
        return match ($this) {
            self::USINE_1 => 'Usine 1',
            self::USINE_2 => 'Usine 2',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::USINE_1 => 'primary',
            self::USINE_2 => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::USINE_1 => 'heroicon-o-building-office', // Changed icon to 'building'
            self::USINE_2 => 'heroicon-o-home-modern',
        };
    }
}
