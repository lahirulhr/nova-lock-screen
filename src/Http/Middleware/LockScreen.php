<?php

namespace Lahirulhr\NovaLockScreen\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lahirulhr\NovaLockScreen\NovaLockScreen;
use Laravel\Nova\Nova;

class LockScreen
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure(Request):mixed $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array('/' . $request->path(), $this->excludedUrls())) {

            return $next($request);
        }

        if (NovaLockScreen::locked()) {
            return redirect()->to(NovaLockScreen::url());
        }

        return $next($request);
    }

    private function excludedUrls(): array
    {
        return NovaLockScreen::excludedUrls();
    }
}
