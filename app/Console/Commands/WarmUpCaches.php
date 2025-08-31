<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;

class WarmUpCaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warmup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up application caches for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Warming up application caches...');

        $startTime = microtime(true);

        // Warm up caches
        CacheService::warmUpCaches();

        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);

        $this->info("✅ Cache warmup completed in {$duration} seconds");
        $this->info('Application caches are now ready for optimal performance!');
    }
}