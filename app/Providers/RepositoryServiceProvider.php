<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Posts\EloquentPostRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Tags\EloquentTagRepository;
use App\Repositories\Videos\VideoRepository;
use App\Repositories\Videos\EloquentVideoRepository;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\EloquentCategoryRepository;
use App\Repositories\Bands\BandRepository;
use App\Repositories\Bands\EloquentBandRepository;
use App\Repositories\Users\UserRepository;
use App\Repositories\Users\EloquentUserRepository;
use App\Repositories\MonthlyReviews\MonthlyReviewRepository;
use App\Repositories\MonthlyReviews\EloquentMonthlyReviewRepository;

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
