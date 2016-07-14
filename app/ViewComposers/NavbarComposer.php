<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;
use App\Repositories\VideoRepository;

class NavbarComposer
{
    protected $post;
    protected $video;

    public function __construct(PostRepository $post, VideoRepository $video)
    {
        $this->post = $post;
        $this->video = $video;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $post = $this->post->getLatestActivePosts();
        $video = $this->video->getLatestVideos();

        $view->with('navbarposts', $post);
        $view->with('navbarvideos', $video);
    }
}
