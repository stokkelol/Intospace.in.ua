<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests;
use App\Post;
use App\Tag;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;
    protected $tagRepository;

    /**
     * PostController constructor.
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $postRepository, TagRepository $tagRepository)
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
    }

    public function index(Request $request)
    {

        if ($request->has('search')) {
            $query = $request->get('search');
            $posts = $this->postRepository->getPostsBySearchQuery($query);
            } else {
            $posts = $this->postRepository->getLatestPublishedPosts();
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
     * Get single post page by slug
     *
     * @param $slug
     * @return mixed
     */
    public function show(Post $_post, $slug)
    {
        $post = $_post->getBySlug($slug);

        if($post == NULL) {
            App::abort(404);
        }

        if ($post->status == 'active') {
            $post->increment('views');
        }

        $data = [
            'post'      => $post,
            'title'     => $post->title,
        ];

        return view('frontend.posts.post', $data);
    }
}
