<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\PostRepository;
use App\Repositories\VideoRepository;
use App\Repositories\TagRepository;
use App\Repositories\CategoryRepository;

class NavbarComposer
{
    protected $post;
    protected $video;
    protected $tag;
    protected $category;

    public function __construct(PostRepository $post,
                                VideoRepository $video,
                                TagRepository $tag,
                                CategoryRepository $category)
    {
        $this->post = $post;
        $this->video = $video;
        $this->tag = $tag;
        $this->category = $category;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $posts = $this->post->getLatestActivePosts();
        $videos = $this->video->getLatestVideos();
        $tags = $this->tag->countTags(20);
        $categories = $this->category->getAllCategories();

        $view->with('navbarposts', $posts);
        $view->with('navbarvideos', $videos);
        $view->with('counttags', $tags);
        $view->with('categories', $categories);
    }
}
