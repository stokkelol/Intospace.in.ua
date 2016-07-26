<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PostRepository;
use App\Repositories\EloquentPostRepository;
use App\Repositories\TagRepository;
use App\Repositories\EloquentTagRepository;
use App\Repositories\VideoRepository;
use App\Repositories\EloquentVideoRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\EloquentCategoryRepository;
use App\Repositories\BandRepository;
use App\Repositories\EloquentBandRepository;
use App\Repositories\UserRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\MonthlyReviewRepository;
use App\Repositories\EloquentMonthlyReviewRepository;

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
        $this->app->bind(PostRepository::class, EloquentPostRepository::class);
        $this->app->bind(TagRepository::class, EloquentTagRepository::class);
        $this->app->bind(VideoRepository::class, EloquentVideoRepository::class);
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(BandRepository::class, EloquentBandRepository::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(MonthlyReviewRepository::class, EloquentMonthlyReviewRepository::class);
    }
}
