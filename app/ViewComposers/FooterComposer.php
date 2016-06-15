<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Category;
use App\Tag;
use App\Post;

class FooterComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $randompost = Post::all()->whereIn('status', ['active'])->random(1);

        $view->with('randompost', $randompost);
    }
}