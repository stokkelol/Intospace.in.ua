<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Support\Services\RelatedPostsService;
use Illuminate\Http\Request;
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

        if ($request->has('search')) {
            $query = $request->get('search');
            $posts = $this->post->getPostsBySearchQuery($query)->get();
        } else {
            $posts = $this->post->getLatestPublishedPosts()->paginate(15);
        }

        $data = [
            'toppost' => $this->post->getPinnedPost()->first(),
            'posts' => $posts,
            'tags' => $this->tagRepository->getAllTags(),
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
}
