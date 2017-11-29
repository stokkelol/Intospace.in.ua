<?php
declare(strict_types=1);

namespace App\Repositories\MonthlyReviews;

use App\Models\MonthlyReview;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class MonthlyReviewRepository
 *
 * @package App\Repositories\MonthlyReviews
 */
class MonthlyReviewRepository
{
    /**
     * @var MonthlyReview
     */
    protected $review;

    /**
     * MonthlyReviewRepository constructor.
     * @param MonthlyReview $review
     */
    public function __construct(MonthlyReview $review)
    {
        $this->review = $review;
    }

    /**
     * @return Builder
     */
    public function getActiveReview(): Builder
    {
        return $this->review->where('status', '=', 'active');
    }

    /**
     * @param $review
     * @return Collection
     */
    public function getReviewsPopularPosts($review): Collection
    {
        return $this->review->whereIn('id', $review->popular_posts)->get();
    }

    /**
     * @return mixed
     */
    public function getAllReviews(): Collection
    {
        return $this->review->get();
    }

    /**
     * @param $slug
     * @return MonthlyReview
     */
    public function getReviewBySlug($slug): MonthlyReview
    {
        return $this->review->where('slug', '=', $slug)->first();
    }
}
