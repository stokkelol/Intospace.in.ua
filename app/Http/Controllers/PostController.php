<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $posts;

    /**
     * PostController constructor.
     * @param PostRepository $posts
     */
    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    public function index(Request $request)
    {

        if ($request->has('search')) {
          $query = $request->get('search');
          $posts = $this->posts->getPostsBySearchQuery($query);
        } else {
          $posts = $this->posts->getLatestPublishedPosts();
        }

        $data = [
            'posts'         =>  $posts,
            'app_name'      =>  'https://intospace.in.ua/',
            'tags'          =>  $this->posts->getAllTags(),
            'randposts'     =>  $this->posts->getRandomPosts()
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
            'app_name'  => 'https://intospace.in.ua/',
        ];

        return view('frontend.posts.post', $data);
    }
}
