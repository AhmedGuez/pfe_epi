<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearPerformanceCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:performance {--all : Clear all performance caches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear performance-related caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing performance caches...');

        $caches = [
            'depots_list',
            'employees_list',
            'clients_list',
            'categories_list',
        ];

        // Clear stock-related caches
        $stockCaches = Cache::get('stock_cache_keys', []);
        foreach ($stockCaches as $key) {
            Cache::forget($key);
        }

        // Clear specific caches
        foreach ($caches as $cache) {
            Cache::forget($cache);
            $this->line("Cleared: {$cache}");
        }

        // Clear all caches if --all option is used
        if ($this->option('all')) {
            Cache::flush();
            $this->info('All caches cleared!');
        }

        $this->info('Performance caches cleared successfully!');
    }
} 