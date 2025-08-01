<?php

namespace App\Filament\Resources\CommandeResource\Widgets;

use App\Models\Commande;
use App\Models\CommandeArticle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommandeChart extends BaseWidget
{
    protected function getStats(): array
    {
        $totalOrders = Commande::count();
        $totalPieces = CommandeArticle::sum('nombre_de_pieces');
        $totalFinishedPieces = CommandeArticle::sum('nombre_de_pieces_fini');
        $totalPendingPieces = CommandeArticle::sum('nombre_de_pieces') - CommandeArticle::sum('nombre_de_pieces_livre');

        return [
            Stat::make('Total des commandes', $totalOrders)
            ->description('Nombre total de commandes')
            ->color('success'),
            Stat::make('Total des pièces commandées', $totalPieces)
                ->description('Nombre total de pièces commandées')
                ->color('primary'),
            Stat::make('Total des pièces finies', $totalFinishedPieces)
                ->description('Nombre total de pièces finies')
                ->color('success'),
            Stat::make('Total des pièces en attente', $totalPendingPieces)
                ->description('Nombre total de pièces en attente de livraison')
                ->color('warning'),
        
        ];
    }
}
