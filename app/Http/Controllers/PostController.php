<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use App\Post;
use App\Tag;
use App\Video;
use View;
use App;
use DB;
use Input;

class PostController extends Controller
{
    /**
     * Main page
     *
     * @param string $slug
     * @return mixed
     */
    public function index(Request $request)
    {

        if ($request->has('search')) {
          $query = $request->get('search');
          $posts = $this->getPostsBySearchQuery($query);
        } else {
          $posts = $this->getLatestPublishedPosts();
        }

        $data = [
            'posts'         =>  $posts,
            'app_name'      =>  'https://intospace.in.ua/',
            'tags'          =>  $this->getAllTags(),
            'randposts'     =>  $this->getRandomPosts()
        ];

        return View::make('frontend.main', $data);
    }

    public function maintainance()
    {
      return View::make('errors.503-custom');
    }

    /**
     * Post page
     *
     * @param $slug
     * @return mixed
     */
    public function post($slug)
    {
        $post = Post::getInstance()->getBySlug($slug);

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

        return View::make('frontend.posts.post', $data);
    }

    public function getRandomPosts()
    {
        $number = 6;
        $randomposts = Post::all()->whereIn('status', ['active'])
                                  //->whereIn('category_id', ['1'])
                                  ->random($number);

        return $randomposts;
    }

    public function getPostsBySearchQuery($query)
    {
        $posts = Post::with('category', 'tags', 'user')
            ->where('title', 'like', '%'.$query.'%')
            ->orWhere('excerpt', 'like', '%'.$query,'%')
            ->whereIn('status', 'active')
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        return $posts;
    }

    public function getLatestPublishedPosts()
    {
        $posts = Post::with('category', 'tags', 'user')
            ->whereIn('status', 'active')
            ->groupBy('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        return $posts;
    }

    public function getAllTags()
    {
        $tags = Tag::with('posts')->groupBy('tag')
            ->orderBy('tag', 'asc')
            ->get();

        return $tags;
    }

}
