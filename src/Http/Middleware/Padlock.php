<?php

namespace Lahirulhr\NovaLockScreen\Http\Middleware;

use Laravel\Nova\Nova;
use Lahirulhr\NovaLockScreen\NovaLockScreen;

class Padlock
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request):mixed  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        // return $next($request) ;
        if (!config('nova-lock-screen.enabled')) {
            return $next($request);
        }

        if (NovaLockScreen::enabled()) {
            return $next($request);
        }

        if (in_array("/" . $request->path(), $this->excludedUrls())) {
            return $next($request);
        }

        if (session()->get('nova-lock-screen.locked')) {

            return redirect(Nova::url('nova-lock-screen/lock'));
        }

        session()->put('nova-lock-screen.last_activity', now());

        return $next($request);
    }

    private function excludedUrls()
    {
        return NovaLockScreen::excludedUrls();
    }
}
