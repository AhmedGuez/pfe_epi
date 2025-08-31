<?php

namespace App\Filament\Resources\CommandeResource\Widgets;

use App\Models\Commande;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ClientOrdersWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Mes Commandes Récentes';

    public function table(Table $table): Table
    {
        $query = Commande::query();

        // If user is a client, only show their own commandes
        if (auth()->user()->hasRole('Client')) {
            $user = auth()->user();
            $clientIds = $user->clients()->pluck('clients.id');

            if ($clientIds->isNotEmpty()) {
                $query->whereIn('client_id', $clientIds);
            } else {
                // If client user has no associated clients, show nothing
                $query->whereRaw('1 = 0');
            }
        }

        return $table
            ->query($query->latest()->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('code_commande')
                    ->label('N° Commande')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_commande')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('client.nom_entreprise')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'en cours' => 'warning',
                        'terminer' => 'success',
                        'en attente' => 'gray',
                        'annuler' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('commandeArticles.nombre_de_pieces')
                    ->label('Quantité Totale')
                    ->sum('commandeArticles', 'nombre_de_pieces'),

                Tables\Columns\TextColumn::make('commandeArticles.nombre_de_pieces_livre')
                    ->label('Livré')
                    ->sum('commandeArticles', 'nombre_de_pieces_livre'),

                Tables\Columns\TextColumn::make('commandeArticles.nombre_de_pieces_reste_a_livre')
                    ->label('Reste à Livrer')
                    ->sum('commandeArticles', 'nombre_de_pieces_reste_a_livre'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Voir')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Commande $record): string => route('filament.admin.resources.commandes.view', $record))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('print')
                    ->label('Imprimer')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn (Commande $record): string => route('commande.print', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (): bool => auth()->user()->hasRole('Client')),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Aucune commande trouvée')
            ->emptyStateDescription('Vous n\'avez pas encore de commandes.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Client');
    }
}