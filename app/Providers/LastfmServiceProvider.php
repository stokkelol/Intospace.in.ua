<?php
declare(strict_types=1);

namespace App\Providers;

use App\ApiConnection\Connection;
use App\ApiConnection\Interfaces\Connector as ConnectionContract;
use App\Bot\Lastfm\Lastfm;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Support\ServiceProvider;

/**
 * Class LastfmServiceProvider
 *
 * @package App\Providers
 */
class LastfmServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(Lastfm::class, function () {
            return new Lastfm(new Connection());
        });
    }
}
