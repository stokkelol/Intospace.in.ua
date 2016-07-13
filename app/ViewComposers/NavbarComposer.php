<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\VideoRepositoryInterface;

class NavbarComposer
{
    protected $post;
    protected $video;

    public function __construct(PostRepositoryInterface $post, VideoRepositoryInterface $video)
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
