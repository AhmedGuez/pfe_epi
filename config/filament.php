<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    |
    | By uncommenting the Laravel Echo configuration, you may connect Filament
    | to any Pusher-compatible websockets server.
    |
    | This will allow your users to receive real-time notifications.
    |
    */
    

    'broadcasting' => [

        // 'echo' => [
        //     'broadcaster' => 'pusher',
        //     'key' => env('VITE_PUSHER_APP_KEY'),
        //     'cluster' => env('VITE_PUSHER_APP_CLUSTER'),
        //     'wsHost' => env('VITE_PUSHER_WS_HOST'),
        //     'wsPort' => env('VITE_PUSHER_WS_PORT'),
        //     'wssPort' => env('VITE_PUSHER_WSS_PORT'),
        //     'authEndpoint' => '/api/v1/broadcasting/auth',
        //     'disableStats' => true,
        //     'encrypted' => true,
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Filament will use to put media. You may use any
    | of the disks defined in the `config/filesystems.php`.
    |
    */

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Assets Path
    |--------------------------------------------------------------------------
    |
    | This is the directory where Filament's assets will be published to. It
    | is relative to the `public` directory of your Laravel application.
    |
    | After changing the path, you should run `php artisan filament:assets`.
    |
    */

    'assets_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Livewire Loading Delay
    |--------------------------------------------------------------------------
    |
    | This sets the delay before loading indicators appear.
    |
    | Setting this to 'none' makes indicators appear immediately, which can be
    | desirable for high-latency connections. Setting it to 'default' applies
    | Livewire's standard 200ms delay.
    |
    */

    'livewire_loading_delay' => 'none',

    /*
    |--------------------------------------------------------------------------
    | Modal Configuration
    |--------------------------------------------------------------------------
    |
    | Configure modal behavior and performance settings.
    |
    */

    'modal' => [
        'close_button' => true,
        'close_on_click_outside' => true,
        'close_on_escape' => true,
        'persistent' => false,
        'max_width' => '2xl',
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Configure performance-related settings for better user experience.
    |
    */

    'performance' => [
        'enable_loading_states' => true,
        'enable_persistent_loading_states' => false,
        'enable_loading_indicators' => true,
    ],

];
