<?php

use Illuminate\Support\Facades\Route;
use Lahirulhr\NovaLockScreen\Http\LockScreenController;
use Lahirulhr\NovaLockScreen\Http\Middleware\LockScreen;

/*
|--------------------------------------------------------------------------
| Tool Routes
|--------------------------------------------------------------------------
|
| Here is where you may register Inertia routes for your tool. These are
| loaded by the ServiceProvider of the tool. The routes are protected
| by your tool's "Authorize" middleware by default. Now - go build!
|
*/

Route::get('lock', [LockScreenController::class,'lock']);

Route::match(['get','post'],'/', [LockScreenController::class,'index'])
    ->withoutMiddleware(LockScreen::class)
    ->name('form');
