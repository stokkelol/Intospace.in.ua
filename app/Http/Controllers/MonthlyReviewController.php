<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\MonthlyReviews\MonthlyReviewRepository;
use App\Http\Requests;
use App\Support\Presenters\ReviewPresenter;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;

/**
 * Class MonthlyReviewController
 *
 * @package App\Http\Controllers
 */
class MonthlyReviewController extends Controller
{
    protected $review;
    protected $post;
    protected $video;

    /**
     * MonthlyReviewController constructor.
     * @param MonthlyReviewRepository $review
     * @param PostRepository $post
     * @param VideoRepository $video
     */
    public function __construct(MonthlyReviewRepository $review,
                                PostRepository $post,
                                VideoRepository $video)
    {
        $this->review = $review;
        $this->post = $post;
        $this->video = $video;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $reviews = $this->review->getAllReviews();

        //dd($reviews);
        return view('frontend.monthlyreviews.index', compact('reviews'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $review = $this->review->getReviewBySlug($slug);
        $titlesArray = explode(';', $review->titles);
        $contentsArray = explode(';', $review->content);
        $imgsArray = explode(';', $review->imgs);
        $presenter = new ReviewPresenter($titlesArray, $contentsArray, $imgsArray);
        $presenter->merge();

        $latest_posts  = $this->post->getPostsById($review->latest_posts);
        $popular_posts = $this->post->getPostsById($review->popular_posts);
        $latest_videos = $this->video->getVideosById($review->latest_videos);

        $data = [
            'review'    =>  $review,
            'presenter' =>  $presenter,
            'counter'   =>  count($contentsArray),
            'latest_posts'  =>  $latest_posts,
            'latest_videos' =>  $latest_videos,
            'popular_posts' =>  $popular_posts
        ];

        return view('frontend.monthlyreviews.show', $data);
    }
}
