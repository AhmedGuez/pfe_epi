<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
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

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Gestion des Commandes Clients';
    protected static ?string $navigationLabel = "Liste des Clients";

    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                Tables\Columns\TextColumn::make('nom_entreprise')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('adresse')
                    ->searchable(),
                Tables\Columns\TextColumn::make('matricule_fiscale')
                    ->searchable(),
                Tables\Columns\IconColumn::make('air')
                    ->boolean(),
                Tables\Columns\IconColumn::make('tva')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
}
