<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache key constants
     */
    const CACHE_CLIENTS_KEY = 'clients_list';
    const CACHE_PRODUCTS_KEY = 'products_list';
    const CACHE_USER_PERMISSIONS_KEY = 'user_permissions_';
    const CACHE_DURATION = 3600; // 1 hour

    /**
     * Get cached clients list
     */
    public static function getClients()
    {
        return Cache::remember(self::CACHE_CLIENTS_KEY, self::CACHE_DURATION, function () {
            return Client::select('id', 'nom_entreprise', 'email')
                ->whereNotNull('nom_entreprise')
                ->orderBy('nom_entreprise')
                ->get();
        });
    }

    /**
     * Get cached products list
     */
    public static function getProducts()
    {
        return Cache::remember(self::CACHE_PRODUCTS_KEY, self::CACHE_DURATION, function () {
            return Product::select('id', 'code_article')
                ->whereNotNull('code_article')
                ->orderBy('code_article')
                ->get();
        });
    }

    /**
     * Get cached user permissions
     */
    public static function getUserPermissions($userId)
    {
        $cacheKey = self::CACHE_USER_PERMISSIONS_KEY . $userId;

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($userId) {
            $user = \App\Models\User::find($userId);
            return $user ? $user->getAllPermissions()->pluck('name')->toArray() : [];
        });
    }

    /**
     * Clear all caches
     */
    public static function clearAllCaches()
    {
        Cache::forget(self::CACHE_CLIENTS_KEY);
        Cache::forget(self::CACHE_PRODUCTS_KEY);

        // Clear user permission caches (this is a simple approach)
        Cache::flush(); // In production, you might want to be more selective
    }

    /**
     * Clear specific user cache
     */
    public static function clearUserCache($userId)
    {
        $cacheKey = self::CACHE_USER_PERMISSIONS_KEY . $userId;
        Cache::forget($cacheKey);
    }

    /**
     * Warm up caches (call this during deployment or scheduled tasks)
     */
    public static function warmUpCaches()
    {
        self::getClients();
        self::getProducts();

        // Cache permissions for common users (optional)
        // You could add logic here to cache permissions for recently active users
    }
}