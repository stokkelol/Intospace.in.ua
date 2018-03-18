<?php
declare(strict_types=1);

namespace App\Providers;

use App\ApiConnection\Connection;
use App\Bot\Musicbrainz\Musicbrainz;
use Illuminate\Support\ServiceProvider;

/**
 * Class MusicbrainzServiceProvider
 *
 * @package App\Providers
 */
class MusicbrainzServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Musicbrainz::class, function () {
            return new Musicbrainz(new Connection());
        });
    }
}
