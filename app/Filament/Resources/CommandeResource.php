<?php

namespace App\Filament\Resources;

use App\Enums\CommandeStatus;
use App\Filament\Resources\CommandeResource\Pages;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Filament\Actions\DirectDeleteAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CommandeResource extends Resource
{
    protected static ?string $model = Commande::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Gestion des Commandes Clients';
    protected static ?string $navigationLabel = "Liste des Commandes";
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('Superadmin') ||
            auth()->user()->hasRole('Superviseur') ||
            auth()->user()->hasRole('rh') ||
            auth()->user()->hasRole('Agent Commercial') ||
            auth()->user()->isClient()
        );
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['client:id,nom_entreprise']); // Eager load client relationship with only needed columns

        // If user is a client, only show their own commandes
        if (auth()->user()->isClient()) {
            $user = auth()->user();
            $clientIds = $user->clients()->pluck('clients.id');

            if ($clientIds->isNotEmpty()) {
                $query->whereIn('client_id', $clientIds);
            } else {
                // If client user has no associated clients, show nothing
                $query->whereRaw('1 = 0');
            }
        }

        return $query;
    }

    public static function canCreate(): bool
    {
        // Only admin users can create commandes
        return auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial');
    }

    public static function canEdit(Model $record): bool
    {
        // Only admin users can edit commandes
        return auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial');
    }

    public static function canDelete(Model $record): bool
    {
        // Only admin users can delete commandes
        return auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Commande Client')->schema([
                    TextInput::make('code_commande')
                        ->default(random_int(10000, 99999))
                        ->required(),

                    DatePicker::make('date_commande')
                        ->default(now())
                        ->required(),

                    Select::make('client_id')
                        ->label('Client')
                        ->relationship('client', 'nom_entreprise')
                        ->searchable()
                        ->preload()
                        ->required(),

                    ToggleButtons::make('status')
                        ->inline()
                        ->options(CommandeStatus::class)
                        ->required(),
                ])->columns(2),

                Repeater::make('CommandeArticles')
                    ->label('Article de la Commande')
                    ->relationship()
                    ->defaultItems(1)
                    ->columnSpanFull()
                    ->live()
                    ->schema([
                        Select::make('product_id')
                            ->label('Code Article')
                            ->relationship('product', 'code_article')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('code_article')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('SH/3033/2-4/BEIGE'),
                            ]),

                        TextInput::make('nombre_de_pieces')
                            ->numeric()
                            ->label('Quantité Demander')
                            ->required()
                            ->minValue(1)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $nombre_de_pieces = $get('nombre_de_pieces');
                                $set('nombre_de_pieces_reste_a_livre', $nombre_de_pieces);
                            }),

                        TextInput::make('nombre_de_pieces_fini')
                            ->numeric()
                            ->hiddenOn('create')
                            ->default('0'),

                        TextInput::make('nombre_de_pieces_semi_fini')
                            ->numeric()
                            ->hiddenOn('create')
                            ->default('0'),

                        TextInput::make('nombre_de_pieces_livre')
                            ->numeric()
                            ->hiddenOn('create')
                            ->default('0'),

                        TextInput::make('nombre_de_pieces_reste_a_livre')
                            ->numeric()
                            ->readOnly()
                            ->live(onBlur: true)
                            ->placeholder('Automatique!'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.nom_entreprise')
                    ->label('Client')
                    ->searchable()
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('code_commande')
                    ->label('N° Commande')
                    ->searchable()
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('date_commande')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->searchable()
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->alignCenter(),
                IconColumn::make('is_transfered')
                    ->label('Transfert')
                    ->boolean()
                    ->trueIcon('heroicon-m-arrows-right-left')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(25) // Set default pagination to 25 records
            ->filters([
                Filter::make('date_filter')
                    ->form([
                        DatePicker::make('date_from')->label('Date de début'),
                        DatePicker::make('date_to')->label('Date de fin'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_commande', '>=', $date),
                            )
                            ->when(
                                $data['date_to'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_commande', '<=', $date),
                            );
                    }),
                Filter::make('status_filter')
                    ->form([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'en cours' => 'En cours',
                                'en attente' => 'En attente',
                                'terminer' => 'Terminé',
                                'annuler' => 'Annulé',
                            ])
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['status'],
                                fn (Builder $query, $status): Builder => $query->where('status', $status),
                            );
                    }),
                Filter::make('client_filter')
                    ->form([
                        Select::make('client_id')
                            ->label('Client')
                            ->relationship('client', 'nom_entreprise')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['client_id'],
                                fn (Builder $query, $clientId): Builder => $query->where('client_id', $clientId),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('print')
                    ->label('Imprimer')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn (Commande $record): string => route('commande.print', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial') || auth()->user()->isClient()),
                Tables\Actions\EditAction::make()
                    ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
                DirectDeleteAction::make()
                    ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function (Collection $records) {
                            $records->each->delete();
                            Notification::make()
                                ->title('Commandes supprimées')
                                ->body(count($records) . ' commande(s) supprimée(s) avec succès.')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(false)
                        ->deselectRecordsAfterCompletion()
                        ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommandes::route('/'),
            'create' => Pages\CreateCommande::route('/create'),
            'view' => Pages\ViewCommande::route('/{record}'),
            'edit' => Pages\EditCommande::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        if (auth()->user()->isClient()) {
            return 'Mes Commandes';
        }

        return 'Gestion des Commandes Clients';
    }

    public static function getNavigationLabel(): string
    {
        if (auth()->user()->isClient()) {
            return 'Mes Commandes';
        }

        return 'Liste des Commandes';
    }
}