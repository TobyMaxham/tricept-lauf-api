<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if('production' == config('app.env')
            || false !== strpos(request()->getHost(), '.de')
            || false !== strpos(request()->getHost(), '.com')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
