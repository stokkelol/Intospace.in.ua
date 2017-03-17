<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Models\Band;
use Illuminate\Support\Facades\Flash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Support\Images\ImageSaver;
use App\Support\Statuses\StatusChanger;

class PostController extends Controller
{
    protected $post;
    protected $category;
    protected $tag;
    protected $band;

    public function __construct(Post $post, Category $category, Tag $tag, Band $band)
    {
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
        $this->band = $band;
    }

    /**
     * backend.posts.index
     *
     * @return View
     */
    public function index(Request $request)
    {
        $posts = (new Post)->recent()->newQuery();

        if ($request->has('status')) {
            $posts = $this->post->byStatus($request->get('status'));
        }
        if ($request->exists('orderby')){
            $posts = $this->post->with('category', 'user')->orderBy('published_at', 'asc');
        }
        if ($request->has('search')) {
            $posts = $this->post->bySearchQuery($request->get('search'));
        }

        //$posts = $this->_post->recent()->paginate(15);
        $posts = $posts->with('user', 'category')->paginate(15);

        $data = [
            'posts'         =>  $posts,
            'categories'    =>  $this->category->all(),
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
            'bands'         =>  $this->band->all(),
            'categories'    =>  $this->category->all(),
            'save_url'      =>  route('backend.posts.store'),
            //'post'        =>  null,
            'tags'          =>  $this->tag->pluck('tag', 'id')
        ];

        return view('backend.posts.create', $data);
    }

    /**
     * backend.posts.store
     *
     * @param Request $request
     * @param null $post_id
     * @return mixed
     */
    public function store(StorePostRequest $request, ImageSaver $imageSaver, $post_id = null)
    {
        $post = $this->storeOrUpdatePost($request, $post_id = null);

        if ($request->hasFile('img')) {
            $imageSaver->saveCover('upload/covers/', $request->file('img'));
            $post->img = $request->file('img')->getClientOriginalName();
            $post->img_thumbnail = 'thumbnail_'.$request->file('img')->getClientOriginalName();
        }

        if ($request->hasFile('logo')) {
            $imageSaver->saveLogo('upload/logos/', $request->file('logo'));
            $post->logo = $request->file('logo')->getClientOriginalName();
        }

        $post->published_at = $request->input('published_at');
        //$post->published_at = Carbon::now();
        $post->save();
        $this->syncTags($post, $request->input('tagList'));

        flash()->message('Post created!');

        return redirect()->route('backend.posts.edit', ['post_id' => $post->id]);
    }

    public function show($post_id)
    {
        $post = $this->post->findOrFail($post_id);
        $data = [
            'post'  =>  $post,
        ];
        return view('backend.posts.show', $data);
    }

    public function edit($post_id)
    {
        $data = [
            'post'          =>  $this->post->find($post_id),
            'bands'         =>  $this->band->all(),
            'categories'    =>  $this->category->all(),
            'tags'          =>  $this->tag->pluck('tag', 'id')
        ];

        return view('backend.posts.edit', $data);
    }

    public function destroy($post_id)
    {
        $post = $this->post->findOrFail($post_id);
        $post->destroy($post_id);

        return redirect('backend/posts');
    }

    public function update(StorePostRequest $request, ImageSaver $imageSaver, $post_id)
    {
        $post = $this->storeOrUpdatePost($request, $post_id);
        $post->resluggify();

        if($request->hasFile('img')) {
            $imageSaver->saveCover('upload/covers/', $request->file('img'));
            $post->img = $request->file('img')->getClientOriginalName();
            $post->img_thumbnail = 'thumbnail_'.$request->file('img')->getClientOriginalName();
        }

        if($request->hasFile('logo')) {
            $imageSaver->saveLogo('upload/logos/', $request->file('logo'));
            $post->logo = $request->file('logo')->getClientOriginalName();
        }

        $post->updated_at = $request->input('updated_at');
        $post->published_at = $request->input('published_at');
        //dd($post);
        $post->update();

        flash()->message('Post updated!');

        return redirect()->route('backend.posts.index');
    }

    public function setCategory($post_id, $category_id)
    {
        $category = $this->category->find($category_id);

        if (empty($category)) {
            return redirect()->back();
        }

        $post = $this->post->find($post_id);
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

    protected function toDraft($post_id)
    {
        $changer = new StatusChanger($this->post->find($post_id));
        $changer->setStatus($post_id, 'draft');

        return redirect()->back();
    }

    protected function toActive($post_id)
    {
        $changer = new StatusChanger($this->post->find($post_id));
        $changer->setStatus($post_id, 'active');

        return redirect()->back();
    }

    protected function toDeleted($post_id)
    {
        $changer = new StatusChanger($this->post->find($post_id));
        $changer->setStatus($post_id, 'deleted');

        return redirect()->back();
    }

    public function setPinnedStatus($post_id, $pinned)
    {
        $post = $this->post->findOrFail($post_id);
        $post->is_pinned = $pinned;
        $post->save();

        return $post;
    }

    public function toPinned($post_id)
    {
        $this->setPinnedStatus($post_id, '1');
        flash()->message('Post is pinned');

        return redirect()->back();
    }

    public function toRegular($post_id)
    {
        $this->setPinnedStatus($post_id, '0');
        flash()->message('Post is unpinned');

        return redirect()->back();
    }

    private function storeOrUpdatePost(Request $request, $post_id)
    {
        $post = $this->post->findOrNew($post_id);
        $post->user_id = Auth::user()->id;
        $post->title = $request->input('title');
        $post->year = preg_replace('/[^0-9]/', '', $request->input('title'));
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

    public function postPreviewOnAjaxRequest(Request $request, $post_id)
    {
        $post = $this->post->findOrFail($post_id);
        $preview = $post->content;

        if ($request->ajax()) {
            return view('backend.posts.show', $preview)->renderSection('content');
        }
    }

    public function getAllUpdated()
    {
        $posts = $this->post->all();

        foreach ($posts as $post)
        {
            $post->year = preg_replace('/[^0-9]/', '', $post->title);
            $post->update();
        }

        return redirect()->back();
    }
}
