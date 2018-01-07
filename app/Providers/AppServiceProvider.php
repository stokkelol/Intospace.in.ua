<?php
declare(strict_types=1);

namespace App\Providers;

use App\ApiConnection\Connection;
use App\ApiConnection\Interfaces\Connector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        view()->share('app_name', 'http://www.intospace.in.ua');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Connector::class, Connection::class);
    }
}
