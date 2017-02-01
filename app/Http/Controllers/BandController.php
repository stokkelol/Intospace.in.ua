<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Band;
use DB;
use App\Repositories\Bands\BandRepository;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Http\Requests;

class BandController extends Controller
{
    protected $bandRepository;
    protected $post;
    protected $video;

    public function __construct(BandRepository $band,
                                PostRepository $post,
                                VideoRepository $video)
    {
        $this->bandRepository = $band;
        $this->postRepository = $post;
        $this->videoRepository = $video;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $bands = $this->bandRepository->getAllBandsBySearch($request->input('search'))->get();
            return view('frontend.bands.index', compact('bands'));
        }

        $bands = $this->bandRepository->getAllBands()->get();
        return view('frontend.bands.index', compact('bands'));
    }

    public function show(Request $request, $slug)
    {
        $posts = $this->getCollection($slug);
        if ($posts->count() == 1) {
            $topPost = $this->postRepository->getPostsByBandSlug($slug)->first();
            $posts = [];
        } else {
            $topPost = null;
        }
        $data = [
            'toppost'       =>  $topPost,
            'posts'         =>  $posts
        ];
        return view('frontend.main', $data);
    }

    public function getCollection($slug)
    {
        $postscollection = collect($this->postRepository->getPostsByBandSlug($slug)->get());
        $videoscollection = collect($this->videoRepository->getVideosByBandSlug($slug)->get());
        $posts = $postscollection->merge($videoscollection)->sortByDesc('published_at');

        return $posts;
    }
}
