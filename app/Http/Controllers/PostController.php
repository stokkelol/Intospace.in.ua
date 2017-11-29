<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Http\Requests;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Tags\TagRepository;
use Illuminate\Http\Request;
use App\Support\Services\RelatedPostsService;

/**
 * Class PostController
 *
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
    protected $postRepository;
    protected $tagRepository;

    /**
     * PostController constructor.
     * @param PostRepository $postRepository
     * @param TagRepository $tagRepository
     */
    public function __construct(PostRepository $postRepository, TagRepository $tagRepository)
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        if ($request->has('search')) {
            $query = $request->get('search');
            $posts = $this->postRepository->getPostsBySearchQuery($query)->get();
            } else {
            $posts = $this->postRepository->getLatestPublishedPosts()->paginate(15);
        }

        $data = [
            'toppost'       =>  $this->postRepository->getPinnedPost()->first(),
            'posts'         =>  $posts,
            'tags'          =>  $this->tagRepository->getAllTags(),
            'randposts'     =>  $this->postRepository->getRandomPosts()
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
        $post = $this->postRepository->getBySlug($slug);

        if ($post == NULL) {
            App::abort(404);
        }

        $this->incrementViews($post);
        $relatedPosts = $related->getRelatedPosts($post->tags, $post->id);

        $data = [
            'posts'     =>  $relatedPosts,
            'post'      =>  $post,
            'title'     =>  $post->title,
        ];

        return view('frontend.posts.post', $data);
    }

    /**
     * @param $post
     */
    protected function incrementViews($post)
    {
        if ($post->status == 'active') {
            $post->increment('views');
        }
    }
}
