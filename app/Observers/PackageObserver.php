<?php

namespace App\Observers;

use App\Models\Package;
use App\Models\StockMovement;

class PackageObserver
{
    public function updated(Package $package) {
        if ($package->isDirty('status') && $package->status === 'Confirmed') {
            StockMovement::create([
                'product_id' => $package->product_id,
                'package_id' => $package->id,
                'type' => 'IN',
                'quantity' => $package->quantity,
                'date' => now(),
                'depot_id' => $package->depot_id,
            ]);
        }
    }
}
