<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockBalance extends Model
{
    protected $fillable = ['product_id', 'depot_id', 'quantity'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function depot(): BelongsTo
    {
        return $this->belongsTo(Depot::class);
    }

    public static function currentBalance($productId, $depotId = null)
{
    return self::where('product_id', $productId)
        ->where('depot_id', $depotId)
        ->value('quantity') ?? 0;
}
}