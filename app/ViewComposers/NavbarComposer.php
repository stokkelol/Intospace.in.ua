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
        $post = Post::with('user')->where('status', 'like', 'active')
                                  ->groupBy('published_at')
                                  ->orderBy('published_at', 'desc')
                                  ->take(10)
                                  ->get();
        $video = Video::all()->take(10);
        $view->with('navbarposts', $post);
        $view->with('navbarvideos', $video);
    }
}
