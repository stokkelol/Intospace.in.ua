<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MonthlyReviews\MonthlyReviewRepository;
use App\Http\Requests;
use App\Support\Presenters\ReviewPresenter;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;

class MonthlyReviewController extends Controller
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

    public function index()
    {
        $reviews = $this->review->getAllReviews();

        //dd($reviews);
        return view('frontend.monthlyreviews.index', compact('reviews'));
    }

    public function show($slug)
    {
        $review = $this->review->getReviewBySlug($slug);
        $titlesArray = explode(';', $review->titles);
        $contentsArray = explode(';', $review->content);
        $imgsArray = explode(';', $review->imgs);
        $presenter = new ReviewPresenter($titlesArray, $contentsArray, $imgsArray);
        $presenter->merge();
        $counter = count($contentsArray);

        $latest_posts  = $this->post->getPostsById($review->latest_posts);
        $popular_posts = $this->post->getPostsById($review->popular_posts);
        $latest_videos = $this->video->getVideosById($review->latest_videos);

        $data = [
            'review'    =>  $review,
            'presenter' =>  $presenter,
            'counter'   =>  $counter,
            'latest_posts'  =>  $latest_posts,
            'latest_videos' =>  $latest_videos,
            'popular_posts' =>  $popular_posts
        ];

        return view('frontend.monthlyreviews.show', $data);
    }
}
