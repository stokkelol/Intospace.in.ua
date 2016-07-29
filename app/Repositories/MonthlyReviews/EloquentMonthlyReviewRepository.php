<?php

namespace App\Repositories\MonthlyReviews;

use App\MonthlyReview;
use App\Repositories\MonthlyReviews\MonthlyReviewRepository;

class EloquentMonthlyReviewRepository implements MonthlyReviewRepository
{
    protected $review;

    public function __construct(MonthlyReview $review)
    {
        $this->review = $review;
    }

    public function getActiveReview()
    {
        return $this->review->where('status', '=', 'active');
    }

    public function getReviewsPopularPosts($review)
    {
        $ids = $review->popular_posts;

        return $this->review->whereIn('id', $ids)->get();
    }
}
