<?php

namespace App\Providers;

use App\ViewComposers\FooterComposer;
use App\ViewComposers\MonthlyReviewComposer;
use App\ViewComposers\NavbarComposer;
use App\ViewComposers\SidebarComposer;
use App\ViewComposers\TaglineComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
        $view->composer('frontend.partials.navbar', NavbarComposer::class);
        $view->composer('frontend.sidebar.sidebar', SidebarComposer::class);
        $view->composer('frontend.partials.footer', FooterComposer::class);
        $view->composer('frontend.partials.tagline', TaglineComposer::class);
        $view->composer('frontend.partials.review_short', MonthlyReviewComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
