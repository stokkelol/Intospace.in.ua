<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\TagRepositoryInterface;
use App\Repositories\TagRepository;
use App\Repositories\VideoRepositoryInterface;
use App\Repositories\VideoRepository;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class);
    }
}
