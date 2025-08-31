<?php

namespace App\Observers;

use App\Models\Client;
use App\Services\CacheService;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     */
    public function created(Client $client): void
    {
        CacheService::clearAllCaches();
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        CacheService::clearAllCaches();
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        CacheService::clearAllCaches();
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        CacheService::clearAllCaches();
    }

    /**
     * Handle the Client "force deleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        CacheService::clearAllCaches();
    }
}