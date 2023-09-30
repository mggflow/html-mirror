<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Auto reset cache for views in dev environment
if (config('app.env', 'prod') != 'prod') {
    Artisan::call('view:clear');
}


Route::any('reflect', [\App\Http\Controllers\MirrorController::class, 'reflect']);
