<?php

namespace Lahirulhr\NovaLockScreen\Http\Middleware;

use Laravel\Nova\Nova;
use Lahirulhr\NovaLockScreen\NovaLockScreen;

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
         if (in_array("/" . $request->path(), $this->excludedUrls())) {
            return $next($request);
        }
        
        if (NovaLockScreen::locked()) { 
            return redirect()->to(Nova::url('nova-lock-screen'));
        }

        return $next($request);
    }

    private function excludedUrls()
    {
        return NovaLockScreen::excludedUrls();
    }
}
