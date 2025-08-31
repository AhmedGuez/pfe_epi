<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use app\Filament\Pages\Dashboard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Purple,
            ])
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\StatsOverviewWidget::class
                // Widgets\FilamentInfoWidget::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->maxContentWidth(MaxWidth::ScreenTwoExtraLarge)
            ->plugins([
                FilamentSpatieRolesPermissionsPlugin::make(),
                FilamentApexChartsPlugin::make(),
                FilamentFullCalendarPlugin::make()
                    ->selectable(true)
                    ->editable(true)
                    ->locale(config('app.locale'))
            ])
            ->sidebarCollapsibleOnDesktop()
            ->brandName('CSP SOLUTIONS')
            ->favicon(asset('assets/logo-black.png'))
            ->brandLogoHeight('4rem');
    }
}
