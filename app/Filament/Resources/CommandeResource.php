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

use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommandeResource extends Resource
{
    protected static ?string $model = Commande::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Gestion des Commandes Clients';
    protected static ?string $navigationLabel = "Liste des Commandes";
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

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
                        ->options(
                            Client::all()
                                ->filter(fn($client) => !is_null($client->nom_entreprise))
                                ->pluck('nom_entreprise', 'id')
                        )
                        ->searchable()
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
                            ->options(
                                Product::all()
                                    ->filter(fn($product) => !is_null($product->code_article))
                                    ->pluck('code_article', 'id')
                            )
                            ->preload()
                            ->searchable()
                            ->required()
                            ->relationship('product', 'code_article')
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
                TextColumn::make('client.nom_entreprise')->searchable()->sortable()->alignCenter(),
                TextColumn::make('code_commande')->searchable()->sortable()->alignCenter(),
                TextColumn::make('date_commande')->searchable()->sortable()->alignCenter(),
                TextColumn::make('status')->badge()->alignCenter(),
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
            ->filters([
                Filter::make('date_filter')
                    ->form([
                        DatePicker::make('date')->label('Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!$data['date']) return $query;
                        return $query->whereDate('created_at', $data['date']);
                    }),

                Filter::make('client_filter')
                    ->form([
                        Select::make('client_id')
                            ->label('Client')
                            ->options(
                                Client::all()
                                    ->filter(fn($client) => !is_null($client->nom_client))
                                    ->pluck('nom_client', 'id')
                            )
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!$data['client_id']) return $query;
                        return $query->where('client_id', $data['client_id']);
                    }),

                Filter::make('status_filter')
                    ->form([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'en cours' => 'Commande en Cours',
                                'en attente' => 'Commande en Attente',
                                'terminer' => 'Commande Terminée',
                                'annuler' => 'Commande Annulée',
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!isset($data['status'])) return $query;
                        return $query->where('status', $data['status']);
                    }),
            ])
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Action::make('Recap Commande')
                //     ->icon('heroicon-o-printer')
                //     ->color('success')
                //     ->url(fn(Commande $record) => route('suivi.pdf.download', $record))
                //     ->openUrlInNewTab(),
                // ActionGroup::make([
                //     Action::make('Suivi Commande')
                //         ->icon('heroicon-o-folder-arrow-down')
                //         ->url(fn(Commande $record) => route('commande.pdf.download', $record))
                //         ->color('warning')
                //         ->openUrlInNewTab(),
                //     Action::make('Commande Journalier')
                //         ->icon('heroicon-o-printer')
                //         ->color('success')
                //         ->url(fn(Commande $record) => route('Jrcommande.pdf.download', $record))
                //         ->openUrlInNewTab(),
                // ])->icon('heroicon-m-ellipsis-horizontal'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('created_at')
                    ->label('Date')
                    ->date()
                    ->collapsible(),
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
}