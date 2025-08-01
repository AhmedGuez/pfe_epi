<?php

namespace App\Filament\Clusters\Sanction\Resources;

use App\Filament\Clusters\Sanction;
use App\Filament\Clusters\Sanction\Resources\AvertissementResource\Pages;
use App\Filament\Clusters\Sanction\Resources\AvertissementResource\RelationManagers;
use App\Models\Avertissement;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvertissementResource extends Resource
{
    protected static ?string $model = Avertissement::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?int $navigationSort = 0;

    protected static ?string $cluster = Sanction::class;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            
            Select::make('type')->options([
                'Orale' =>'Orale',
                'Ecrit' =>'Ecrit'
            ]),
            Select::make('employe_id')
                ->relationship('employe', 'full_name') // Adjust to your `Employee` model name field
                ->required(),

            Textarea::make('raison')
                ->label('Raison')
                ->nullable()->columnSpan(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('created_at')->label('Date et Heure de Creation')->alignCenter(),
               TextColumn::make('employe.full_name')->label('Nom Employe')->alignCenter(),
               TextColumn::make('type')->label("Type D'avertissement")->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAvertissements::route('/'),
            // 'create' => Pages\CreateAvertissement::route('/create'),
            // 'edit' => Pages\EditAvertissement::route('/{record}/edit'),
        ];
    }
}
