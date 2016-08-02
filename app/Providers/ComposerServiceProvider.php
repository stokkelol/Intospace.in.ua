<?php

namespace App\Providers;

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
        $view->composer('frontend.partials.navbar', \App\ViewComposers\NavbarComposer::class);
        $view->composer('frontend.sidebar.sidebar', \App\ViewComposers\SidebarComposer::class);
        $view->composer('frontend.partials.footer', \App\ViewComposers\FooterComposer::class);
        $view->composer('frontend.partials.tagline', \App\ViewComposers\TaglineComposer::class);
        $view->composer('frontend.partials.review_short', \App\ViewComposers\MonthlyReviewComposer::class);
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
