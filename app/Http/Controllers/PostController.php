<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LithiumDev\TagCloud\TagCloud;
use App\Http\Requests;
use App\Category;
use App\Post;
use App\Tag;
use App\Video;
use View;
use App;
use DB;


class PostController extends Controller
{
    /**
     * Main page
     *
     * @param string $slug
     * @return mixed
     */
    public function index($slug = '')
    {

        $posts = Post::with('category', 'tags')
                ->whereNotIn('status', ['deleted', 'refused'])
                ->groupBy('id')
                ->orderBy('id', 'desc')
                ->paginate(20);

        $randposts = $this->getRandomPosts();
        $latestposts = $this->getLatestPosts();

        $data = [
            'posts'         =>  $posts,
            'tags'          =>  Tag::with('posts')->groupBy('tag')->orderBy('tag', 'asc')->get(),
            'counttags'     =>  Tag::join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
                                    ->groupBy('tags.id')
                                    ->select(['tags.*', DB::raw('COUNT(*) as cnt')])
                                    ->orderBy('cnt', 'desc')
                                    ->get(),
            'randposts'     =>  $randposts,
            'latestposts'   =>  $latestposts,
            'app_name'      =>  'https://intospace.in.ua/',
            'videos'        =>  Video::with('user')->groupBy('id')->orderBy('id', 'desc')->take(10)->get(),
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


    /**
     * @return mixed
     */
    public function getRandomPosts()
    {
        $number = 6;
        $randomposts = Post::all()->random($number);

        return $randomposts;
    }

    public function getLatestPosts()
    {
      $latestposts = Post::latest()->take(10)->get();

      return $latestposts;
    }

    public function getPostShare() {
      $post = Post::find($id);

      if (!isset($_SERVER['HTTP_USER_AGENT']) && !preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
        $post->save();
      }

      switch($social) {
        case 'twitter' :
        $share_url = 'https://twitter.com/share/home?status=';
        $share_url .= $post['title'].''.$post->getUrl();
        break;
      }
      return Redirect::to($url);
    }
}
