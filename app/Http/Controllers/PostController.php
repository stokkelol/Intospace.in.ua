<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Support\Services\RelatedPostsService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

/**
 * Class PostController
 *
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
    /**
     * @var Post
     */
    private $post;

    /**
     * @var Tag
     */
    private $tag;

    /**
     * PostController constructor.
     *
     * @param Post $post
     * @param Tag $tag
     */
    public function __construct(Post $post, Tag $tag)
    {
        $this->post = $post;
        $this->tag = $tag;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $posts = $this->getCollection($request);
        if ($posts->count() == 1) {
            $query = $request->get('search');
            $topPost = $this->post->bySearchQuery($query)->first();
            $posts = [];
        } else {
            $topPost = [];
        }

        $data = [
            'toppost' => $topPost,
            'posts' => $posts,
            'tags' => $this->tag->get(),
            'randposts' => $this->post->getRandomPosts()
        ];

        return view('frontend.main', $data);
    }


    /**
     * @param $slug
     * @param RelatedPostsService $related
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug, RelatedPostsService $related)
    {
        $post = $this->post->findBySlug($slug)->first();

        if ($post === null) {
            App::abort(404);
        }

        $this->incrementViews($post);
        $relatedPosts = $related->getRelatedPosts($post->tags, $post->id);

        $data = [
            'posts' => $relatedPosts,
            'post' => $post,
            'title' => $post->title,
        ];

        return view('frontend.posts.post', $data);
    }

    /**
     * @param $post
     */
    protected function incrementViews($post)
    {
        if ($post->status === 'active') {
            $post->increment('views');
        }
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function getCollection(Request $request): Collection
    {
        if ($request->has('search')) {
            $query = $request->get('search');
            $postsCollection = collect($this->post->bySearchQuery($query)->get());
            $videosCollection = collect($this->video->bySearchQuery($query)->get());

            return $postsCollection->merge($videosCollection)->sortByDesc('published_at');
        }

        $postsCollection = collect($this->post->active()->get());
        $videosCollection = collect($this->video->with('user', 'band')->latest()->get());

        return $postsCollection->merge($videosCollection)->sortByDesc('published_at');
    }
}
