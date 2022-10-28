<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Visanduma\NovaLockscreen\Http\Middleware\Padlock;

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

Route::get('lock',function(){
    return inertia('NovaLockscreen');
});


Route::get('/', function () {

    return inertia('NovaLockscreen');

});


Route::post('auth',function(NovaRequest $request){

    $request->validate([
        'password' => 'required|current_password'
    ]);

    session()->put('nova-lockscreen.last_activity', now());

    session()->put('nova-lockscreen.locked', false);


    return [
        'url' => session()->get('url.intended','/nova')
    ];

});


Route::get('check', function () {

    $lastAct = session()->get('nova-lockscreen.last_activity', now());

    if (now()->diffInSeconds($lastAct) > config('nova-lockscreen.lock-timeout')) {

        session()->put('url.intended', request()->header('referer'));
        session()->put('nova-lockscreen.locked', true);

        return [
        'url' => "/nova-lockscreen/lock"
    ];

    return response()->json([],422);

    }
});
