<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\MonthlyReview;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;
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
        $data = [
            'title'             =>  'Create new review',
            'save_url'          =>  route('backend.monthlyreviews.store'),
            'latest_posts'      =>  $this->post->getMonthlyPosts(),
            'popular_posts'     =>  $this->post->getPopularPosts(5),
            'latest_videos'     =>  $this->video->getMonthlyVideos()
        ];

        //dd($data);
        return view('backend.monthlyreviews.create', $data);
    }

    public function store(Request $request, $review_id = null)
    {
        $review = $this->storeOrUpdateReview($request, $review_id = null);

        $review->save();

        return redirect()->route('backend.monthlyreviews.edit', ['review_id' => $review->id]);

        //return redirect()->route('backend.monthlyreviews.edit', ['review_id' => $review->id]);
    }

    public function edit($review_id)
    {
        $review = $this->review->find($review_id);
        $data = [
            'title'             =>  'Edit review',
            'review'            =>  $review,
            'latest_posts'      =>  $this->post->getPostsById($review->latest_posts),
            'popular_posts'     =>  $this->post->getPostsById($review->popular_posts),
            'latest_videos'     =>  $this->video->getVideosById($review->latest_videos)
        ];
        //dd($data);
        return view('backend.monthlyreviews.edit', $data);
    }

    public function update(Request $request, $review_id)
    {
        $review = $this->storeOrUpdateReview($request, $review_id);
        $review->update();

        return redirect()->back() ;
    }

    public function storeOrUpdateReview(Request $request, $review_id)
    {
        $review = $this->review->findOrNew($review_id);
        $review->user_id = Auth::user()->id;
        $review->title = $request->input('title');
        $review->titles = $request->input('titles');
        $review->content = $request->input('content');
        $review->imgs = $request->input('imgs');
        $review->published_at = $request->input('published_at');
        if(empty($review->latest_posts)) {
            $review->latest_posts = $this->getItemsForReview($this->post->getMonthlyPosts());
            $review->popular_posts = $this->getItemsForReview($this->post->getPopularPosts(5));
            $review->latest_videos = $this->getItemsForReview($this->video->getMonthlyVideos());
        }

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
