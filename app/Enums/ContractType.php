<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ContractType: string implements HasColor, HasIcon, HasLabel
{
    case CDI = 'CDI';
    case CDD = 'CDD';
    case CIVP = 'CIVP';
    case ESSAI = 'ESSAI';
    case TEMPS_PARTIEL = 'TEMPS_PARTIEL';
    case INTERIM = 'INTERIM';
    case STAGE = 'STAGE';
    case APPRENTISSAGE = 'APPRENTISSAGE';
    case PROFESSIONALISATION = 'PROFESSIONALISATION';
    case SAISONNIER = 'SAISONNIER';
    case FREELANCE = 'FREELANCE';
    case PORTAGE_SALARIAL = 'PORTAGE_SALARIAL';
    case AUTRE = 'AUTRE';

    public function getLabel(): string
    {
        return match ($this) {
            self::CDI => 'CDI',
            self::CDD => 'CDD ',
            self::CIVP => 'CIVP',
            self::ESSAI => 'Période d\'essai',
            self::TEMPS_PARTIEL => 'Temps partiel',
            self::INTERIM => 'Intérim',
            self::STAGE => 'Stage',
            self::APPRENTISSAGE => 'Apprentissage',
            self::PROFESSIONALISATION => 'Professionnalisation',
            self::SAISONNIER => 'Saisonnier',
            self::FREELANCE => 'Freelance/Indépendant',
            self::PORTAGE_SALARIAL => 'Portage salarial',
            self::AUTRE => 'Autre',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::CDI => 'primary',
            self::CDD => 'warning',
            self::CIVP => 'info',
            self::ESSAI => 'primary',
            self::TEMPS_PARTIEL => 'info',
            self::INTERIM => 'warning',
            self::STAGE => 'primary',
            self::APPRENTISSAGE => 'info',
            self::PROFESSIONALISATION => 'primary',
            self::SAISONNIER => 'warning',
            self::FREELANCE => 'primary',
            self::PORTAGE_SALARIAL => 'info',
            self::AUTRE => 'primary',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::CDI => 'heroicon-o-archive-box-arrow-down',
            self::CDD => 'heroicon-o-archive-box-arrow-down',
            self::CIVP => 'heroicon-o-archive-box-arrow-down',
            self::ESSAI => 'heroicon-o-archive-box-arrow-down',
            self::TEMPS_PARTIEL => 'heroicon-o-archive-box-arrow-down',
            self::INTERIM => 'heroicon-o-archive-box-arrow-down',
            self::STAGE => 'heroicon-o-archive-box-arrow-down',
            self::APPRENTISSAGE => 'heroicon-o-archive-box-arrow-down',
            self::PROFESSIONALISATION => 'heroicon-o-archive-box-arrow-down',
            self::SAISONNIER => 'heroicon-o-archive-box-arrow-down',
            self::FREELANCE => 'heroicon-o-archive-box-arrow-down',
            self::PORTAGE_SALARIAL => 'heroicon-o-archive-box-arrow-down',
            self::AUTRE => 'heroicon-o-archive-box-arrow-down',
        };
    }
}