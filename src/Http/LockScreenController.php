<?php

namespace Visanduma\NovaLockscreen\Http;

use App\Http\Controllers\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;

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
            'url' => session()->get('url.intended', '/nova')
        ];
    }

    public function check()
    {
        $lastAct = session()->get('nova-lockscreen.last_activity', now());

        if (now()->diffInMinutes($lastAct) > config('nova-lockscreen.lock-timeout')) {
            $this->executeLock();

            return [
                'url' => "/nova-lockscreen/lock"
            ];
        }
        return response()->json(['locked' => false]);
    }

    public function lockNow()
    {
        $this->executeLock();
        return inertia('NovaLockscreen');
    }

    private function executeLock()
    {
        session()->put('url.intended', request()->header('referer'));
        session()->put('nova-lockscreen.locked', true);
    }

    public function index()
    {
        return inertia('NovaLockscreen');
    }
}
