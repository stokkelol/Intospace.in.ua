<?php

namespace App\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\MonthlyReviewRepository;

class MonthlyReviewComposer
{
    protected $review;

    public function __construct(MonthlyReviewRepository $review)
    {
        $this->review = $review;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $review = $this->review->getActiveReview()->first();

        $view->with('review', $review);
    }
}
