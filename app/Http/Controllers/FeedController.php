<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

/**
 * Class FeedController
 *
 * @package App\Http\Controllers
 */
class FeedController extends Controller
{
    /**
     * @return mixed
     */
    public function feed() {

      $feed = App::make('feed');

      $feed->setCache(60, 'laravelFeedKey');

      if (! $feed->isCached()) {
          $posts = Post::with('category', 'tags', 'user')
              ->whereIn('status', ['active'])
              ->groupBy('published_at')
              ->orderBy('published_at', 'desc')
              ->paginate(15);

          $feed->title = 'Intospace.in.ua';
          $feed->description = 'Dark side of the music';
          $feed->logo = 'logo.jpg';
          $feed->link = url('feed');
          $feed->setDateFormat('datetime');
          $feed->upbdate = $posts[0]->published_at;
          $feed->lang = 'ru';
          $feed->setShortening(true);

          foreach ($posts as $post) {
              $feed->add($post->title, $post->user->name, URL::to($post->slug), $post->description, $post->content);
          }
      }

      return $feed->render('atom');
    }
}
