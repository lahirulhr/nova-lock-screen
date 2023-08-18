<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Lahirulhr\NovaLockScreen\Http\LockScreenController;
use Lahirulhr\NovaLockScreen\Http\Middleware\Padlock;

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

Route::get('lock',[LockScreenController::class,'lockNow'])->name('lock');
Route::post('auth',[LockScreenController::class,'auth']);
Route::get('check', [LockScreenController::class,'check']);
Route::get('/', [LockScreenController::class,'index'])->name('form');
