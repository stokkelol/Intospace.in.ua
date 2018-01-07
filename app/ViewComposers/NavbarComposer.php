<?php
declare(strict_types=1);

namespace App\ViewComposers;

use App\Repositories\MonthlyReviews\MonthlyReviewRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Videos\VideoRepository;
use App\Support\Queries\CountTags;
use Illuminate\Contracts\View\View;

/**
 * Class NavbarComposer
 *
 * @package App\ViewComposers
 */
class NavbarComposer
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
     * @var MonthlyReviewRepository
     */
    protected $review;

    /**
     * NavbarComposer constructor.
     *
     * @param PostRepository $post
     * @param VideoRepository $video
     * @param TagRepository $tag
     * @param MonthlyReviewRepository $review
     */
    public function __construct(
        PostRepository $post,
        VideoRepository $video,
        TagRepository $tag,
        MonthlyReviewRepository $review
    ) {
        $this->post = $post;
        $this->video = $video;
        $this->tag = $tag;
        $this->review = $review;
    }

    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $posts = $this->post->getLatestActivePosts();
        $videos = $this->video->getLatestVideos()->get();
        $tags = (new CountTags)->get(20);
        $reviews = $this->review->getAllReviews();

        $view->with('navbarposts', $posts);
        $view->with('navbarvideos', $videos);
        $view->with('counttags', $tags);
        $view->with('reviews', $reviews);
    }
}
