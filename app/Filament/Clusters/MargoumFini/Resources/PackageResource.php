<?php

namespace App\Filament\Clusters\MargoumFini\Resources;

use App\Filament\Clusters\ProduitFini;
use App\Filament\Clusters\MargoumFini\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = "Étiquetage Produit Fini";
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $cluster = ProduitFini::class;
    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('product_id')
                ->relationship('product', 'code_article')
                ->required()
                ->searchable()
                ->preload(),

            Select::make('depot_id')
                ->relationship('depot', 'name')
                ->required(),

            TextInput::make('quantity')
                ->numeric()
                ->minValue(1)
                ->required(),

            Select::make('status')
                ->options([
                    'Draft' => 'Draft',
                    'Pending' => 'Pending',
                    'Confirmed' => 'Confirmed',
                    'delivered' => 'Delivered',
                    'Cancelled' => 'Cancelled',
                ])
                ->default('Draft')
                ->required()
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('qr_code')
            ->label('#Qr-Code')
            ->searchable()
            ->formatStateUsing(fn ($state) => '#' . substr($state, -5)),
            TextColumn::make('product.code_article')->label('Article')->searchable(),
            TextColumn::make('depot.name')->label('Depot')->searchable(),
            TextColumn::make('quantity')->label('Quantité')->alignCenter(),
            TextColumn::make('status')
                ->badge()
                ->alignCenter()
                ->color(fn (string $state): string => match ($state) {
                    'Draft' => 'gray',
                    'Pending' => 'primary',
                    'Confirmed' => 'warning',
                    'delivered' => 'success',
                    'Cancelled' => 'danger',
                    default => 'secondary',
                }),
        ])->defaultSort('created_at', 'desc')
        ->actions([
            Action::make('confirm')
                ->modalHeading('Confirm Package')
                ->modalDescription('Are you sure you want to confirm this package? This will change its status to Confirmed.')
                ->modalSubmitActionLabel('Yes, Confirm Package')
                ->modalCancelActionLabel('Cancel')
                ->action(function (Package $record) {
                    $record->update([
                        'status' => 'Confirmed',
                        'created_by' => Auth::id(),
                    ]);
                })
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn ($record) => $record->status === 'Draft'),

            Action::make('sticker')
                ->label('QR Code')
                ->icon('heroicon-o-qr-code')
                ->color('gray')
                ->visible(fn ($record) => $record->status === 'Confirmed')
                ->url(fn (Package $record) => route('packages.print-sticker', $record))
                ->openUrlInNewTab(),

            Tables\Actions\EditAction::make()
                ->visible(fn ($record) => $record->status === 'Draft'),
                
            Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => $record->status === 'Draft'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->emptyStateActions([
            Tables\Actions\CreateAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
        ];
    }
}
