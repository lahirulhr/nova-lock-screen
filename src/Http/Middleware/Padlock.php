<?php

namespace Visanduma\NovaLockscreen\Http\Middleware;

use Laravel\Nova\Nova;
use Visanduma\NovaLockscreen\NovaLockscreen;

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
        if ( !config('nova-lockscreen.enabled') || in_array($request->path(), $this->excludedUrls())) {
            return $next($request) ;
        }

        if (session()->get('nova-lockscreen.locked')) {
            return inertia('NovaLockscreen');
        }

        session()->put('nova-lockscreen.last_activity', now());

        return $next($request) ;
    }

    private function excludedUrls()
    {
        return NovaLockscreen::excludedUrls();
    }
}
