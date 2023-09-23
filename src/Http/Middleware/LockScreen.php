<?php

namespace Lahirulhr\NovaLockScreen\Http\Middleware;

use Lahirulhr\NovaLockScreen\NovaLockScreen;
use Laravel\Nova\Nova;

class LockScreen
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
        if (in_array('/'.$request->path(), $this->excludedUrls())) {

            return $next($request);
        }

        if (NovaLockScreen::locked()) {
            return redirect()->to(NovaLockScreen::url());
        }

        return $next($request);
    }

    private function excludedUrls()
    {
        return NovaLockScreen::excludedUrls();
    }
}
