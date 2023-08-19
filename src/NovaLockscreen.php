<?php

namespace Lahirulhr\NovaLockScreen;

use Exception;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaLockScreen extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-lock-screen', __DIR__ . '/../dist/js/tool.js');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        return null;
    }

    public static function excludedUrls()
    {

        return array_merge(config('nova-lock-screen.excluded_urls'), [
            Nova::url('nova-lock-screen'),
            Nova::url('nova-lock-screen/lock'),
            Nova::url('nova-lock-screen/auth'),
            Nova::url('nova-lock-screen/check'),
            Nova::url('logout'),
            Nova::url('login'),
        ]);
    }

    public static function setBackgroundImage($url)
    {
        Nova::provideToScript(['nls' => ['background_image' => $url]]);
    }

    public static function getBackgroundImage()
    {
        if(!self::user()){
            return null;
        }
        
        if(!method_exists(self::user(),'getLockScreenImage')){
            throw new Exception('LockScreen trait must be use in user model !');
        }
        return self::user()->getLockScreenImage();
    }

    public static function enabled(): bool
    {

        if(!config('nova-lock-screen.enabled')){
            return false;
        }

        if(!method_exists(self::user(),'lockScreenEnabled')){
            throw new Exception('LockScreen trait must be use in user model !');
        }
        return auth(self::guard())->check() && self::user()->lockScreenEnabled();
    }

    public static function locked():bool
    {
        return session()->get('nova-lock-screen.locked',false);
    }

    public static function guard()
    {
        return config('nova-lock-screen.guard');
    }

    public static function user()
    {
        return auth(self::guard())->user();
    }
}
