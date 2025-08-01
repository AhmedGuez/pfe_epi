<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum MargoumStatus: string implements HasColor, HasIcon, HasLabel
{
    case EnStock = 'en stock';
    case SoldOut = 'Epuisé';
  

    public function getLabel(): string
    {
        return match ($this) {
            self::EnStock => 'En Stock',
            self::SoldOut => 'Epuisé',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::EnStock => 'success',
            self::SoldOut => 'danger',
           
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
           
            self::EnStock => 'heroicon-m-check-circle',
            self::SoldOut => 'heroicon-m-x-circle',
           
        };
    }
}
