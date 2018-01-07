<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class SearchController
 *
 * @package App\Http\Controllers\Backend
 */
class SearchController extends Controller
{
    /**
     * @var Post
     */
    private $post;

    /**
     * SearchController constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        if ($request->has('search')) {
            $query = $request->get('search');
            $posts = $this->post->where('title', 'like', '%' . $query . '%')->orderBy('id', 'ASC')->get();
            if ($posts->count() > 0) {
                $data = [
                    'posts' => $posts,
                    'title' => 'Posts',
                    'categories' => Category::all(),
                ];
            }
        }

        return view('backend.posts.index', $data);
    }
}
