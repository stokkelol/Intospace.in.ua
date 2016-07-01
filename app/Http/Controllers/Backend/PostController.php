<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Category;
use App\Post;
use App\Tag;
use App\User;
use App\Band;
use Flash;
use Auth;
use Carbon\Carbon;
use DB;

class PostController extends Controller
{
    protected $_post;
    protected $_category;
    protected $_tag;
    protected $_band;

    public function __construct(Post $post, Category $category, Tag $tag, Band $band)
    {
        $this->_post = $post;
        $this->_category = $category;
        $this->_tag = $tag;
        $this->_band = $band;
    }


    /**
     * backend.posts.index
     *
     * @return View
     */
    public function index(Request $request)
    {
        $posts = (new Post)->newQuery();

        if ($request->has('status')) {
            $posts = $this->_post->byStatus($request->get('status'));
        } elseif ($request->exists('orderby')){
            $posts = $this->_post->with('category', 'user')->orderBy('published_at', 'asc');
        } elseif ($request->has('search')) {
            $posts = $this->_post->bySearchQuery($request->get('search'));
        } else {
            $posts = $this->_post->recent();
        }

        //$posts = $this->_post->recent()->paginate(15);
        $posts = $posts->with('user', 'category')->paginate(15);

        $data = [
            'posts'         =>  $posts,
            'title'         =>  'Posts',
            'categories'    =>  $this->_category->all(),
        ];

        return view('backend.posts.index', $data);
    }

    /**
     * backend.posts.create
     *
     * @return View
     */
    public function create()
    {
        $data = [
            'bands'         =>  $this->_band->all(),
            'categories'    =>  $this->_category->all(),
            'title'         =>  'New Post',
            'save_url'      =>  route('backend.posts.store'),
            //'post'        =>  null,
            'tags'          =>  $this->_tag->lists('tag', 'id'),
        ];
        return view('backend.posts.post', $data);
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
            $post->img_thumbnail = 'thumbnail_'.$image->getClientOriginalName();
        }

        if($request->hasFile('logo')) {
          $image = $request->file('logo');
          $this->saveLogo($image);
          $post->logo = $image->getClientOriginalName();
        }

        $post->published_at = $request->input('published_at');
        //$post->published_at = Carbon::now();
        $post->save();
        $this->syncTags($post, $request->input('tagList'));

        Flash::message('Post created!');
        return redirect()->route('backend.posts.edit', ['post_id' => $post->id]);
    }

    public function show($post_id)
    {
        $post = $this->_post->findOrFail($post_id);
        $data = [
            'post'  =>  $post,
        ];
        return view('backend.posts.show', $data);
    }

    public function edit($post_id)
    {
        $data = [
            'post'          =>  $this->_post->find($post_id),
            'bands'         =>  $this->_band->all(),
            'categories'    =>  $this->_category->all(),
            'tags'          =>  $this->_tag->lists('tag', 'id'),
        ];

        return view('backend.posts.edit', $data);
    }

    public function destroy($post_id)
    {
        $post = $this->_post->findOrFail($post_id);
        $post->destroy($post_id);

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
            $post->img_thumbnail = 'thumbnail_'.$image->getClientOriginalName();
        }

        if($request->hasFile('logo')) {
            $image = $request->file('logo');
            $this->saveLogo($image);
            $post->logo = $image->getClientOriginalName();
        }
        $post->updated_at = $request->input('updated_at');
        $post->published_at = $request->input('published_at');
        //dd($post);
        $post->update();

        Flash::message('Post updated!');
        return redirect()->route('backend.posts.index');
    }

    public function setCategory($post_id, $category_id)
    {
        $category = $this->_category->find($category_id);

        if (empty($category)) {
            return redirect()->back();
        }

        $post = $this->_post->find($post_id);
        $post->category_id = $category_id;
        $post->save();

        return redirect()->back();
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
        $post = $this->_post->find($post_id);
        $post->status = $status;
        $post->save();

        return $post;
    }

    public function toDraft($post_id)
    {
        $this->setPostStatus($post_id, 'draft');
        Flash::message('Post sent to draft!');

        return redirect()->back();
    }

    public function toActive($post_id)
    {
        $this->setPostStatus($post_id, 'active');
        Flash::message('Post sent to active!');

        return redirect()->back();
    }

    public function toDeleted($post_id)
    {
        $this->setPostStatus($post_id, 'deleted');
        Flash::message('Post sent to deleted!');

        return redirect()->back();
    }

    public function setPinnedStatus($post_id, $pinned)
    {
        $post = $this->_post->findOrFail($post_id);
        $post->is_pinned = $pinned;
        $post->save();
        return $post;
    }

    public function toPinned($post_id)
    {
        $this->setPinnedStatus($post_id, '1');
        Flash::message('Post is pinned');

        return redirect()->back();
    }

    public function toRegular($post_id)
    {
        $this->setPinnedStatus($post_id, '0');
        Flash::message('Post is unpinned');

        return redirect()->back();
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
        $post = $this->_post->findOrNew($post_id);
        $post->user_id = Auth::user()->id;
        $post->title = $request->input('title');
        $post->band_id = $request->input('band_id');
        $post->excerpt = $request->input('excerpt');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $this->syncTags($post, $request->input('tagList'));
        $post->links = $request->input('links');
        $post->video = $request->input('video');
        $post->similar = $request->input('similar');

        return $post;
    }
}
