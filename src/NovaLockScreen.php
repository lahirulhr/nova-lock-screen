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
    public function boot(): void
    {
        Nova::script('nova-lock-screen', __DIR__ . '/../dist/js/tool.js');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param Request $request
     * @return mixed
     */
    public function menu(Request $request): mixed
    {
        return null;
    }

    public static function excludedUrls(): array
    {
        return array_merge(config('nova-lock-screen.excluded_urls'), [
            self::url(),
            self::url('lock'),
            self::url('auth'),
            Nova::url('logout'),
            Nova::url('login'),
        ]);
    }

    public static function setBackgroundImage($url): void
    {
        Nova::provideToScript(['nls' => ['background_image' => $url]]);
    }

    /**
     * @throws Exception
     */
    public static function getBackgroundImage()
    {
        if (!self::user()) {
            return null;
        }

        if (!method_exists(self::user(), 'getLockScreenImage')) {
            throw new Exception('LockScreen trait must be use in user model !');
        }

        return self::user()->getLockScreenImage();
    }

    public static function timeout()
    {
        if (!self::user()) {
            return null;
        }

        return self::user()->getLockScreenTimeout();
    }

    /**
     * @throws Exception
     */
    public static function enabled(): bool
    {
        if (!config('nova-lock-screen.enabled')) {
            return false;
        }

        if (!method_exists(self::user(), 'lockScreenEnabled')) {
            throw new Exception('LockScreen trait must be use in user model !');
        }

        return auth(self::guard())->check() && self::user()->lockScreenEnabled();
    }

    public static function locked(): bool
    {
        return session()->get('nova-lock-screen.locked', false);
    }

    public static function guard()
    {
        return config('nova-lock-screen.guard');
    }

    public static function user()
    {
        return auth(self::guard())->user();
    }

    public static function url($path = '', $pathOnly = false)
    {
        $path = str(config('nova-lock-screen.lock_url', 'nova-lock-screen'))
            ->finish('/')
            ->append($path)
            ->toString();

        return $pathOnly ? $path : Nova::url($path);
    }
}
