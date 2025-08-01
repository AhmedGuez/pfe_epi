<?php
namespace App\Observers;

use App\Models\Package;
use App\Models\StockAdjustment;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentObserver
{
    public function creating(StockAdjustment $adjustment)
    {
        $adjustment->user_id = Auth::id();
    }

    public function created(StockAdjustment $adjustment)
    {
        // Create a package for the adjustment
        $package = Package::create([
            'product_id' => $adjustment->product_id,
            'depot_id' => $adjustment->depot_id,
            'quantity' => $adjustment->quantity,
            'created_by' => Auth::id(),
            'qr_code' => \Illuminate\Support\Str::uuid(),
            'status' => 'adjusted',
        ]);

        // Create stock movement
        StockMovement::create([
            'product_id' => $adjustment->product_id,
            'package_id' => $package->id,
            'depot_id' => $adjustment->depot_id,
            'type' => $adjustment->type === 'addition' ? 'IN' : 'OUT',
            'quantity' => $adjustment->quantity,
            'date' => now(),
        ]);
    }
}