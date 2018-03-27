<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MonthlyReview;
use App\Models\Post;
use App\Models\Video;
use App\Support\Images\ImageSaver;
use App\Support\Statuses\StatusChanger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class MonthlyReviewController
 *
 * @package App\Http\Controllers\Backend
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
     *
     * @param MonthlyReview $review
     * @param Post $post
     * @param Video $video
     */
    public function __construct(MonthlyReview $review, Post $post, Video $video)
    {
        $this->review = $review;
        $this->post = $post;
        $this->video = $video;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $reviews = $this->review->paginate(10);

        return view('backend.monthlyreviews.index', compact('reviews'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data = [
            'title' => 'Create new review',
            'save_url' => route('backend.monthlyreviews.store'),
            'latest_posts' => $this->post->getMonthlyPosts(),
            'popular_posts' => $this->post->popular(5)->get(),
            'latest_videos' => $this->video->getMonthlyVideos()
        ];

        return view('backend.monthlyreviews.create', $data);
    }

    /**
     * @param Request $request
     * @param null $review_id
     * @param ImageSaver $imageSaver
     * @return RedirectResponse
     */
    public function store(Request $request, $review_id = null, ImageSaver $imageSaver): RedirectResponse
    {
        $review = $this->storeOrUpdateReview($request, $review_id = null);

        if ($request->hasFile('img')) {
            $imageSaver->saveCover('upload/images/', $request->file('img'));
            $review->img = $request->file('img')->getClientOriginalName();
        }

        $review->save();

        return redirect()->route('backend.monthlyreviews.edit', ['review_id' => $review->id]);
    }

    /**
     * @param $review_id
     * @return View
     */
    public function edit($review_id): View
    {
        $review = $this->review->find($review_id);
        $data = [
            'title' => 'Edit review',
            'review' => $review,
            'latest_posts' => $this->post->getPostsById($review->latest_posts),
            'popular_posts' => $this->post->getPostsById($review->popular_posts),
            'latest_videos' => $this->video->getVideosById($review->latest_videos)
        ];

        return view('backend.monthlyreviews.edit', $data);
    }

    /**
     * @param Request $request
     * @param $review_id
     * @param ImageSaver $imageSaver
     * @return RedirectResponse
     */
    public function update(Request $request, $review_id, ImageSaver $imageSaver): RedirectResponse
    {
        $review = $this->storeOrUpdateReview($request, $review_id);

        if ($request->hasFile('img')) {
            $imageSaver->saveCover('upload/images/', $request->file('img'));
            $review->img = $request->file('img')->getClientOriginalName();
        }

        $review->resluggify();
        $review->update();

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param $review_id
     * @return MonthlyReview
     */
    public function storeOrUpdateReview(Request $request, $review_id): MonthlyReview
    {
        $review = $this->review->findOrNew($review_id);
        $review->user_id = Auth::user()->id;
        $review->title = $request->input('title');
        $review->excerpt = $request->input('excerpt');
        $review->titles = $request->input('titles');
        $review->content = $request->input('content');
        $review->imgs = $request->input('imgs');
        $review->published_at = $request->input('published_at');

        if (empty($review->latest_posts)) {
            $review->latest_posts = $this->getItemsForReview($this->post->getMonthlyPosts());
            $review->popular_posts = $this->getItemsForReview($this->post->popular(5)->get());
            $review->latest_videos = $this->getItemsForReview($this->video->getMonthlyVideos());
        }

        return $review;
    }

    /**
     * @param $review_id
     * @return RedirectResponse
     */
    public function toDraft($review_id): RedirectResponse
    {
        $changer = new StatusChanger($this->review->find($review_id));
        $changer->setStatus($review_id, 'draft');

        return redirect()->back();
    }

    /**
     * @param $review_id
     * @return RedirectResponse
     */
    public function toActive($review_id): RedirectResponse
    {
        $changer = new StatusChanger($this->review->find($review_id));
        $changer->setStatus($review_id, 'active');

        return redirect()->back();
    }

    /**
     * @param $items
     * @return string
     */
    public function getItemsForReview($items): string
    {
        $array = [];

        foreach ($items as $item) {
            $array[] = $item->id;
        }

        return implode(",", $array);
    }
}
