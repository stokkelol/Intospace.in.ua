<?php
declare(strict_types=1);

namespace App\Providers;

use App\ViewComposers\FooterComposer;
use App\ViewComposers\MonthlyReviewComposer;
use App\ViewComposers\NavbarComposer;
use App\ViewComposers\SidebarComposer;
use App\ViewComposers\TaglineComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * Class ComposerServiceProvider
 *
 * @package App\Providers
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ViewFactory $view): void
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
    public function register(): void
    {
        //
    }
}
