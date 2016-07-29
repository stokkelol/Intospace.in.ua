<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\MonthlyReviewRepository;
use App\Repositories\PostRepository;
use App\Repositories\VideoRepository;

class MonthlyReviewComposer
{
    protected $review;
    protected $post;
    protected $video;

    public function __construct(MonthlyReviewRepository $review,
                                PostRepository $post,
                                VideoRepository $video)
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
        $review        = $this->review->getActiveReview()->first();

        $view->with('review', $review);
    }
}
