<?php

namespace App\Filament\Clusters\MargoumFini\Resources;

use App\Filament\Clusters\ProduitFini;
use App\Filament\Clusters\MargoumFini\Resources\StockResource\Pages;
use App\Models\Depot;
use App\Models\Product;
use App\Models\StockMovement;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class StockResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationLabel = "Stock Produits Finis";
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $cluster = ProduitFini::class;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
{
    $depots = Depot::all();

    $columns = [
        TextColumn::make('code_article')
            ->label('Code Article')
            ->searchable()
            ->sortable()
            ->alignCenter(),
    ];

    // Add dynamic columns for each depot
    foreach ($depots as $depot) {
        $columns[] = TextColumn::make("depot_{$depot->id}")
            ->label($depot->name)
            ->alignCenter()
            ->getStateUsing(function (Product $record) use ($depot) {
                return static::getStockForProductAndDepot($record->id, $depot->id);
            });
    }

    // Add total stock column
    $columns[] = TextColumn::make('total_stock')
        ->label('Total Stock')
        ->alignCenter()
        ->getStateUsing(function (Product $record) {
            return static::getTotalStockForProduct($record->id);
        })
        ->color('primary')
        ->weight('bold');

    return $table
        ->columns($columns)
        ->query(
            Product::query()->whereIn('id', function ($query) {
                $query->select('product_id')
                    ->from('stock_movements')
                    ->groupBy('product_id')
                    ->havingRaw('SUM(CASE WHEN type = "IN" THEN quantity ELSE -quantity END) > 0');
            })
        )
        ->filters([
            Tables\Filters\SelectFilter::make('depot')
                ->label('Filtrer par dépôt')
                ->options($depots->pluck('name', 'id'))
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value'])) {
                        $depotId = $data['value'];
                        $query->whereHas('stockMovements', function ($q) use ($depotId) {
                            $q->where('depot_id', $depotId);
                        });
                    }
                }),
        ])
        ->paginated(false)
        ->actions([])
        ->bulkActions([]);
}

    protected static function getStockForProductAndDepot($productId, $depotId): int
    {
        $inStock = StockMovement::where('product_id', $productId)
            ->where('depot_id', $depotId)
            ->where('type', 'IN')
            ->sum('quantity');
            
        $outStock = StockMovement::where('product_id', $productId)
            ->where('depot_id', $depotId)
            ->where('type', 'OUT')
            ->sum('quantity');
            
        return $inStock - $outStock;
    }

    protected static function getTotalStockForProduct($productId): int
    {
        $inStock = StockMovement::where('product_id', $productId)
            ->where('type', 'IN')
            ->sum('quantity');
            
        $outStock = StockMovement::where('product_id', $productId)
            ->where('type', 'OUT')
            ->sum('quantity');
            
        return $inStock - $outStock;
    }

    public static function getRelations(): array
    {
        return [
            // Add relation manager for stock movements if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
        ];
    }
}