<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Band;
use DB;
use App\Repositories\BandRepository;
use App\Repositories\PostRepository;
use App\Repositories\VideoRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use App\Http\Requests;

class BandController extends Controller
{
    protected $band;
    protected $post;
    protected $video;

    public function __construct(BandRepository $band, PostRepository $post, VideoRepository $video)
    {
        $this->band = $band;
        $this->post = $post;
        $this->video = $video;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $bands = $this->band->getAllBandsBySearch($request->input('search'))->get();
            return view('frontend.bands.index', compact('bands'));
        }

        $bands = $this->band->getAllBands()->get();
        return view('frontend.bands.index', compact('bands'));
    }

    public function show(Request $request, $slug)
    {
        $postscollection = collect($this->post->getPostsByBandSlug($slug)->get());
        $videoscollection = collect($this->video->getVideosByBandSlug($slug)->get());
        $posts = $postscollection->merge($videoscollection)->sortByDesc('published_at');

        return view('frontend.main', compact('posts'));
    }
}
