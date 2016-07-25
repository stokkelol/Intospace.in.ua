<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\MonthlyReview;
use App\Repositories\PostRepository;
use Auth;

class MonthlyReviewController extends Controller
{
    protected $review;
    protected $post;

    public function __construct(MonthlyReview $review, PostRepository $post)
    {
        $this->review = $review;
        $this->post = $post;
    }

    public function index()
    {
        $reviews = $this->review->paginate(10);

        return view('backend.monthlyreviews.index', compact('reviews'));
    }

    public function create()
    {
        $data = [
            'title'             =>  'Create new review',
            'save_url'          =>  route('backend.monthlyreviews.store'),
            'latest_posts'      =>  $this->post->getMonthlyPosts(),
            'popular_posts'     =>  $this->post->getPopularPosts(5)
        ];
        return view('backend.monthlyreviews.create', $data);
    }

    public function store(Request $request, $review_id = null)
    {
        $review = $this->storeOrUpdateReview($request, $review_id = null);

        $review->save();

        return redirect()->back();

        //return redirect()->route('backend.monthlyreviews.edit', ['review_id' => $review->id]);
    }

    public function update()
    {

    }

    public function storeOrUpdateReview(Request $request, $review_id)
    {
        $review = $this->review->findOrNew($review_id);
        $review->user_id = Auth::user()->id;
        $review->title = $request->input('title');
        $review->content = $request->input('content');
        $review->published_at = $request->input('published_at');

        return $review;
    }
}
