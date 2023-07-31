<?php

namespace Visanduma\NovaLockscreen\Http;

use App\Http\Controllers\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Visanduma\NovaLockscreen\NovaLockscreen;

class LockScreenController extends Controller
{
    public function auth(NovaRequest $request)
    {
        $request->validate([
            'password' => 'required|current_password'
        ]);
        session()->put('nova-lockscreen.last_activity', now());
        session()->put('nova-lockscreen.locked', false);

        return [
            'url' => session()->get('url.intended', Nova::$initialPath)
        ];
    }

    public function check()
    {
        $lastAct = session()->get('nova-lockscreen.last_activity');

        if (!$lastAct) {
            session()->put('nova-lockscreen.last_activity', now());
            $lastAct = now();
        }

        if (now()->diffInMinutes($lastAct) > config('nova-lockscreen.lock_timeout')) {

            $this->executeLock();

            return [
                'locked' => NovaLockscreen::enabled(),
                'url' => '/nova-lockscreen/lock'
            ];
        }

        return response()->json(['locked' => false]);
    }

    public function lockNow()
    {

        return inertia('NovaLockscreen');

    }

    private function executeLock()
    {
        $referer = request()->header('referer');
        $path = parse_url($referer, PHP_URL_PATH) . parse_url($referer, PHP_URL_QUERY);
        $path = str($path)->replace(config('nova.path'), '');

        session()->put('url.intended', $path);
        session()->put('nova-lockscreen.locked', true);
    }

    public function index()
    {
        return inertia('NovaLockscreen');
    }
}
