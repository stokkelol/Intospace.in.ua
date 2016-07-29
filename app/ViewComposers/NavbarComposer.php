<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;
use App\Repositories\Tags\TagRepository;
use App\Support\Queries\CountTags;

class NavbarComposer
{
    protected $post;
    protected $video;
    protected $tag;

    public function __construct(PostRepository $post,
                                VideoRepository $video,
                                TagRepository $tag)
    {
        $this->post = $post;
        $this->video = $video;
        $this->tag = $tag;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $posts = $this->post->getLatestActivePosts();
        $videos = $this->video->getLatestVideos()->get();
        $tags = (new CountTags)->get(20);

        $view->with('navbarposts', $posts);
        $view->with('navbarvideos', $videos);
        $view->with('counttags', $tags);
    }
}
