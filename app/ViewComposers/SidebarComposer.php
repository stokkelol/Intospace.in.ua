<?php
declare(strict_types=1);

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Videos\VideoRepository;
use DB;
use App\Support\Queries\CountTags;

/**
 * Class SidebarComposer
 *
 * @package App\ViewComposers
 */
class SidebarComposer
{
    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * @var VideoRepository
     */
    protected $video;

    /**
     * @var TagRepository
     */
    protected $tag;

    /**
     * @var CountTags
     */
    protected $tags;

    /**
     * SidebarComposer constructor.
     *
     * @param PostRepository $post
     * @param VideoRepository $video
     * @param TagRepository $tag
     * @param CountTags $tags
     */
    public function __construct(
        PostRepository $post,
        VideoRepository $video,
        TagRepository $tag,
        CountTags $tags
    ) {
        $this->post = $post;
        $this->video = $video;
        $this->tag = $tag;
        $this->tags = $tags;
    }

    /**
     * @param View $view
     */
    public function compose(View $view): void
    {
        $posts = $this->post->getLatestActivePosts();
        $videos = $this->video->getLatestVideos()->get();
        $popularposts = $this->post->getPopularPosts(10);
        $counttags = $this->tags->get(null);

        $view->with('latestposts', $posts);
        $view->with('latestvideos', $videos);
        $view->with('counttags', $counttags);
        $view->with('popularposts', $popularposts);
    }
}
