<?php
namespace App\Console\Commands;

use App\Models\Package;
use App\Models\StockBalance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitializeStockBalances extends Command
{
    protected $signature = 'inventory:init-balances';
    protected $description = 'Initialize stock balances from existing packages';

    public function handle()
    {
        $confirmedPackages = Package::where('status', 'Confirmed')->get();

        foreach ($confirmedPackages as $package) {
            StockBalance::updateOrCreate(
                ['product_id' => $package->product_id, 'depot_id' => $package->depot_id],
                ['quantity' => DB::raw("quantity + {$package->quantity}")]
            );
        }

        $this->info('Stock balances initialized successfully!');
    }
}