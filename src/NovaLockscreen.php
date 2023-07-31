<?php

namespace Visanduma\NovaLockscreen;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaLockscreen extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-lockscreen', __DIR__ . '/../dist/js/tool.js');
        Nova::style('nova-lockscreen', __DIR__ . '/../dist/css/tool.css');
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

        return array_merge(config('nova-lockscreen.excluded_urls'), [
            Nova::url('nova-lockscreen'),
            Nova::url('nova-lockscreen/lock'),
            Nova::url('nova-lockscreen/auth'),
            Nova::url('nova-lockscreen/check'),
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
