<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Post;
use Auth;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('app_name', 'http://www.intospace.in.ua');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
