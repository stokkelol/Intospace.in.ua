<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Flash;
use Auth;
use Input;
use Redirect;
use View;
use Carbon\Carbon;
use DB;

class PostController extends Controller
{
    /**
     * backend.posts.index
     *
     * @return View
     */
    public function index()
    {
        if (Input::has('status')) {
            $query = Input::get('status');
            $posts = Post::with('category')
                ->byStatus($query)
                ->paginate(15);
        } elseif (Input::has('search')) {
            $query = Input::get('search');
            $posts = Post::with('category')
                ->where('title', 'like', '%'.$query.'%')
                ->orWhere('excerpt', 'like', '%'.$query.'%')
                ->orderBy('id', 'ASC')
                ->paginate(15);
        } else {
            $posts = Post::with('category')
                ->whereNotIn('status', ['deleted', 'refused'])
                ->groupBy('id')
                ->orderBy('id', 'desc')
                ->paginate(15);
        }

        $data = [
            'posts'         =>  $posts,
            'title'         =>  'Posts',
            'categories'    =>  Category::all(),
        ];

        return View::make('backend.posts.index', $data);
    }

    /**
     * backend.posts.create
     *
     * @return View
     */
    public function create()
    {
        $data = [
            'categories'    =>  Category::all(),
            'title'         =>  'New Post',
            'save_url'      =>  route('backend.posts.store'),
            //'post'        =>  null,
            'tags'          =>  Tag::lists('tag', 'id'),
        ];
        return View::make('backend.posts.post', $data);
    }

    /**
     * backend.posts.store
     *
     * @param Request $request
     * @param null $post_id
     * @return mixed
     */
    public function store(Request $request, $post_id = null)
    {
        $post = $this->storeOrUpdatePost($request, $post_id = null);

        if($request->hasFile('img')) {
            $image = $request->file('img');
            $this->saveImage($image);
            $post->img = $image->getClientOriginalName();
            $post->img_thumbnail = '300x300_'.$image->getClientOriginalName();
        }

        if($request->hasFile('logo')) {
          $image = $request->file('logo');
          $this->saveLogo($image);
          $post->logo = $image->getClientOriginalName();
        }

        $post->save();
        $this->syncTags($post, $request->input('tagList'));

        Flash::message('Post created!');
        return Redirect::route('backend.posts.edit', ['post_id' => $post->id]);
    }

    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);
        $data = [
            'post'  =>  $post,
        ];
        return View::make('backend.posts.show', $data);
    }

    public function edit($post_id)
    {
        $post = Post::find($post_id);
        $post->user_id = Auth::user()->id;
        $tags = Tag::lists('tag', 'id');
        $categories = Category::all();

        return View::make('backend.posts.edit', compact('tags', 'post', 'categories'));
    }

    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);
        Post::destroy($post_id);

        return redirect('backend/posts');
    }

    public function update(Request $request, $post_id)
    {
        $post = $this->storeOrUpdatePost($request, $post_id);
        $post->resluggify();

        if($request->hasFile('img')) {
            $image = $request->file('img');
            $this->saveImage($image);
            $post->img = $image->getClientOriginalName();
            $post->img_thumbnail = '300x300_'.$image->getClientOriginalName();
        }

        $post->update();

        Flash::message('Post updated!');
        return Redirect::route('backend.posts.index');
    }

    public function setCategory($post_id, $category_id)
    {
        $category = Category::find($category_id);

        if (empty($category)) {
            return Redirect::back();
        }

        $post = Post::find($post_id);
        $post->category_id = $category_id;
        $post->save();

        return Redirect::back();
    }

    /**
     * Sync the list of tags
     * @param Post $post
     * @param array $tags
     */
    public function syncTags (Post $post, array $tags)
    {
        $post->tags()->sync($tags);
    }

    public function setPostStatus($post_id, $status)
    {
        $post = Post::find($post_id);
        $post->status = $status;
        $post->save();

        return $post;
    }

    public function toDraft($post_id)
    {
        $this->setPostStatus($post_id, 'draft');
        Flash::message('Post sent to draft!');

        return Redirect::back();
    }

    public function toActive($post_id)
    {
        $this->setPostStatus($post_id, 'active');
        Flash::message('Post sent to active!');

        return Redirect::back();
    }

    public function toDeleted($post_id)
    {
        $this->setPostStatus($post_id, 'deleted');
        Flash::message('Post sent to deleted!');

        return Redirect::back();
    }

    public function setPinnedStatus($post_id, $pinned)
    {
        $post = Post::findOrFail($post_id);
        $post->is_pinned = $pinned;
        $post->save();
        return $post;
    }

    public function toPinned($post_id)
    {
        $this->setPinnedStatus($post_id, '1');
        Flash::message('Post is pinned');

        return Redirect::back();
    }

    public function toRegular($post_id)
    {
        $this->setPinnedStatus($post_id, '0');
        Flash::message('Post is unpinned');

        return Redirect::back();
    }

    public function saveImage($image)
    {
        $filename = $image->getClientOriginalName();
        $path = public_path('upload/covers/' . $filename);
        Image::make($image->getRealPath())->save($path);

        $filename2 = 'thumbnail_'.$image->getClientOriginalName();
        $path2 = public_path('upload/covers/' . $filename2);
        Image::make($image->getRealPath())->resize(300,300)->save($path2);
    }

    public function saveLogo($image)
    {
        $filename = $image->getClientOriginalName();
        $path = public_path('upload/logos/' . $filename);
        Image::make($image->getRealPath())->save($path);
    }

    public function storeOrUpdatePost(Request $request, $post_id)
    {
        $post = Post::findOrNew($post_id);
        $post->user_id = Auth::user()->id;
        $post->title = $request->input('title');
        $post->excerpt = $request->input('excerpt');
        $post->content = $request->input('content');
        $post->published_at = Carbon::now();
        $post->category_id = $request->input('category_id');
        $this->syncTags($post, $request->input('tagList'));
        $post->links = $request->input('links');
        $post->published_at = $request->input('published_at');

        return $post;
    }
}
