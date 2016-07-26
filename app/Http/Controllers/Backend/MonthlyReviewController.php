<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\MonthlyReview;
use App\Repositories\PostRepository;
use App\Repositories\VideoRepository;
use Auth;
use App\Support\Statuses\StatusChanger;

class MonthlyReviewController extends Controller
{
    protected $review;
    protected $post;
    protected $video;

    public function __construct(MonthlyReview $review,
                                PostRepository $post,
                                VideoRepository $video)
    {
        $this->review = $review;
        $this->post = $post;
        $this->video = $video;
    }

    public function index()
    {
        $reviews = $this->review->paginate(10);

        return view('backend.monthlyreviews.index', compact('reviews'));
    }

    public function create()
    {
        $latest_posts = $this->post->getMonthlyPosts();
        $popular_posts = $this->post->getPopularPosts(5);
        $latest_videos = $this->video->getMonthlyVideos();

        $data = [
            'title'             =>  'Create new review',
            'save_url'          =>  route('backend.monthlyreviews.store'),
            'latest_posts'      =>  $latest_posts,
            'popular_posts'     =>  $popular_posts,
            'latest_videos'     =>  $latest_videos
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

    public function update(Request $request)
    {
        $review = $this->storeOrUpdateReview($request, $review_id);
        $review->update();

        return redirect()->back();
    }

    public function storeOrUpdateReview(Request $request, $review_id)
    {
        $review = $this->review->findOrNew($review_id);
        $review->user_id = Auth::user()->id;
        $review->title = $request->input('title');
        $review->content = $request->input('content');
        $review->published_at = $request->input('published_at');
        $review->latest_posts = $this->getItemsForReview($this->post->getMonthlyPosts());
        $review->popular_posts = $this->getItemsForReview($this->post->getPopularPosts(5));
        $review->latest_videos = $this->getItemsForReview($this->video->getMonthlyVideos());

        //dd($review);

        return $review;
    }

    public function toDraft($review_id)
    {
        $changer = new StatusChanger($this->review->find($review_id));
        $changer->setStatus($review_id, 'draft');

        return redirect()->back();
    }

    public function toActive($review_id)
    {
        $changer = new StatusChanger($this->review->find($review_id));
        $changer->setStatus($review_id, 'active');

        return redirect()->back();
    }

    public function getItemsForReview($items)
    {
        $array = [];
        foreach($items as $item)
        {
            $array[] = $item->id;
        }
        return implode(",", $array);
    }
}
