<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Post;
use App\Video;

class NavbarComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $post = Post::all()->take(10);
        $video = Video::all()->take(10);
        $view->with('navbarposts', $post);
        $view->with('navbarvideos', $video);
    }
}