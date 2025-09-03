<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
     /*   if(config('app.env') == 'local') {
            $this->app['request']->server->set('HTTPS', true);
    }
            */
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          View::composer(['layouts.navigation', 'profile.partials.perfil-image-form'], function ($view) {
        $view->with('authUser', Auth::user());
    });

    if (config('app.env') !== 'local') {
        URL::forceScheme('https');
    }
        
    }
}
