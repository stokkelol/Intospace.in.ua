<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Band;
use Illuminate\Support\Facades\DB;
use App\Repositories\Bands\BandRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Http\Requests;
use Illuminate\View\View;

/**
 * Class BandController
 *
 * @package App\Http\Controllers
 */
class BandController extends Controller
{
    /**
     * @var BandRepository
     */
    protected $bandRepository;

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var VideoRepository
     */
    protected $videoRepository;

    /**
     * BandController constructor.
     *
     * @param BandRepository $band
     * @param PostRepository $post
     * @param VideoRepository $video
     */
    public function __construct(
        BandRepository $band,
        PostRepository $post,
        VideoRepository $video
    ) {
        $this->bandRepository = $band;
        $this->postRepository = $post;
        $this->videoRepository = $video;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request): View
    {
        if ($request->has('search')) {
            $bands = $this->bandRepository->getAllBandsBySearch($request->input('search'))->get();

            return view('frontend.bands.index', compact('bands'));
        }

        $bands = $this->bandRepository->getAllBands()->get();

        return view('frontend.bands.index', compact('bands'));
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $slug)
    {
        /** @var \App\Models\Post[] $posts */
        $posts = $this->getCollection($slug);

        if ($posts->count() == 1) {
            $topPost = $this->postRepository->getPostsByBandSlug($slug)->first();
            $posts = [];
        } else {
            $topPost = null;
        }

        $data = [
            'toppost' => $topPost,
            'posts' => $posts
        ];

        return view('frontend.main', $data);
    }

    /**
     * @param $slug
     * @return static
     */
    public function getCollection($slug)
    {
        $postscollection = collect($this->postRepository->getPostsByBandSlug($slug)->get());
        $videoscollection = collect($this->videoRepository->getVideosByBandSlug($slug)->get());
        $posts = $postscollection->merge($videoscollection)->sortByDesc('published_at');

        return $posts;
    }
}
