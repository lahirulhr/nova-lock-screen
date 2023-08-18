<?php

namespace Lahirulhr\NovaLockScreen\Http;

use App\Http\Controllers\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Lahirulhr\NovaLockScreen\NovaLockScreen;

class LockScreenController extends Controller
{
    public function auth(NovaRequest $request)
    {
        $request->validate([
            'password' => 'required|current_password'
        ]);
        session()->put('nova-lock-screen.last_activity', now());
        session()->put('nova-lock-screen.locked', false);

        return [
            'url' => session()->get('url.intended', Nova::$initialPath)
        ];
    }

    public function check()
    {
        $lastAct = session()->get('nova-lock-screen.last_activity');

        if (!$lastAct) {
            session()->put('nova-lock-screen.last_activity', now());
            $lastAct = now();
        }

        if (now()->diffInMinutes($lastAct) > config('nova-lock-screen.lock_timeout')) {

            $this->executeLock();

            return [
                'locked' => NovaLockScreen::enabled(),
                'url' => '/nova-lock-screen/lock'
            ];
        }

        return response()->json(['locked' => false]);
    }

    public function lockNow()
    {

        return inertia('NovaLockScreen');

    }

    private function executeLock()
    {
        $referer = request()->header('referer');
        $path = parse_url($referer, PHP_URL_PATH) . parse_url($referer, PHP_URL_QUERY);
        $path = str($path)->replace(config('nova.path'), '');

        session()->put('url.intended', $path);
        session()->put('nova-lock-screen.locked', true);
    }

    public function index()
    {
        return inertia('NovaLockScreen');
    }
}
