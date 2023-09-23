<?php

namespace Lahirulhr\NovaLockScreen\Http;

use Lahirulhr\NovaLockScreen\NovaLockScreen;
use Laravel\Nova\Nova;

class LockScreenController
{
    public function lock()
    {
        $this->executeLock();

        return [
            'locked' => NovaLockScreen::enabled(),
            'url' => NovaLockScreen::url(),
        ];

    }

    private function executeLock()
    {
        $referer = request()->header('referer');
        $path = parse_url($referer, PHP_URL_PATH).parse_url($referer, PHP_URL_QUERY);
        $path = str($path)->replaceFirst(config('nova.path'), '');

        session()->put('url.intended', Nova::url($path));
        session()->put('nova-lock-screen.locked', true);
        session()->put('nova-lock-screen.last_activity', now());

    }

    public function index()
    {

        if (request()->isMethod('get')) {
            return view('nova-lock-screen::lock', [
                'bg' => NovaLockScreen::getBackgroundImage(),
                'username' => ucfirst(Nova::user()->name),
                'logout' => Nova::url('logout'),
            ]);
        }

        request()->validate([
            'password' => 'required|current_password',
        ]);
        session()->put('nova-lock-screen.last_activity', now());
        session()->put('nova-lock-screen.locked', false);

        return redirect(session()->get('url.intended', Nova::$initialPath));

    }
}
