<?php

namespace App\Providers;

use Althinect\FilamentSpatieRolesPermissions\Commands\Permission;
use App\Models\Client;
use App\Models\Package;
use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\StockMovement;
use App\Observers\ClientObserver;
use App\Observers\PackageObserver;
use App\Observers\ProductObserver;
use App\Observers\StockAdjustmentObserver;
use App\Observers\StockMovementObserver;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Contracts\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

     public function register(): void
    {
        //
    }

    protected $policies = [
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::registerNavigationGroups([
            'Ressource Humaines' => NavigationGroup::make(fn() => __('Ressource Humaines')),
            'Usine Margoum' => NavigationGroup::make(fn() => __('Usine Margoum')),
            'Usine Tapis' => NavigationGroup::make(fn() => __('Usine Tapis')),
        ]);
Package::observe(PackageObserver::class);
StockAdjustment::observe(StockAdjustmentObserver::class);
Client::observe(ClientObserver::class);
Product::observe(ProductObserver::class);




        
    }
}
