<?php

namespace Visanduma\NovaLockscreen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Visanduma\NovaLockscreen\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });


        $this->publishes([
            __DIR__ . '/../config/nova-locakscreen.php' => config_path('nova-locakscreen.php'),
        ], 'nova-lockscreen.config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-lockscreen');

        Nova::serving(function (ServingNova $event) {
            Nova::provideToScript([
                'nls' => [
                    'enabled' => config('nova-lockscreen.enabled'),
                    'polling_timeout' => config('nova-lockscreen.polling_timeout'),
                    'background_image' => NovaLockscreen::getBackgroundImage(),
                    'excluded_urls' => NovaLockscreen::excludedUrls(),
                    'polling_url' => Nova::url('nova-lockscreen/check'),
                ]
            ]);
        });


        Nova::userMenu(function (Request $request, Menu $menu) {
            $menu->append(
                MenuItem::make('Lock', route('nova-lockscreen.lock'))
            );
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authenticate::class, Authorize::class], 'nova-lockscreen')
            ->group(__DIR__ . '/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-lockscreen')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__ . '/../config/nova-lockscreen.php', 'nova-lockscreen');
    }
}
