<?php

namespace App\Filament\Clusters\Sanction\Resources;

use App\Filament\Clusters\Sanction;
use App\Filament\Clusters\Sanction\Resources\LicenciementResource\Pages;
use App\Filament\Clusters\Sanction\Resources\LicenciementResource\RelationManagers;
use App\Models\Licenciement;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LicenciementResource extends Resource
{
    protected static ?string $model = Licenciement::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-minus';
    protected static ?string $navigationLabel = 'Licenciement';
    protected static ?int $navigationSort = 3;


    protected static ?string $cluster = Sanction::class;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('employe_id')
                ->relationship('employe', 'full_name') // Adjust to your `Employee` model name field
                ->required(),

            Select::make('type')->options([
                'Licenciement' =>'Licenciement',
                'Archivage' =>'Archivage',
                'Abondon de poste' =>'Abondon de poste',
                'Démission' =>'Démission'
            ])->required(),

            DatePicker::make('Date')->required(),

            Textarea::make('raison')
                ->label('Raison')
                ->nullable()
                ->required()
                ->columnSpan(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employe.full_name')->label('Nom Employe')->alignCenter(),
                TextColumn::make('date')->label('Date')->alignCenter(),
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
            'index' => Pages\ListLicenciements::route('/'),
            'create' => Pages\CreateLicenciement::route('/create'),
            'edit' => Pages\EditLicenciement::route('/{record}/edit'),
        ];
    }
}
