<?php
declare(strict_types=1);

namespace App\ViewComposers;

use App\Models\MonthlyReview;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Contracts\View\View;

/**
 * Class MonthlyReviewComposer
 *
 * @package App\ViewComposers
 */
class MonthlyReviewComposer
{
    /**
     * @var MonthlyReview
     */
    protected $review;

    /**
     * @var Post
     */
    protected $post;

    /**
     * @var Video
     */
    protected $video;

    /**
     * MonthlyReviewComposer constructor.
     *
     * @param MonthlyReview $review
     * @param Post $post
     * @param Video $video
     */
    public function __construct(MonthlyReview $review, Post $post, Video $video)
    {
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
        $review = $this->review->where('status', '=', 'active')->first();

        if($review !== null) {
            $latest_posts = $this->post->getPostsById($review->latest_posts);
            $popular_posts = $this->post->getPostsById($review->popular_posts);
            $latest_videos = $this->video->getVideosById($review->latest_videos);

            $view->with('review', $review)->with('latest_posts', $latest_posts)
                 ->with('popular_posts', $popular_posts)
                 ->with('latest_videos', $latest_videos);
        }
    }
}
