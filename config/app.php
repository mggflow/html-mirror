<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'name' => env('APP_NAME', 'MSVC'),

    'env' => env('APP_ENV', 'prod'),

    'debug' => (bool)env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    'timezone' => env('TIMEZONE', 'UTC'),

    'locale' => 'en',

    'fallback_locale' => 'en',

    'faker_locale' => 'en_US',

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'root_prefix' => env('ROOT_PREFIX', ''),

    'max_requests_per_minute' => env('MAX_REQUESTS_PER_MINUTE', 128),

    'msvc_access_table_name' => env('MSVC_ACCESS_TABLE', 'access'),

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    'selenium_uri' => env('SELENIUM_SERVER_URI', 'http://selenium:4444'),
    'parsing_wait_time' => env('PARSER_SLEEP_TIME', 11),
    'chrome_data_dir' => env('CHROME_DATA_DIR', '/external/chrome/data'),
    'disable_dev_shm_usage' => env('DISABLE_DEV_SHM_USAGE', false),


    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),


    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
    ])->toArray(),

];
