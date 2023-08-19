<?php

namespace Lahirulhr\NovaLockScreen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Lahirulhr\NovaLockScreen\Http\Middleware\Authorize;

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
            __DIR__ . '/../config/nova-lock-screen.php' => config_path('nova-lock-screen.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/nova-lock-screen'),
        ], 'nova-lock-screen');


        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-lock-screen');

        Nova::serving(function (ServingNova $event) {
            Nova::provideToScript([
                'nls' => [
                    'lock_timeout' => config('nova-lock-screen.lock_timeout') * 1000,
                    'lock_url' => Nova::url('nova-lock-screen/lock')
                ]
            ]);
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

        Nova::router(['nova', Authenticate::class, Authorize::class], 'nova-lock-screen')
            ->group(__DIR__ . '/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-lock-screen')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__ . '/../config/nova-lock-screen.php', 'nova-lock-screen');
    }
}
