<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MonthlyReview;
use App\Models\Post;
use App\Models\Video;
use App\Support\Presenters\ReviewPresenter;
use Illuminate\View\View;

/**
 * Class MonthlyReviewController
 *
 * @package App\Http\Controllers
 */
class MonthlyReviewController extends Controller
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
     * MonthlyReviewController constructor.
     * @param MonthlyReview $review
     * @param Post $post
     * @param Video $video
     */
    public function __construct(MonthlyReview $review, Post $post, Video $video) {
        $this->review = $review;
        $this->post = $post;
        $this->video = $video;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(): View
    {
        $reviews = $this->review->getAllReviews();

        return view('frontend.monthlyreviews.index', compact('reviews'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug): View
    {
        $review = $this->review->where('slug', $slug)->first();
        $titlesArray = explode(';', $review->titles);
        $contentsArray = explode(';', $review->content);
        $imgsArray = explode(';', $review->imgs);
        $presenter = new ReviewPresenter($titlesArray, $contentsArray, $imgsArray);
        $presenter->merge();

        $latest_posts  = $this->post->whereIn('id', \explode(',', $review->latest_posts))->get();
        $popular_posts = $this->post->whereIn('id', \explode(',', $review->popular_posts))->get();
        $latest_videos = $this->video->whereIn('id', \explode(',', $review->latest_videos))->get();

        $data = [
            'review' => $review,
            'presenter' => $presenter,
            'counter' => count($contentsArray),
            'latest_posts' => $latest_posts,
            'latest_videos' => $latest_videos,
            'popular_posts' => $popular_posts
        ];

        return view('frontend.monthlyreviews.show', $data);
    }
}
