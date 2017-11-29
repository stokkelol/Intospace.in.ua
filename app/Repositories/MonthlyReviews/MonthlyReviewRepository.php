<?php

namespace App\Repositories\MonthlyReviews;

use App\Models\MonthlyReview;

class MonthlyReviewRepository
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

    public function getAllReviews()
    {
        return $this->review->get();
    }

    public function getReviewBySlug($slug)
    {
        $review = $this->review->where('slug', '=', $slug)->first();

        return $review;
    }
}
