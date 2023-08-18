<?php

namespace Lahirulhr\NovaLockScreen;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
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
        Nova::style('nova-lock-screen', __DIR__ . '/../dist/css/tool.css');
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
        return auth()->check() ? auth()->user()->getLockScreenImage() : null;
    }

    public static function enabled(): bool
    {
        return auth()->check() && auth()->user()->lockScreenEnabled();
    }
}
