<?php
declare(strict_types=1);

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\MonthlyReviews\MonthlyReviewRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;

/**
 * Class MonthlyReviewComposer
 *
 * @package App\ViewComposers
 */
class MonthlyReviewComposer
{
    /**
     * @var MonthlyReviewRepository
     */
    protected $review;

    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * @var VideoRepository
     */
    protected $video;

    /**
     * MonthlyReviewComposer constructor.
     *
     * @param MonthlyReviewRepository $review
     * @param PostRepository $post
     * @param VideoRepository $video
     */
    public function __construct(
        MonthlyReviewRepository $review,
        PostRepository $post,
        VideoRepository $video
    ) {
        $this->review = $review;
        $this->post = $post;
        $this->video = $video;
    }

    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        if(!empty($this->review->getActiveReview()->first())) {
            $review = $this->review->getActiveReview()->first();
            $latest_posts = $this->post->getPostsById($review->latest_posts);
            $popular_posts = $this->post->getPostsById($review->popular_posts);
            $latest_videos = $this->video->getVideosById($review->latest_videos);

            $view->with('review', $review)->with('latest_posts', $latest_posts)
                 ->with('popular_posts', $popular_posts)
                 ->with('latest_videos', $latest_videos);
        }
    }
}
