<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Post;
use App\Tag;
use App\Video;
use DB;

class SidebarComposer
{
    protected $_post;
    protected $_video;
    protected $_tag;

    public function __construct(Post $post, Video $video, Tag $tag)
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
