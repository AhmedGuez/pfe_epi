<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Utilisateur')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('role')
                    ->label('Rôle')
                    ->options([
                        'owner' => 'Propriétaire',
                        'manager' => 'Gestionnaire',
                        'viewer' => 'Lecteur',
                    ])
                    ->default('viewer')
                    ->required(),
                Forms\Components\Toggle::make('is_primary')
                    ->label('Utilisateur Principal')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.role')
                    ->label('Rôle')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'owner' => 'danger',
                        'manager' => 'warning',
                        'viewer' => 'info',
                    }),
                Tables\Columns\IconColumn::make('pivot.is_primary')
                    ->label('Principal')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('role')
                            ->label('Rôle')
                            ->options([
                                'owner' => 'Propriétaire',
                                'manager' => 'Gestionnaire',
                                'viewer' => 'Lecteur',
                            ])
                            ->default('viewer')
                            ->required(),
                        Forms\Components\Toggle::make('is_primary')
                            ->label('Utilisateur Principal')
                            ->default(false),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(fn (Tables\Actions\EditAction $action): array => [
                        Forms\Components\Select::make('role')
                            ->label('Rôle')
                            ->options([
                                'owner' => 'Propriétaire',
                                'manager' => 'Gestionnaire',
                                'viewer' => 'Lecteur',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('is_primary')
                            ->label('Utilisateur Principal'),
                    ]),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
