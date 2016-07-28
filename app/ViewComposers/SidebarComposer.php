<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\VideoRepository;
use DB;
use App\Support\Queries\CountTags;

class SidebarComposer
{
    protected $post;
    protected $video;
    protected $tag;
    protected $tags;

    public function __construct(PostRepository $post,
                                VideoRepository $video,
                                TagRepository $tag,
                                CountTags $tags)
    {
        $this->post = $post;
        $this->video = $video;
        $this->tag = $tag;
        $this->tags = $tags;
    }

    public function compose(View $view)
    {
        $posts = $this->post->getLatestActivePosts();
        $videos = $this->video->getLatestVideos()->get();
        $popularposts = $this->post->getPopularPosts(10);
        //$counttags = ($this->_tag->countTags(null));
        $counttags = $this->tags->get(null);

        $view->with('latestposts', $posts);
        $view->with('latestvideos', $videos);
        $view->with('counttags', $counttags);
        $view->with('popularposts', $popularposts);
    }
}
