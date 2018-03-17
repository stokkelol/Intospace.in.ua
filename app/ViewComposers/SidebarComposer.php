<?php
declare(strict_types=1);

namespace App\ViewComposers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Contracts\View\View;
use App\Support\Queries\CountTags;

/**
 * Class SidebarComposer
 *
 * @package App\ViewComposers
 */
class SidebarComposer
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @var Video
     */
    protected $video;

    /**
     * @var Tag
     */
    protected $tag;

    /**
     * SidebarComposer constructor.
     *
     * @param Post $post
     * @param Video $video
     * @param Tag $tag
     */
    public function __construct(Post $post, Video $video, Tag $tag)
    {
        $this->post = $post;
        $this->video = $video;
        $this->tag = $tag;
    }

    /**
     * @param View $view
     */
    public function compose(View $view): void
    {
        $posts = $this->post->latest()->get();
        $videos = $this->video->latest()->get();
        $popularposts = $this->post->popular(10)->get();
        $counttags = (new CountTags())->get($this->tag->count());

        $view->with('latestposts', $posts);
        $view->with('latestvideos', $videos);
        $view->with('counttags', $counttags);
        $view->with('popularposts', $popularposts);
    }
}
