<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
