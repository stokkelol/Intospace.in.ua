<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\VideoRepository;
use DB;

class SidebarComposer
{
    protected $_post;
    protected $_video;
    protected $_tag;

    public function __construct(PostRepository $post,
                                VideoRepository $video,
                                TagRepository $tag)
    {
        $this->_post = $post;
        $this->_video = $video;
        $this->_tag = $tag;
    }

    public function compose(View $view)
    {
        $posts = $this->_post->getLatestActivePosts();
        $videos = $this->_video->getLatestVideos();
        $popularposts = $this->_post->getPopularPosts();
        $counttags = $this->_tag->countTags();

        $view->with('latestposts', $posts);
        $view->with('latestvideos', $videos);
        $view->with('counttags', $counttags);
        $view->with('popularposts', $popularposts);
    }
}
