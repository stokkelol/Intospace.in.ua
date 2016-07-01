<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests;
use App\Post;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postrepository;
    protected $tagrepository;

    /**
     * PostController constructor.
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $postrepository, TagRepository $tagrepository)
    {
        $this->postrepository = $postrepository;
        $this->tagrepository = $tagrepository;
    }

    public function index(Request $request)
    {

        if ($request->has('search')) {
          $query = $request->get('search');
          $posts = $this->postrepository->getPostsBySearchQuery($query);
        } else {
          $posts = $this->postrepository->getLatestPublishedPosts();
        }

        $data = [
            'posts'         =>  $posts,
            'tags'          =>  $this->tagrepository->getAllTags(),
            'randposts'     =>  $this->postrepository->getRandomPosts()
        ];

        return view('frontend.main', $data);
    }

    /**
     * Custom 503 page for a little bit of maintenance
     *
     * @return mixed
     */
    public function maintenance()
    {
      return view('errors.503-custom');
    }

    /**
     * Get single post page by slug
     *
     * @param $slug
     * @return mixed
     */
    public function post(Post $_post, $slug)
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
