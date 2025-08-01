<?php

namespace App\Filament\Clusters\Calendrier\Resources;

use App\Filament\Clusters\Calendrier;
use App\Filament\Clusters\Calendrier\Resources\EventResource\Pages;
use App\Filament\Clusters\Calendrier\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Calendrier::class;

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            // TextInput::make('name')
            //     ->label('Event Name')
            //     ->required(),

            // DateTimePicker::make('starts_at')
            //     ->label('Start Date & Time')
            //     ->required(),

            // DateTimePicker::make('ends_at')
            //     ->label('End Date & Time')
            //     ->required(),
        ]);
}

    

    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             // Tables\Columns\TextColumn::make('name')->sortable(),
    //             // Tables\Columns\TextColumn::make('starts_at')->dateTime(),
    //             // Tables\Columns\TextColumn::make('ends_at')->dateTime(),
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->actions([
    //             Tables\Actions\EditAction::make(),
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
