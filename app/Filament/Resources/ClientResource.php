<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;
use App\Filament\Actions\DirectDeleteAction;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Gestion des Commandes Clients';
    protected static ?string $navigationLabel = "Liste des Clients";

    protected static ?string $navigationIcon = 'heroicon-o-users';

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

    public static function getNavigationGroup(): ?string
    {
        if (auth()->user()->isClient()) {
            return 'Mon Compte';
        }

        return 'Gestion des Commandes Clients';
    }

    public static function getNavigationLabel(): string
    {
        if (auth()->user()->isClient()) {
            return 'Mon Profil';
        }

        return 'Liste des Clients';
    }

      public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Wizard::make([
                    Step::make('Step 1')
                        ->schema([
                        Forms\Components\TextInput::make('nom')
                        ->required()
                        ->maxLength(255),
                        Forms\Components\TextInput::make('prenom')->label('Prénom')
                        ->required()
                        ->maxLength(255),
                        Forms\Components\TextInput::make('nom_entreprise')
                        ->required()
                        ->maxLength(255),
                        Forms\Components\TextInput::make('matricule_fiscale')
                        ->maxLength(255),
                            ]),
                    
                    Step::make('Step 2')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telephone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('adresse')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('commentaire')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),

                    Step::make('Step 3')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe pour l\'utilisateur')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->helperText(fn (string $context): string => 
                                $context === 'create' 
                                    ? 'Ce mot de passe sera utilisé pour créer un compte utilisateur avec le rôle "client"'
                                    : 'Laissez vide pour ne pas changer le mot de passe'
                            ),
                        Forms\Components\Toggle::make('air') ->onColor('success')
                        ->offColor('danger'),
                        Forms\Components\Toggle::make('tva') ->onColor('success')
                        ->offColor('danger'),
                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')->label('Nom')->searchable()->sortable()->alignCenter(),
                TextColumn::make('prenom')->label('Prénom')->searchable()->sortable()->alignCenter(),
                TextColumn::make('nom_entreprise')->label('Nom Entreprise')->searchable()->sortable()->alignCenter(),
                TextColumn::make('email')->label('Email')->searchable()->sortable()->alignCenter(),
                TextColumn::make('telephone')->label('Téléphone')->searchable()->sortable()->alignCenter(),
                TextColumn::make('adresse')->label('Adresse')->searchable()->sortable()->alignCenter(),
                TextColumn::make('user.name')->label('Utilisateur Principal')->searchable()->sortable()->alignCenter()
                    ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
                TextColumn::make('user.roles.name')->label('Rôle')->badge()->alignCenter()
                    ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('has_user')
                    ->label('Avec utilisateur')
                    ->options([
                        '1' => 'Avec utilisateur',
                        '0' => 'Sans utilisateur',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if ($data['value'] === '1') {
                            return $query->whereNotNull('user_id');
                        }
                        if ($data['value'] === '0') {
                            return $query->whereNull('user_id');
                        }
                        return $query;
                    })
                    ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
                DirectDeleteAction::make()
                    ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(false)
                        ->visible(fn (): bool => auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial')),
                ]),
            ])
            ->persistSortInSession();
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // If user is a client, only show their own client information
        if (auth()->user()->isClient()) {
            $user = auth()->user();
            $clientIds = $user->clients()->pluck('clients.id');

            if ($clientIds->isNotEmpty()) {
                $query->whereIn('id', $clientIds);
            } else {
                // If client user has no associated clients, show nothing
                $query->whereRaw('1 = 0');
            }
        }

        return $query;
    }

    public static function canCreate(): bool
    {
        // Only admin users can create clients
        return auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial');
    }

    public static function canEdit(Model $record): bool
    {
        // Only admin users can edit clients
        return auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial');
    }

    public static function canDelete(Model $record): bool
    {
        // Only admin users can delete clients
        return auth()->user()->hasRole('Superadmin') || auth()->user()->hasRole('Superviseur') || auth()->user()->hasRole('rh') || auth()->user()->hasRole('Agent Commercial');
    }
}
