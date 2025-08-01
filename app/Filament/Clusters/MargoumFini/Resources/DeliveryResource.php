<?php

namespace App\Filament\Clusters\MargoumFini\Resources;

use App\Filament\Clusters\ProduitFini;
use App\Filament\Clusters\MargoumFini\Resources\DeliveryResource\Pages;
use App\Models\Delivery;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Clusters\MargoumFini\Resources\DeliveryResource\Pages\DeliveryPage;
use App\Models\Package;
use App\Models\Product;
use App\Models\StockMovement;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationLabel = "Bons de Livraison (Produits Finis)";
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $cluster = ProduitFini::class;

    // protected static ?string $navigationGroup = 'Margoum Packages';



public static function form(Form $form): Form
{
    return $form->schema([
        Section::make('Delivery Information')
            ->columns(3)
            ->schema([
                Select::make('type')
                    ->label('Delivery Type')
                    ->options([
                        'client' => 'To Client',
                        'transfer' => 'Transfer to Depot',
                        'employee' => 'Employee Purchase',
                    ])
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('client_id', null))
                    ->required()
                    ->columnSpan(1),

                Select::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'nom_entreprise')
                    ->searchable()
                    ->preload()
                    ->visible(fn ($get) => $get('type') === 'client')
                    ->required(fn ($get) => $get('type') === 'client')
                    ->columnSpan(1),

                Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'full_name')
                    ->searchable()
                    ->visible(fn ($get) => $get('type') === 'employee')
                    ->required(fn ($get) => $get('type') === 'employee')
                    ->columnSpan(1),

                Select::make('from_depot_id')
                    ->label('From Depot')
                    ->relationship('fromDepot', 'name')
                    ->required()
                    ->columnSpan(1),

                Select::make('to_depot_id')
                    ->label('To Depot')
                    ->relationship('toDepot', 'name')
                    ->visible(fn ($get) => $get('type') === 'transfer')
                    ->required(fn ($get) => $get('type') === 'transfer')
                    ->columnSpan(1),

                TextInput::make('car_number')
                    ->label('Car Number')
                    ->maxLength(255)
                    ->nullable()
                    ->columnSpan(1),

                DatePicker::make('delivery_date')
                    ->label('Delivery Date')
                    ->required()
                    ->columnSpan(1),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Draft' => 'Draft',
                        'Delivered' => 'Delivered',
                    ])
                    ->default('Draft')
                    ->required()
                    ->columnSpan(1),

                Select::make('delivered_by')
                    ->label('Delivered By')
                    ->relationship('deliveredBy', 'name')
                    ->searchable()
                    ->nullable()
                    ->columnSpan(1),
            ]),

        Section::make('Delivery Items')
            ->description('Scan or select the packages to include in this delivery')
            ->schema([
                Repeater::make('items')
                    ->label('Packages')
                    ->relationship()
                    ->schema([
                        Select::make('package_id')
                            ->label('Package')
                            ->relationship('package', 'qr_code')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (!$state) {
                                    $set('product_id', null);
                                    $set('quantity', null);
                                    return;
                                }

                                $package = Package::find($state);
                                if ($package) {
                                    $set('product_id', $package->product_id);
                                    $set('quantity', $package->quantity);
                                }
                            }),

                        Select::make('product_id')
                            ->label('Product')
                            ->relationship('product', 'code_article')
                            ->disabled()
                            ->required(),

                        TextInput::make('quantity')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->disabled(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]),
    ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('bnl_number')->label('BNL-N°')->sortable()->alignCenter()->searchable(),
            TextColumn::make('type')
                ->badge()
                ->searchable()
                ->formatStateUsing(fn ($state) => match ($state) {
                    'client' => 'Client',
                    'transfer' => 'Transfer',
                    'employee' => 'Employee',
                })
                ->color(fn (string $state): string => match ($state) {
                    'client' => 'primary',
                    'transfer' => 'warning',
                    'employee' => 'success',
                })
                ->alignCenter(),

            TextColumn::make('client.nom_entreprise')
                ->label('Client')
                ->getStateUsing(fn ($record) => $record->type === 'client' ? $record->client?->nom_entreprise : null)
                ->wrap()
                ->searchable()
                ->alignCenter(),

            TextColumn::make('employee.full_name')
                ->label('Employee')
                ->wrap()
                ->searchable()
                ->alignCenter()
                ->getStateUsing(fn ($record) => $record->type === 'employee' ? $record->employee?->full_name : null)
                ->alignCenter(),

            TextColumn::make('fromDepot.name')
                ->label('From Depot')
                ->wrap()
                ->searchable()
                ->placeholder('N/A')
                ->alignCenter(),

            TextColumn::make('toDepot.name')
                ->label('To Depot')
                ->getStateUsing(fn ($record) => $record->type === 'transfer' ? $record->toDepot?->name : null)
                ->placeholder('N/A')
                ->wrap()
                ->alignCenter(),

            TextColumn::make('car_number')->alignCenter()->wrap(),
            TextColumn::make('delivery_date')->date()->alignCenter()->wrap()->searchable(),

            TextColumn::make('status')
                ->badge()
                ->alignCenter()
                ->color(fn (string $state): string => match ($state) {
                    'Draft' => 'gray',
                    'Confirmed' => 'primary',
                    'Delivered' => 'success',
                    default => 'secondary',
                }),

            // TextColumn::make('created_at')->since()->alignCenter(),
        ])->defaultSort('created_at', 'desc')
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make()
                ->visible(fn ($record) => $record->status === 'Draft')
                ->label(''),
            Action::make('confirm')
                ->label('')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn ($record) => $record->status === 'Draft')
                ->action(function (Delivery $record) {
                    if ($record->status === 'Delivered') {
                        Notification::make()
                            ->danger()
                            ->title('Already Delivered')
                            ->send();
                        return;
                    }

                    $record->update([
                        'status' => 'Delivered',
                        'delivered_by' => auth()->id(),
                    ]);

                    foreach ($record->items as $item) {
                        if (in_array($record->type, ['client', 'employee'])) {
                            // OUT movement
                            StockMovement::create([
                                'product_id' => $item->product_id,
                                'package_id' => $item->package_id,
                                'delivery_id' => $record->id,
                                'depot_id' => $record->from_depot_id,
                                'type' => 'OUT',
                                'quantity' => $item->quantity,
                                'date' => now(),
                                // 'performed_by' => auth()->id(),
                            ]);

                            // Remove package from depot
                            $item->package->update(['depot_id' => null]);
                        } elseif ($record->type === 'transfer') {
                              StockMovement::create([
                                'product_id' => $item->product_id,
                                'package_id' => $item->package_id,
                                'delivery_id' => $record->id,
                                'depot_id' => $record->from_depot_id,
                                'type' => 'OUT',
                                'quantity' => $item->quantity,
                                'date' => now(),
                                // 'performed_by' => auth()->id(),
                            ]);

                            StockMovement::create([
                                'product_id' => $item->product_id,
                                'package_id' => $item->package_id,
                                'delivery_id' => $record->id,
                                'depot_id' => $record->to_depot_id,
                                'type' => 'IN',
                                'quantity' => $item->quantity,
                                'date' => now(),
                                // 'performed_by' => auth()->id(),
                            ]);

                            $item->package->update(['depot_id' => $record->to_depot_id]);
                        }
                    }

                    Notification::make()
                        ->success()
                        ->title('Delivery Confirmed')
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Confirm Delivery')
                ->modalDescription('Are you sure you want to confirm this delivery? This will update the inventory.')
                ->modalSubmitActionLabel('Yes, confirm'),

            // Tables\Actions\ViewAction::make()->label(''),
            

            Action::make('print')
                ->label('')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->url(fn (Delivery $record) => route('delivery.print', $record))
                ->openUrlInNewTab(),

            Tables\Actions\DeleteAction::make()->label('')
            ->visible(fn ($record) => $record->status === 'Draft'),
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDeliveryPage::route('/{record}/edit'),
            'deliverypage'=>DeliveryPage::route('/deliverypage'),
            'check-package' => Pages\CheckPackage::route('/check-package'),

        ];
    }
}
