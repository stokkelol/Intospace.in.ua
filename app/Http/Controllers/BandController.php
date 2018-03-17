<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Band;
use Illuminate\View\View;

/**
 * Class BandController
 *
 * @package App\Http\Controllers
 */
class BandController extends Controller
{
    /**
     * @var Band
     */
    protected $band;

    /**
     * @var Post
     */
    protected $post;

    /**
     * @var Video
     */
    protected $video;

    /**
     * BandController constructor.
     *
     * @param Band $band
     * @param Post $post
     * @param Video $video
     */
    public function __construct(Band $band, Post $post, Video $video)
    {
        $this->band = $band;
        $this->post = $post;
        $this->video = $video;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request): View
    {
        if ($request->has('search')) {
            $bands = Band::query()->with('posts', 'videos')
                ->where('title', 'like', '%' . $request->get('search') . '%')
                ->orderBy('title')->get();

            return view('frontend.bands.index', compact('bands'));
        }

        $bands = Band::query()->get();

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
            $topPost = $posts->first();
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
        $postsCollection = collect($this->post->byBandSlug($slug)->get());
        $videosCollection = collect($this->video->byBandSlug($slug)->get());

        return $postsCollection->merge($videosCollection)->sortByDesc('published_at');
    }
}
