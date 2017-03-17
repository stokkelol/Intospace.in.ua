<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\MonthlyReviews\MonthlyReviewRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;

class MonthlyReviewComposer
{
    protected $review;
    protected $post;
    protected $video;

    public function __construct(
        MonthlyReviewRepository $review,
        PostRepository $post,
        VideoRepository $video
    )
    {
        $this->review = $review;
        $this->post = $post;
        $this->video = $video;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        if(!empty($this->review->getActiveReview()->first())) {
            $review        = $this->review->getActiveReview()->first();
            $latest_posts  = $this->post->getPostsById($review->latest_posts);
            $popular_posts = $this->post->getPostsById($review->popular_posts);
            $latest_videos = $this->video->getVideosById($review->latest_videos);

            $view->with('review', $review)->with('latest_posts', $latest_posts)
                ->with('popular_posts', $popular_posts)
                ->with('latest_videos', $latest_videos);
        }
    }
}
